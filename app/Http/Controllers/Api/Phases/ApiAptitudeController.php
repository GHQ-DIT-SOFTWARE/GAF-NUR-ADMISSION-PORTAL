<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Aptitude;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiAptitudeController extends Controller
{
   
    public function applicant_body_aptitude_test(Request $request)
    {
        $query = Applicant::with(['regions', 'branches'])->whereHas('aptitude_phase');

        // Single search query handling
        if ($request->has('search_query') && $request->input('search_query') != '') {
            $searchQuery = $request->input('search_query');
            $query->where(function ($q) use ($searchQuery) {
                $q->where('surname', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('other_names', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('commission_type', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('arm_of_service', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('sex', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        // Exact match for other fields
        if ($request->has('branch') && $request->input('branch') != '') {
            $query->where('branch', '=', $request->input('branch'));
        }

        if ($request->has('region') && $request->input('region') != '') {
            $query->where('region', '=', $request->input('region'));
        }

        if ($request->has('qualification') && $request->input('qualification') != '') {
            $query->where('qualification', '=', $request->input('qualification'));
        }

        return DataTables::of($query)
            ->addColumn('region_name', function ($applicant) {
                return $applicant->regions ? $applicant->regions->region_name : 'N/A';
            })
            ->addColumn('branch_name', function ($applicant) {
                return $applicant->branches ? $applicant->branches->branch : 'N/A';
            })
            ->addColumn('action', function ($row) {
                // Generate URL for Applicant aptitude status using Applicant's uuid
                $statusUrl = route('test.aptitude-test-status', ['uuid' => $row->uuid]);
                // Fetch the related Documentation record using applicant_id
                $aptitude = Aptitude::where('applicant_id', $row->id)->first();
                // Generate URL for updating aptitude status using the aptitude's uuid
                $statusUpdateUrl = $aptitude
                ? route('test.aptitude-test-status-update', ['uuid' => $aptitude->uuid])
                : '#'; // Fallback if no aptitude exists
                $action = '<div class="btn-group" role="group">';
                // Add the link for viewing status
                $action .= '<a href="' . $statusUrl . '" class="btn btn-info btn-sm has-ripple"><i class="feather icon-edit"></i>&nbsp;aptitude<span class="ripple ripple-animate"></span></a>';

                // Add the link for updating aptitude status (only if aptitude exists)
                if ($aptitude) {
                    $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update aptitude</a>';
                } else {
                    $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="No aptitude Available"><i class="feather icon-edit"></i>&nbsp;Update aptitude</a>';
                }

                $action .= '</div>'; // End the button group
                return $action;
            })
            ->editColumn('qualification', function ($record) {
                switch ($record->qualification) {
                    case 'DISQUALIFIED':
                        return '<span class="badge badge-danger">DISQUALIFIED</span>';
                    case 'PENDING':
                        return '<span class="badge badge-danger">PENDING</span>';
                    case 'QUALIFIED':
                        return '<span class="badge badge-success">QUALIFIED</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['action', 'qualification'])
            ->make(true);
    }

    public function master_aptitude_applicant(Request $request)
    {
        $query = Aptitude::with(['applicant', 'applicant.regions', 'applicant.branches']);
        // Define filterable fields and their corresponding request keys
        $filters = [
            'aptitude_status' => 'aptitude_status',
            'sex' => 'sex',
            'surname' => 'surname',
            'other_names' => 'other_names',
            'commission_type' => 'commission_type',
            'arm_of_service' => 'arm_of_service',
            'branch' => 'branch',
            'region' => 'region',
            'applicant_serial_number' => 'applicant_serial_number',
        ];

        // Loop through filters and apply them to the query
        foreach ($filters as $dbField => $requestKey) {
            if ($request->has($requestKey) && $request->input($requestKey) != '') {
                if (in_array($requestKey, ['aptitude_status', 'sex', 'commission_type', 'arm_of_service', 'branch', 'region'])) {
                    $query->whereHas('applicant', function ($q) use ($request, $requestKey) {
                        $q->where($requestKey, '=', $request->input($requestKey));
                    });
                } else {
                    $query->whereHas('applicant', function ($q) use ($request, $requestKey) {
                        $q->where($requestKey, 'LIKE', '%' . $request->input($requestKey) . '%');
                    });
                }
            }
        }

        return DataTables::of($query)
            ->addColumn('surname', fn($aptitude) => $aptitude->applicant->surname ?? 'N/A')
            ->addColumn('other_names', fn($aptitude) => $aptitude->applicant->other_names ?? 'N/A')
            ->addColumn('sex', fn($aptitude) => $aptitude->applicant->sex ?? 'N/A')
            ->addColumn('commission_type', fn($aptitude) => $aptitude->applicant->commission_type ?? 'N/A')
            ->addColumn('arm_of_service', fn($aptitude) => $aptitude->applicant->arm_of_service ?? 'N/A')
            ->addColumn('contact', fn($aptitude) => $aptitude->applicant->contact ?? 'N/A')
            ->addColumn('region_name', fn($aptitude) => $aptitude->applicant->regions->region_name ?? 'N/A')
            ->addColumn('branch_name', fn($aptitude) => $aptitude->applicant->branches->branch ?? 'N/A')
            ->addColumn('applicant_serial_number', fn($aptitude) => $aptitude->applicant->applicant_serial_number ?? 'N/A')
            ->addColumn('action', function ($aptitude) {
                $statusUpdateUrl = route('test.aptitude-test-status-update', ['uuid' => $aptitude->uuid]);
                $action = '<div class="btn-group" role="group">';
                $action .= $aptitude ?
                '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Status</a>' :
                '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update Not Yet</a>';
                $action .= '</div>';
                return $action;
            })
            ->editColumn('aptitude_status', function ($aptitude) {
                switch ($aptitude->aptitude_status) {
                    case 'DISQUALIFIED':
                        return '<span class="badge badge-danger">DISQUALIFIED</span>';
                    case 'PENDING':
                        return '<span class="badge badge-warning">PENDING</span>';
                    case 'QUALIFIED':
                        return '<span class="badge badge-success">QUALIFIED</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['action', 'aptitude_status'])
            ->make(true);
    }

}
