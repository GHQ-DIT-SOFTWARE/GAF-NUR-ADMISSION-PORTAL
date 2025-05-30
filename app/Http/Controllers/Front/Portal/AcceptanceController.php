<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front\Portal;

use App\Http\Controllers\Controller;
use App\Models\AgeLimit;
use App\Models\Applicant;
use App\Models\Branch;
use App\Models\Card;
use App\Models\User;
use App\Notifications\ApplicantAppliedNotification;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AcceptanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('portal');
    }

    public function preview()
    {
        $serial_number = session('serial_number');
        $card = Card::where('serial_number', $serial_number)->first();
        $applied_applicant = Applicant::with('districts', 'regions')->where('card_id', $card->id)->first();
        return view('portal.preview', compact('applied_applicant'));
    }


    public function Declaration_and_Acceptance(Request $request)
    {
        $request->validate([
            'final_checked' => 'required|in:YES',
        ]);

        $applicant = Applicant::where('card_id', $request->session()->get('card_id'))->firstOrFail();
        $disqualificationReasons = [];
        $duplicateReasons = [];

        // Ensure the declaration is accepted
        if (!$request->has('final_checked') || $request->input('final_checked') !== 'YES') {
            $disqualificationReasons[] = 'You must accept the declaration to proceed.';
        }

        // Check for BECE index number or National ID duplication
        $beceExists = DB::table('applicants')
            ->where('bece_index_number', $applicant->bece_index_number)
            ->where('id', '<>', $applicant->id)
            ->exists();

        $nationalIdExists = DB::table('applicants')
            ->where('national_identity_card', $applicant->national_identity_card)
            ->where('id', '<>', $applicant->id)
            ->exists();

        if ($request->input('final_checked') === 'YES' && ($beceExists || $nationalIdExists)) {
            $applicant->qualification = 'DISQUALIFIED';

            // Update the card status
            $applicant->load('card');
            if ($applicant->card) {
                $applicant->card->status = 1;
                $applicant->card->save();
            }

            // Invalidate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'status' => 'duplicate',
                'message' => 'Your information already exists in the portal.',
                'redirect_url' => route('applicant.already-exists')
            ]);
        }


        $applicant->final_checked = 'YES';
        $applicant->qualification = 'QUALIFIED';
        $applicant->disqualification_reason = null;
        // Generate Serial Number Based on Course
        $year = Carbon::now()->format('y'); // '25' for 2025
        $course = $applicant->cause_offers ? strtoupper($applicant->cause_offers) : 'UNKNOWN';
        $courseCode = match ($course) {
            'BSC NURSING' => 'B-NUR',
            'BSC MIDWIFERY' => 'B-MID',
            default => 'B-UNK',
        };
        // Calculate and store applicant age
        $age = Carbon::parse($applicant->date_of_birth)->age;
        $applicant->age = $age;
        // Check exam results and disqualify if necessary
        $this->checkExamResults($applicant, $disqualificationReasons);
        $this->checkResults($applicant, $disqualificationReasons);

        // Check age limits
        if (strtoupper($applicant->entrance_type) === 'REGULAR') {
            if ($age < 16 || $age > 35) {
                if ($age > 35 && empty($applicant->employer_letter)) {
                    $disqualificationReasons[] = 'Applicants above 35 years must be serving officers with letters from employers.';
                } elseif ($age < 16) {
                    $disqualificationReasons[] = 'Applicants must be at least 16 years old.';
                }
            }
        } elseif (strtoupper($applicant->entrance_type) === 'TOP UP') {
            if ($age < 16) {
                $disqualificationReasons[] = 'Applicants must be at least 16 years old.';
            }
        }

        // if ($age < 16 || $age > 35) {
        //     if ($age > 35 && empty($applicant->employer_letter)) {
        //         $disqualificationReasons[] = 'Applicants above 35 years must be serving officers with letters from employers.';
        //     } elseif ($age < 16) {
        //         $disqualificationReasons[] = 'Applicants must be at least 16 years old.';
        //     }
        // }
        // Check for mixed exam types
        $examTypes = [
            'exam_type_one',
            'exam_type_two',
            'exam_type_three',
            'exam_type_four',
            'exam_type_five',
            'exam_type_six',
        ];
        $examTypesList = array_filter(array_map(fn($type) => $applicant->$type, $examTypes));
        $examCounts = array_count_values($examTypesList);

        if (!empty($examCounts['SSSCE']) && !empty($examCounts['WASSCE'])) {
            $disqualificationReasons[] = 'A combination of SSSCE and WASSCE results is not acceptable.';
        }

        // If disqualified, save and return early
        if (!empty($disqualificationReasons)) {
            $this->disqualifyAndSave($disqualificationReasons, $applicant, $request); // ✅ Now passing 3 arguments

        }
        // Applicant is qualified - Generate Serial Number
        $applicant->load('card');
        $applicant->card->status = 1;

        // Get last assigned serial number
        $lastSerial = Applicant::where('cause_offers', $applicant->cause_offers)
            ->whereNotNull('applicant_serial_number')
            ->orderByDesc('id')
            ->value('applicant_serial_number');

        $lastNumber = 0;
        if ($lastSerial && preg_match('/\d+$/', $lastSerial, $matches)) {
            $lastNumber = (int)$matches[0];
        }

        $newNumber = str_pad((string)($lastNumber + 1), 3, '0', STR_PAD_LEFT);
        $applicantSerialNumber = "{$courseCode}-{$year}-{$newNumber}";

        $applicant->applicant_serial_number = $applicantSerialNumber;
        $applicant->card->applicant_serial_number = $applicantSerialNumber;
        $applicant->card->save();

        // Generate PDF URL
        $pdfUrl = route('applicant-pdf');
        $admins = User::where('is_admin', 1)->get();
        // Send notification to all admins
        Notification::send($admins, new ApplicantAppliedNotification($applicant));
        $this->sendQualificationSmsToApplicant($applicant, $applicantSerialNumber);
        $applicant->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Applicant is qualified.',
            'pdf_url' => $pdfUrl,
        ]);
    }
    protected function sendQualificationSmsToApplicant($applicant, $applicantSerialNumber)
    {
        if ($applicant->qualification === 'DISQUALIFIED') {
            $this->sendQualificationSms($applicant, 'Unfortunately, you have been DISQUALIFIED. Reason: ' . $applicant->disqualification_reason);
        } elseif ($applicant->qualification === 'QUALIFIED') {
            $this->sendQualificationSms($applicant, 'Your Application has been received. We are reviewing it and will notify you if you pass the checks. Thank you.');
        }
    }


    protected function disqualifyAndSave($reasons, $applicant)
    {
        $applicant->qualification = 'DISQUALIFIED';
        $applicant->disqualification_reason = implode('; ', $reasons);

        // Load the card relationship
        $applicant->load('card');

        if ($applicant->card) {
            $applicant->card->status = 1; // Set card status to 1 for Disqualified
            $applicant->card->save(); // Save the card status update
        }
        $applicant->save(); // Save applicant data
        $pdfUrl = route('applicant-pdf'); // Generate PDF URL
        $admins = User::where('is_admin', 1)->get();
        Notification::send($admins, new ApplicantAppliedNotification($applicant));
        // Send SMS for disqualification
        $this->sendQualificationSms($applicant, 'Unfortunately, you have been DISQUALIFIED. Reason: ' . $applicant->disqualification_reason);
        return response()->json([
            'status' => 'error',
            'message' => 'Applicant has been disqualified.',
            'pdf_url' => $pdfUrl,
        ]);
    }


    protected function sendQualificationSms($applicant, $message)
    {
        // Call your SMS sending function here
        send_sms($applicant->contact, $message);
    }

    // Helper method to generate branch code based on branch name
    protected function generateBranchCode($branch)
    {
        $branchWords = explode(' ', strtoupper($branch));
        $branchCode = '';
        if (count($branchWords) > 1) {
            foreach ($branchWords as $word) {
                $branchCode .= $word[0];
            }
        } else {
            $branchCode = substr($branchWords[0], 0, 1);
        }
        return $branchCode;
    }

    protected function checkResults($applicant, array &$disqualificationReasons)
    {
        $gradeMap = [
            'A1' => 1,
            'B2' => 2,
            'B3' => 3,
            'C4' => 4,
            'C5' => 5,
            'C6' => 6,
            'D7' => 7,
            'E8' => 8,
            'F9' => 9,
        ];

        $grades = [
            $applicant->wassce_subject_english_grade,
            $applicant->wassce_subject_maths_grade,
            $applicant->wassce_subject_three_grade,
            $applicant->wassce_subject_four_grade,
            $applicant->wassce_subject_five_grade,
            $applicant->wassce_subject_six_grade,
        ];

        $gradeValues = array_map(function ($grade) use ($gradeMap) {
            return $gradeMap[$grade] ?? 0; // If grade is invalid/missing, count it as 0
        }, $grades);

        $total = array_sum($gradeValues);

        if ($total > 14) {
            $disqualificationReasons[] = 'Total aggregate of six WASSCE subjects exceeds 14.';
        }
    }


    protected function checkExamResults($applicant, &$disqualificationReasons)
    {
        $examTypes = [
            'exam_type_one',
            'exam_type_two',
            'exam_type_three',
            'exam_type_four',
            'exam_type_five',
            'exam_type_six',
        ];
        // Fetch subject names from the database or predefined list
        $subjectMappings = $this->getSubjectMappings($applicant);
        $examSubjects = array_keys($subjectMappings);
        // Track failed subjects to avoid repetition
        $failedSubjects = [];
        $this->checkBeceGrades($applicant, $disqualificationReasons, $failedSubjects);
        foreach ($examTypes as $index => $examType) {
            $examTypeValue = $applicant->{$examType};
            if ($examTypeValue === 'WASSCE' || $examTypeValue === 'PRIVATE') {
                $this->checkWassceAndPrivateGrades($applicant, $subjectMappings, $disqualificationReasons, $failedSubjects);
            } elseif ($examTypeValue === 'SSSCE') {
                $this->checkALevelGrades($applicant, $subjectMappings, $disqualificationReasons, $failedSubjects);
            }
        }
    }

    protected function checkBeceGrades($applicant, &$disqualificationReasons, &$failedSubjects)
    {
        $failingGrades = ['7', '8', '9'];
        // Define subject name mapping for the BECE subjects
        $subjectNameMapping = [
            'bece_english' => $applicant->bece_english,
            'bece_mathematics' => $applicant->bece_mathematics,
            'bece_subject_three' => $applicant->bece_subject_three,
            'bece_subject_four' => $applicant->bece_subject_four,
            'bece_subject_five' => $applicant->bece_subject_five,
            'bece_subject_six' => $applicant->bece_subject_six,
        ];
        $beceSubjects = [
            'bece_english' => $applicant->bece_subject_english_grade,
            'bece_mathematics' => $applicant->bece_subject_maths_grade,
            'bece_subject_three' => $applicant->bece_subject_three_grade,
            'bece_subject_four' => $applicant->bece_subject_four_grade,
            'bece_subject_five' => $applicant->bece_subject_five_grade,
            'bece_subject_six' => $applicant->bece_subject_six_grade,
        ];

        foreach ($beceSubjects as $columnName => $grade) {
            $subjectName = $subjectNameMapping[$columnName] ?? $columnName;
            if (in_array($grade, $failingGrades)) {
                $failureMessage = "Failed $subjectName with grade $grade.";
                if (!in_array($failureMessage, $failedSubjects)) {
                    $disqualificationReasons[] = $failureMessage;
                    $failedSubjects[] = $failureMessage;
                }
            }
        }
    }

    // Fetch subject mappings from the database or a predefined list
    protected function getSubjectMappings($applicant)
    {
        return [
            'wassce_english_grade' => $applicant->wassce_english,
            'wassce_mathematics_grade' => $applicant->wassce_mathematics,
            'wassce_subject_three_grade' => $applicant->wassce_subject_three,
            'wassce_subject_four_grade' => $applicant->wassce_subject_four,
            'wassce_subject_five_grade' => $applicant->wassce_subject_five,
            'wassce_subject_six_grade' => $applicant->wassce_subject_six,
        ];
    }

    // Method to check WASSCE and PRIVATE exam grades
    protected function checkWassceAndPrivateGrades($applicant, $subjectMappings, &$disqualificationReasons, &$failedSubjects)
    {
        $failingGrades = ['D7', 'E8', 'F9'];
        foreach ($subjectMappings as $gradeField => $subjectName) {
            $grade = $applicant->{$gradeField};
            if (in_array($grade, $failingGrades)) {
                $failureMessage = "Failed $subjectName with grade $grade.";
                // Add to disqualificationReasons if not already added
                if (!in_array($failureMessage, $failedSubjects)) {
                    $disqualificationReasons[] = $failureMessage;
                    $failedSubjects[] = $failureMessage;
                }
            }
        }
    }
    // Method to check A LEVEL exam grades
    protected function checkALevelGrades($applicant, $subjectMappings, &$disqualificationReasons, &$failedSubjects)
    {
        $failingGrade = 'E';
        foreach ($subjectMappings as $gradeField => $subjectName) {
            $grade = $applicant->{$gradeField};
            if ($grade === $failingGrade) {
                $failureMessage = "Failed $subjectName with grade $grade.";
                // Add to disqualificationReasons if not already added
                if (!in_array($failureMessage, $failedSubjects)) {
                    $disqualificationReasons[] = $failureMessage;
                    $failedSubjects[] = $failureMessage;
                }
            }
        }
    }
}
