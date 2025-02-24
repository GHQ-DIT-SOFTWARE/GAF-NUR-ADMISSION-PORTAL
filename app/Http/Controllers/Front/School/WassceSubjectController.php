<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\School;

use App\Http\Controllers\Controller;
use App\Models\WASSCESUBJECT;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class WassceSubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function View()
    {
        $wasscesubject = WASSCESUBJECT::latest()->get();
        return view('admin.pages.wasscesubject.index', compact('wasscesubject'));
    }

    public function Add()
    {
        return view('admin.pages.wasscesubject.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'wasscesubjects' => ['required', Rule::unique('w_a_s_s_c_e_s_u_b_j_e_c_t_s')],
        ]);
        WASSCESUBJECT::create([
            'wasscesubjects' => $request->wasscesubjects,
        ]);
        $notification = [
            'message' => 'wasscesubject Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('subject.wassce-subject-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $wasscesubject = WASSCESUBJECT::where('uuid', $uuid)->first();
        if (!$wasscesubject) {
            abort(404);
        }
        return view('admin.pages.wasscesubject.edit', compact('wasscesubject'));
    }

    public function Update(Request $request)
    {
        $wasscesubject_id = $request->uuid;
        $wasscesubject = WASSCESUBJECT::where('uuid', $wasscesubject_id)->first();
        if (!$wasscesubject) {
            abort(404);
        }
        $wasscesubject->update([
            'wasscesubjects' => $request->wasscesubjects,
            'updated_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('subject.wassce-subject-index')->with($notification);
    }

    public function Delete($uuid)
    {
        $wasscesubject = WASSCESUBJECT::where('uuid', $uuid)->first();
        if (!$wasscesubject) {
            abort(404);
        }
        $wasscesubject->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
