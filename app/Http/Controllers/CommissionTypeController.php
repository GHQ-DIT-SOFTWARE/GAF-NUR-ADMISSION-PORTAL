<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\CommissionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommissionTypeController extends Controller
{
    public function index()
    {
        $commissions = CommissionType::get();
        return view('admin.pages.commission_type.index', compact('commissions'));
    }

    public function Add()
    {
        return view('admin.pages.commission_type.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'commission_type' => ['required', Rule::unique('commission_types')],
        ]);
        CommissionType::create([
            'commission_type' => $request->commission_type,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('commissin.commission-type')->with($notification);
    }

    public function Edit($uuid)
    {
        $commissions = CommissionType::where('uuid', $uuid)->first();
        if (!$commissions) {
            abort(404);
        }
        return view('admin.pages.commission_type.edit', compact('commissions'));
    }

    // $pdfUrl = url('/pdf/' . $applicant->uuid);
    // return response()->json([
    //     'status' => 'success',
    //     'message' => 'Applicant is qualified.',
    //     'pdf_url' => $pdfUrl,
    // ]);

    public function Update(Request $request, $uuid)
    {
        $commissions = CommissionType::where('uuid', $uuid)->first();
        if (!$commissions) {
            abort(404);
        }
        $commissions->commission_type = $request->commission_type;
        $commissions->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('commissin.commission-type')->with($notification);
    }
    public function Delete($uuid)
    {
        $commissions = CommissionType::where('uuid', $uuid)->first();
        if (!$commissions) {
            abort(404);
        }
        $commissions->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
