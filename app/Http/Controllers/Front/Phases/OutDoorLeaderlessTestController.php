<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Medical;
use App\Models\OutDoorLeaderless;
use Illuminate\Http\Request;

class OutDoorLeaderlessTestController extends Controller
{
    public function applicant_outdoorlesstest()
    {
        $data = Applicant::with(['regions', 'branches'])->get();
        return view('admin.pages.phases.outdoorleaderless.report', compact('data'));
    }

    public function master_filter_applicant_outdoorlesstest()
    {
        $data = OutDoorLeaderless::with(['applicant.regions', 'applicant.branches'])->get();
        return view('admin.pages.phases.outdoorleaderless.master_outdoorleaderless', compact('data'));
    }

    public function applicant_outdoorlesstest_status($uuid)
    {
        $applied_applicant = Applicant::with(['regions', 'branches'])->where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.phases.outdoorleaderless.index', compact('applied_applicant'));
    }

    public function outdoorleaderless_update($uuid)
    {
        // Retrieve the outdoorleaderlesstest record
        $outdoorleaderlesstest = OutDoorLeaderless::where('uuid', $uuid)->firstOrFail();
        $applied_applicant = Applicant::findOrFail($outdoorleaderlesstest->applicant_id);
        return view('admin.pages.phases.outdoorleaderless.update', compact('applied_applicant', 'outdoorleaderlesstest'));
    }

    // public function store_applicant_outdoorlesstest(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'outdoorleaderless_status' => 'required',
    //         'outdoorleaderless_remarks' => 'required',
    //     ]);
    //     $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
    //     OutDoorLeaderless::create([
    //         'applicant_id' => $applied_applicant->id,
    //         'outdoorleaderless_status' => $validatedData['outdoorleaderless_status'],
    //         'outdoorleaderless_remarks' => $validatedData['outdoorleaderless_remarks'],
    //     ]);
    //     return back()->with('success', 'Status saved successfully.');
    //     // return redirect()->route('test.applicant-outdoorlesstest')->with('success', 'status saved successfully.');
    // }

    public function store_applicant_outdoorlesstest(Request $request, $uuid)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'outdoorleaderless_status' => 'required',
            'outdoorleaderless_remarks' => 'required',
        ]);
        // Find the applicant by UUID
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        // Check if an basicfitness record exists for this applicant
        $outdoorleaderless = OutDoorLeaderless::where('applicant_id', $applied_applicant->id)->first();
        // If no basicfitness record exists, return an error
        if (!$outdoorleaderless) {
            return back()->with('error', 'No Outdoorleaderless  record found for this applicant. Please check the documentation phase.');
        }
        // Check if outdoorleaderless_status is already set (not null)
        if (!is_null($outdoorleaderless->outdoorleaderless_status)) {
            // If outdoorleaderless_status is already set, prevent updating and return an error
            return back()->with('error', 'Outdoorleaderless  status has already been set and cannot be updated.');
        }
        // If outdoorleaderless_status is null, allow updating the record
        $outdoorleaderless->update([
            'outdoorleaderless_status' => $validatedData['outdoorleaderless_status'],
            'outdoorleaderless_remarks' => $validatedData['outdoorleaderless_remarks'],
        ]);
        // Check if the applicant is QUALIFIED and create an entry in the next phase (BasicFitness)
        if ($validatedData['outdoorleaderless_status'] === 'QUALIFIED') {
            // Check if a BasicFitness record already exists for this applicant
            $medicals = Medical::where('applicant_id', $applied_applicant->id)->first();
            // If no medicals record exists, create a new one
            if (!$medicals) {
                Medical::create([
                    'applicant_id' => $applied_applicant->id,
                    // Add any other fields you want to save in medicals
                ]);
            }
        }
        // Redirect back with a success message
        return back()->with('success', 'Outdoorleaderless  status updated successfully and next phase created (if qualified).');
    }

    public function confirm_applicant_outdoorlesstest(Request $request, $uuid)
    {
        $applied_applicant = OutDoorLeaderless::where('uuid', $uuid)->first();
        if (!$applied_applicant) {
            abort(404);
        }

        if ($request->outdoorleaderless_status === 'DISQUALIFIED' && $applied_applicant->outdoorleaderless_status === 'QUALIFIED') {
            // Find and delete the corresponding Interview record
            $medicals = Medical::where('applicant_id', $applied_applicant->applicant_id)->first();
            if ($medicals) {
                $$medicals->delete();
            }
        }

        if ($request->outdoorleaderless_status === 'QUALIFIED' && $applied_applicant->outdoorleaderless_status === 'DISQUALIFIED') {
            // Check if an Interview record already exists for this applicant
            $medicals = Medical::where('applicant_id', $applied_applicant->applicant_id)->first();
            // If no Interview record exists, create a new one
            if (!$medicals) {
                Medical::create([
                    'applicant_id' => $applied_applicant->applicant_id,
                    // Add any other necessary fields for the Interview model
                ]);
            }
        }
        $applied_applicant->outdoorleaderless_status = $request->outdoorleaderless_status;
        $applied_applicant->outdoorleaderless_remarks = $request->outdoorleaderless_remarks;
        $applied_applicant->applicant_id = $request->applicant_id;
        $applied_applicant->save();
        return back()->with('success', 'Status saved successfully.');
        // $notification = [
        //     'message' => 'Updated Successfully',
        //     'alert-type' => 'success',
        // ];
        // return redirect()->route('test.applicant-outdoorlesstest')->with($notification);
    }
}
