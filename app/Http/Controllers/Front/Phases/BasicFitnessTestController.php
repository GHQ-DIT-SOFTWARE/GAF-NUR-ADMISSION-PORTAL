<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\BasicFitness;
use App\Models\OutDoorLeaderless;
use Illuminate\Http\Request;

class BasicFitnessTestController extends Controller
{
    public function applicant_basicfitness()
    {
        $data = Applicant::with(['regions', 'branches'])->get();
        return view('admin.pages.phases.basicfitness.report', compact('data'));
    }
    public function master_filter_applicant_basicfitness()
    {
        $data = BasicFitness::with(['applicant.regions', 'applicant.branches'])->get();
        return view('admin.pages.phases.basicfitness.master_basicfitness', compact('data'));
    }
    public function applicant_basicfitness_status($uuid)
    {
        $applied_applicant = Applicant::with(['regions', 'branches'])->where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.phases.basicfitness.index', compact('applied_applicant'));
    }

    public function basicfitness_update($uuid)
    {
        // Retrieve the bodyselection record
        $basicfitness = BasicFitness::where('uuid', $uuid)->firstOrFail();
        $applied_applicant = Applicant::findOrFail($basicfitness->applicant_id);
        return view('admin.pages.phases.basicfitness.update', compact('applied_applicant', 'basicfitness'));
    }

    // public function store_applicant_basicfitness(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'basic_fitness_status' => 'required',
    //         'basic_fitness_remarks' => 'required',
    //     ]);
    //     $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
    //     basicfitness::create([
    //         'applicant_id' => $applied_applicant->id,
    //         'basic_fitness_status' => $validatedData['basic_fitness_status'],
    //         'basic_fitness_remarks' => $validatedData['basic_fitness_remarks'],
    //     ]);
    //     return back()->with('success', 'Status saved successfully.');
    //     // return redirect()->route('fitnesstest.applicant-basicfitness')->with('success', 'status saved successfully.');
    // }

    public function store_applicant_basicfitness(Request $request, $uuid)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'basic_fitness_status' => 'required',
            'basic_fitness_remarks' => 'required',
        ]);
        // Find the applicant by UUID
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        // Check if an basicfitness record exists for this applicant
        $basicfitness = BasicFitness::where('applicant_id', $applied_applicant->id)->first();
        // If no basicfitness record exists, return an error
        if (!$basicfitness) {
            return back()->with('error', 'No basicfitness record found for this applicant. Please check the documentation phase.');
        }
        // Check if basic_fitness_status is already set (not null)
        if (!is_null($basicfitness->basic_fitness_status)) {
            // If basic_fitness_status is already set, prevent updating and return an error
            return back()->with('error', 'Basic Fitness status has already been set and cannot be updated.');
        }
        // If basic_fitness_status is null, allow updating the record
        $basicfitness->update([
            'basic_fitness_status' => $validatedData['basic_fitness_status'],
            'basic_fitness_remarks' => $validatedData['basic_fitness_remarks'],
        ]);
        // Check if the applicant is QUALIFIED and create an entry in the next phase (BasicFitness)
        if ($validatedData['basic_fitness_status'] === 'QUALIFIED') {
            // Check if a BasicFitness record already exists for this applicant
            $outdoorleaderless = OutDoorLeaderless::where('applicant_id', $applied_applicant->id)->first();
            // If no outdoorleaderless record exists, create a new one
            if (!$outdoorleaderless) {
                OutDoorLeaderless::create([
                    'applicant_id' => $applied_applicant->id,
                    // Add any other fields you want to save in outdoorleaderless
                ]);
            }
        }
        // Redirect back with a success message
        return back()->with('success', 'Basic Fitness status updated successfully and next phase created (if qualified).');
    }

    public function confirm_applicant_basicfitness(Request $request, $uuid)
    {
        $applied_applicant = BasicFitness::where('uuid', $uuid)->first();
        if (!$applied_applicant) {
            abort(404);
        }

        if ($request->basic_fitness_status === 'DISQUALIFIED' && $applied_applicant->basic_fitness_status === 'QUALIFIED') {
            // Find and delete the corresponding Interview record
            $outdoorleaderless = OutDoorLeaderless::where('applicant_id', $applied_applicant->applicant_id)->first();
            if ($outdoorleaderless) {
                $$outdoorleaderless->delete();
            }
        }
        if ($request->basic_fitness_status === 'QUALIFIED' && $applied_applicant->basic_fitness_status === 'DISQUALIFIED') {
            // Check if an Interview record already exists for this applicant
            $outdoorleaderless = OutDoorLeaderless::where('applicant_id', $applied_applicant->applicant_id)->first();
            // If no Interview record exists, create a new one
            if (!$outdoorleaderless) {
                OutDoorLeaderless::create([
                    'applicant_id' => $applied_applicant->applicant_id,
                    // Add any other necessary fields for the Interview model
                ]);
            }
        }

        $applied_applicant->basic_fitness_status = $request->basic_fitness_status;
        $applied_applicant->basic_fitness_remarks = $request->basic_fitness_remarks;
        $applied_applicant->applicant_id = $request->applicant_id;
        $applied_applicant->save();
        return back()->with('success', 'Status saved successfully.');
        // $notification = [
        //     'message' => 'Updated Successfully',
        //     'alert-type' => 'success',
        // ];
        // return redirect()->route('fitnesstest.applicant-basicfitness')->with($notification);
    }
}
