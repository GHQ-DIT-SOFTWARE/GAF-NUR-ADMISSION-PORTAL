<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Interview;
use App\Models\OfferingCourse;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Mail\QualifiedApplicantMail;
use Illuminate\Support\Facades\Mail;

class InterviewController extends Controller
{
    public function applicant_interview()
    {
        $data = Applicant::with(['regions', 'branches'])->get();
        return view('admin.pages.phases.interview.report', compact('data'));
    }

    public function applicant_interview_status($uuid)
    {
        $applied_applicant = Applicant::with(['regions', 'branches'])->where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.phases.interview.index', compact('applied_applicant'));
    }

    public function master_filter_applicant_interview()
    {
        $data = Interview::with(['applicant.regions', 'applicant.branches'])->get();
        return view('admin.pages.phases.interview.master_interview', compact('data'));
    }

    public function interview_update($uuid)
    {
        // Retrieve the interview record
        $interview = Interview::where('uuid', $uuid)->firstOrFail();
        $applied_applicant = Applicant::findOrFail($interview->applicant_id);
        return view('admin.pages.phases.interview.update', compact('applied_applicant', 'interview'));
    }


    public function store_applicant_interview(Request $request, $uuid)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'interview_status' => 'required',
            'interview_marks' => 'required',
        ]);
        // Find the applicant by UUID
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        // Check if an basicfitness record exists for this applicant
        $interview = Interview::where('applicant_id', $applied_applicant->id)->first();
        // If no basicfitness record exists, return an error
        if (!$interview) {
            return back()->with('error', 'No interview  record found for this applicant. Please check the documentation phase.');
        }
        // Check if interview_status is already set (not null)
        if (!is_null($interview->interview_status)) {
            // If interview_status is already set, prevent updating and return an error
            return back()->with('error', 'interview  status has already been set and cannot be updated.');
        }
        // If interview_status is null, allow updating the record
        $interview->update([
            'interview_status' => $validatedData['interview_status'],
            'interview_marks' => $validatedData['interview_marks'],
        ]);
        return back()->with('success', 'Applicant Interview status updated successfully.');
    }

    public function confirm_applicant_interview(Request $request, $uuid)
    {
        $applied_applicant = Interview::where('uuid', $uuid)->first();
        if (!$applied_applicant) {
            abort(404);
        }
        $applied_applicant->interview_status = $request->interview_status;
        $applied_applicant->interview_marks = $request->interview_marks;
        $applied_applicant->applicant_id = $request->applicant_id;
        $applied_applicant->save();
        return back()->with('success', 'Status saved successfully.');
    }

    // public function Interview_Qualified(Request $request)
    // {
    //     $qualifiedIds = $request->input('record_ids', []);

    //     if (!empty($qualifiedIds)) {
    //         // Update interview status
    //         Interview::whereIn('applicant_id', $qualifiedIds)->update(['interview_status' => 'QUALIFIED']);

    //         // Fetch the full applicant details
    //         $qualifiedApplicants = Interview::with('applicant')->whereIn('applicant_id', $qualifiedIds)->get();

    //         foreach ($qualifiedApplicants as $applicant) {
    //             if ($applicant->applicant) { // Ensure the relationship exists
    //                 Student::firstOrCreate(
    //                     ['index_number' => $applicant->applicant->applicant_serial_number],
    //                     [
    //                         'surname'             => $applicant->applicant->surname,
    //                         'other_names'         => $applicant->applicant->other_names,
    //                         'first_name'          => $applicant->applicant->first_name,
    //                         'sex'                 => $applicant->applicant->sex,
    //                         'contact'             => $applicant->applicant->contact,
    //                         'course'              => $applicant->applicant->course_id,
    //                         'marital_status'      => $applicant->applicant->marital_status,
    //                         'applicant_image'     => $applicant->applicant->applicant_image,
    //                         'email'               => $applicant->applicant->email,
    //                         'residential_address' => $applicant->applicant->residential_address,
    //                         'digital_address'     => $applicant->applicant->digital_address,
    //                         'date_of_birth'       => $applicant->applicant->date_of_birth,
    //                     ]
    //                 );
    //             }
    //         }
    //     }

    //     return redirect()->route('test.applicant-interview')->with([
    //         'message' => 'Applicants processed successfully!',
    //         'alert-type' => 'success'
    //     ]);
    // }


    
    public function Interview_Qualified(Request $request)
    {
        $qualifiedIds = $request->input('record_ids', []);

        if (!empty($qualifiedIds)) {
            // Update interview status
            Interview::whereIn('applicant_id', $qualifiedIds)->update(['interview_status' => 'QUALIFIED']);

            // Fetch the full applicant details
            $qualifiedApplicants = Interview::with('applicant')->whereIn('applicant_id', $qualifiedIds)->get();

            foreach ($qualifiedApplicants as $applicant) {
                if ($applicant->applicant) { // Ensure the relationship exists
                    // Find the course ID based on course name (cause_offers)
                    $course = OfferingCourse::where('cause_offers', $applicant->applicant->cause_offers)->first();
                    $courseId = $course ? $course->id : null; // Get ID or set null if not found
                    // Insert into Student table
                    Student::firstOrCreate(
                        ['index_number' => $applicant->applicant->applicant_serial_number],
                        [
                            'surname'             => $applicant->applicant->surname,
                            'other_names'         => $applicant->applicant->other_names,
                            'first_name'          => $applicant->applicant->first_name,
                            'sex'                 => $applicant->applicant->sex,
                            'contact'             => $applicant->applicant->contact,
                            'course_id'           => $courseId, // ✅ Save course ID
                            'marital_status'      => $applicant->applicant->marital_status,
                            'applicant_image'     => $applicant->applicant->applicant_image,
                            'email'               => $applicant->applicant->email,
                            'residential_address' => $applicant->applicant->residential_address,
                            'digital_address'     => $applicant->applicant->digital_address,
                            'date_of_birth'       => $applicant->applicant->date_of_birth,
                        ]
                    );
                    Mail::to($applicant->applicant->email)->send(new QualifiedApplicantMail($applicant->applicant));
                }
            }
        }

        return redirect()->route('test.applicant-interview')->with([
            'message' => 'Applicants processed successfully!',
            'alert-type' => 'success'
        ]);
    }


    public function Interview_Disqualified(Request $request)
    {
        $disqualifiedIds = $request->input('record_ids', []); // Fix parameter name

        if (!empty($disqualifiedIds)) {
            Interview::whereIn('applicant_id', $disqualifiedIds)->update(['interview_status' => 'DISQUALIFIED']);

            return response()->json(['success' => true, 'message' => 'Applicants successfully disqualified!']);
        }

        return response()->json(['success' => false, 'message' => 'No applicants selected.'], 400);
    }



    // public function Interview_Qualifled(Request $request)
    // {
    //     $recordIds = $request->input('record_ids', []);
    //     // Update selected applicants to QUALIFIED
    //     Interview::whereIn('id', $recordIds)->update(['interview_status' => 'QUALIFIED']);
    //     // Move to Student table
    //     $qualifiedApplicants = Interview::whereIn('id', $recordIds)->get();
    //     foreach ($qualifiedApplicants as $applicant) {
    //         Student::firstOrCreate(
    //             ['index_number' => $applicant->applicant_serial_number], // Prevent duplicate entries
    //             [
    //                 'surname'              => $applicant->surname,
    //                 'other_names'          => $applicant->other_names,
    //                 'first_name'           => $applicant->first_name,
    //                 'sex'                  => $applicant->sex,
    //                 'contact'              => $applicant->contact,
    //                 'course'               => $applicant->cause_offers,
    //                 'marital_status'       => $applicant->marital_status,
    //                 'applicant_image'      => $applicant->applicant_image,
    //                 'email'                => $applicant->email,
    //                 'residential_address'  => $applicant->residential_address,
    //                 'digital_address'      => $applicant->digital_address,
    //                 'date_of_birth'        => $applicant->date_of_birth,
    //             ]
    //         );
    //     }
    //     // Get all applicants who were NOT selected and mark them as DISQUALIFIED
    //     if (!empty($recordIds)) {
    //         Interview::whereNotIn('id', $recordIds)->update(['interview_status' => 'DISQUALIFIED']);
    //     } else {
    //         // If no applicants were selected, mark ALL as DISQUALIFIED
    //         Interview::query()->update(['interview_status' => 'DISQUALIFIED']);
    //     }
    //     return redirect()->route('test.applicant-interview')->with([
    //         'message' => 'Applicants processed successfully!',
    //         'alert-type' => 'success'
    //     ]);
    // }



    // public function Interviews(Request $request)
    // {
    //     // dd($request);
    //     $recordIds = $request->input('record_ids', []);

    //     // Update selected applicants to QUALIFIED and move them to Student table
    //     $qualifiedApplicants = Interview::whereIn('id', $recordIds)->get();

    //     foreach ($qualifiedApplicants as $applicant) {
    //         $applicant->update(['interview_status' => 'QUALIFIED']);
    //         // Move to Student table if not already present
    //         Student::firstOrCreate(
    //             ['index_number' => $applicant->applicant_serial_number], // Prevent duplicate entries
    //             [
    //                 'surname' => $applicant->surname,
    //                 'other_names' => $applicant->other_names,
    //                 'first_name' => $applicant->first_name,
    //                 'sex' => $applicant->sex,
    //                 'contact' => $applicant->contact,
    //                 'course' => $applicant->cause_offers,
    //                 'marital_status' => $applicant->marital_status,
    //                 'applicant_image' => $applicant->applicant_image,
    //                 'email' => $applicant->email,
    //                 'residential_address' => $applicant->residential_address,
    //                 'digital_address' => $applicant->digital_address,
    //                 'date_of_birth' => $applicant->date_of_birth,
    //             ]
    //         );
    //     }
    //     // Automatically mark unselected applicants as DISQUALIFIED
    //     Interview::whereNotIn('id', $recordIds)->update(['interview_status' => 'DISQUALIFIED']);

    //     return redirect()->route('test.applicant-interview')->with([
    //         'message' => 'Applicants processed successfully!',
    //         'alert-type' => 'success'
    //     ]);
    // }
}
