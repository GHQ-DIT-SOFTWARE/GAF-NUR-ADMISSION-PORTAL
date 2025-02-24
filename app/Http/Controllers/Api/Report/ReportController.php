<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{

    public function applicant_reports_table(Request $request)
    {
        $query = Applicant::with('regions')->where('qualification','QUALIFIED');
        if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
            $query->where('sex', 'LIKE', '%' . $request->input('sex'));
        }
        
        if ($request->has('surname')) {
            $query->where('surname', 'LIKE', '%' . $request->input('surname') . '%');
        }
        if ($request->has('other_names')) {
            $query->where('other_names', 'LIKE', '%' . $request->input('other_names') . '%');
        }
        if ($request->has('cause_offers')) {
            $query->where('cause_offers', 'LIKE', '%' . $request->input('cause_offers') . '%');
        }
       
        if ($request->has('region')) {
            $query->where('region', 'LIKE', '%' . $request->input('region') . '%');
        }
        if ($request->has('qualification')) {
            $query->where('qualification', 'LIKE', '%' . $request->input('qualification') . '%');
        }
        if ($request->has('applicant_serial_number')) {
            $query->where('applicant_serial_number', 'LIKE', '%' . $request->input('applicant_serial_number') . '%');
        }
        
        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                $pdfUrl = route('report.admin-applicant-pdf', ['uuid' => $row->uuid]);
                $viewPhasesUrl = route('report.applicant.view', ['uuid' => $row->uuid]);
                $deleteUrl = route('report.delete-applicant', ['uuid' => $row->uuid]);
    
                $beceUrl = asset($row->bece_certificate);
                $wassceUrl = asset($row->wassce_certificate);
    
                return '<a href="' . $pdfUrl . '" class="btn btn-primary btn-sm" target="_blank">Applicant Info(PDF)</a>
                        <a href="' . $viewPhasesUrl . '" class="btn btn-secondary btn-sm">View Phases</a>
                        <a href="' . $deleteUrl . '" class="btn btn-danger btn-sm" id="delete">Delete</a>
                        <a href="' . $beceUrl . '" class="btn btn-info btn-sm" target="_blank">BECE CERT</a>
                        <a href="' . $wassceUrl . '" class="btn btn-success btn-sm" target="_blank">WASSCE CERT</a>';
            })
            ->editColumn('qualification', function ($record) {
                switch ($record->qualification) {
                    case 'DISQUALIFIED':
                        return '<span class="badge badge-danger">DISQUALIFIED</span>';
                    case 'QUALIFIED':
                        return '<span class="badge badge-success">QUALIFIED</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['action', 'qualification'])
            ->make(true);
    }

}
