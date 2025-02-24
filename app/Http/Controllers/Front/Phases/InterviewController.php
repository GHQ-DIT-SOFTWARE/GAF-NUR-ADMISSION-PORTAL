<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Interview;
use Illuminate\Http\Request;

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

    // public function store_applicant_interview(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'interview_status' => 'required',
    //         'interview_marks' => 'required',
    //     ]);
    //     $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
    //     Interview::create([
    //         'applicant_id' => $applied_applicant->id,
    //         'interview_status' => $validatedData['interview_status'],
    //         'interview_marks' => $validatedData['interview_marks'],
    //     ]);
    //     return back()->with('success', 'Status saved successfully.');
    //     // return redirect()->route('test.applicant-interview')->with('success', 'status saved successfully.');
    // }

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
        // $notification = [
        //     'message' => 'Updated Successfully',
        //     'alert-type' => 'success',
        // ];
        // return redirect()->route('test.applicant-interview')->with($notification);
    }
}
