<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Aptitude;
use App\Models\Interview;
use App\Imports\AptitudeImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AptitudeController extends Controller
{
    public function applicant_aptitude()
    {
        $data = Applicant::get();
        return view('admin.pages.phases.aptitude.report', compact('data'));
    }
    public function master_filter_applicant_aptitude()
    {
        $data = Aptitude::get();
        return view('admin.pages.phases.aptitude.master_aptitude', compact('data'));
    }

    public function applicant_aptitude_status($uuid)
    {
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.phases.aptitude.index', compact('applied_applicant'));
    }

    public function aptitude_update($uuid)
    {
        // Retrieve the aptitude record
        $aptitude = Aptitude::where('uuid', $uuid)->firstOrFail();
        $applied_applicant = Applicant::findOrFail($aptitude->applicant_id);
        return view('admin.pages.phases.aptitude.update', compact('applied_applicant', 'aptitude'));
    }

   
    public function store_applicant_aptitude(Request $request, $uuid)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'aptitude_status' => 'required',
            'aptitude_marks' => 'required',
        ]);
        // Find the applicant by UUID
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        // Check if an Aptitude record exists for this applicant
        $aptitude = Aptitude::where('applicant_id', $applied_applicant->id)->first();
        if (!$aptitude) {
            return back()->with('error', 'No Aptitude record found for this applicant. Please check the documentation phase.');
        }
        if (!is_null($aptitude->aptitude_status)) {
            // If aptitude_status is already set, prevent updating and return an error
            return back()->with('error', 'Aptitude status has already been set and cannot be updated.');
        }
        $aptitude->update([
            'aptitude_status' => $validatedData['aptitude_status'],
            'aptitude_marks' => $validatedData['aptitude_marks'],
        ]);
        // Check if the applicant is QUALIFIED and create an entry in the next phase (BasicFitness)
        if ($validatedData['aptitude_status'] === 'QUALIFIED') {
            // Check if a BasicFitness record already exists for this applicant
            $interview = Interview::where('applicant_id', $applied_applicant->id)->first();
            // If no interview record exists, create a new one
            if (!$interview) {
                Interview::create([
                    'applicant_id' => $applied_applicant->id,
                    // Add any other fields you want to save in interview
                ]);
            }
        }
        // Redirect back with a success message
        return back()->with('success', 'Aptitude status updated successfully and next phase created (if qualified).');
    }

    public function confirm_applicant_aptitude(Request $request, $uuid)
    {
        $applied_applicant = Aptitude::where('uuid', $uuid)->first();
        if (!$applied_applicant) {
            abort(404);
        }
        if (!$applied_applicant->aptitude_phase) {
            // Handle the missing phase, maybe redirect or show an error message
            return redirect()->back()->withErrors('Aptitude phase not found.');
        }
        if ($request->aptitude_status === 'DISQUALIFIED' && $applied_applicant->aptitude_status === 'QUALIFIED') {
            // Find and delete the corresponding Interview record
            $interview = Interview::where('applicant_id', $applied_applicant->applicant_id)->first();
            if ($interview) {
                $interview->delete();
            }
        }
        if ($request->aptitude_status === 'QUALIFIED' && $applied_applicant->aptitude_status === 'DISQUALIFIED') {
            // Check if an Interview record already exists for this applicant
            $interview = Interview::where('applicant_id', $applied_applicant->applicant_id)->first();
            // If no Interview record exists, create a new one
            if (!$interview) {
                Interview::create([
                    'applicant_id' => $applied_applicant->applicant_id,
                    // Add any other necessary fields for the Interview model
                ]);
            }
        }
        $applied_applicant->aptitude_status = $request->aptitude_status;
        $applied_applicant->aptitude_marks = $request->aptitude_marks;
        $applied_applicant->applicant_id = $request->applicant_id;
        $applied_applicant->save();
        return back()->with('success', 'Status saved successfully.');
        // $notification = [
        //     'message' => 'Updated Successfully',
        //     'alert-type' => 'success',
        // ];
        // return redirect()->route('test.applicant-aptitude-test')->with($notification);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new AptitudeImport, $request->file('file'));
        return redirect()->back()->with('success', 'Aptitude data imported successfully.');
    }
}
