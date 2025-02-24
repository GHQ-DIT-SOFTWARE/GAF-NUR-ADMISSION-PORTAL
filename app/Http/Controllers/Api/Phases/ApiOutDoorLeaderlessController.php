<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\OutDoorLeaderless;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiOutDoorLeaderlessController extends Controller
{
    // public function applicant_outdoorleaderless(Request $request)
    // {
    //     $query = Applicant::with(['regions', 'branches'])->whereHas('outdoorfitness_phase');
    //     // Exact match for sex
    //     if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
    //         $query->where('sex', '=', $request->input('sex'));
    //     }
    //     // Partial match for surname
    //     if ($request->has('surname') && $request->input('surname') != '') {
    //         $query->where('surname', 'LIKE', '%' . $request->input('surname') . '%');
    //     }
    //     // Partial match for other names
    //     if ($request->has('other_names') && $request->input('other_names') != '') {
    //         $query->where('other_names', 'LIKE', '%' . $request->input('other_names') . '%');
    //     }
    //     // Exact match for commission type
    //     if ($request->has('commission_type') && $request->input('commission_type') != '') {
    //         $query->where('commission_type', '=', $request->input('commission_type'));
    //     }
    //     // Exact match for arm of service
    //     if ($request->has('arm_of_service') && $request->input('arm_of_service') != '') {
    //         $query->where('arm_of_service', '=', $request->input('arm_of_service'));
    //     }
    //     // Exact match for branch
    //     if ($request->has('branch') && $request->input('branch') != '') {
    //         $query->where('branch', '=', $request->input('branch'));
    //     }
    //     // Exact match for region
    //     if ($request->has('region') && $request->input('region') != '') {
    //         $query->where('region', '=', $request->input('region'));
    //     }
    //     // Exact match for qualification
    //     if ($request->has('qualification') && $request->input('qualification') != '') {
    //         $query->where('qualification', '=', $request->input('qualification'));
    //     }
    //     // Partial match for applicant serial number
    //     if ($request->has('applicant_serial_number') && $request->input('applicant_serial_number') != '') {
    //         $query->where('applicant_serial_number', 'LIKE', '%' . $request->input('applicant_serial_number') . '%');
    //     }
    //     return DataTables::of($query)
    //         ->addColumn('region_name', function ($applicant) {
    //             return $applicant->regions ? $applicant->regions->region_name : 'N/A';
    //         })
    //         ->addColumn('branch_name', function ($applicant) {
    //             return $applicant->branches ? $applicant->branches->branch : 'N/A';
    //         })
    //         ->addColumn('action', function ($row) {
    //             // Generate URL for Applicant bodyselec status using Applicant's uuid
    //             $statusUrl = route('test.outdoorlesstest-status', ['uuid' => $row->uuid]);
    //             // Fetch the related bodyselec record using applicant_id
    //             $outdoorleaderlesstest = OutDoorLeaderless::where('applicant_id', $row->id)->first();
    //             // Generate URL for updating bodyselec status using the bodyselec's uuid
    //             $statusUpdateUrl = $outdoorleaderlesstest
    //             ? route('test.outdoorlesstest-status-update', ['uuid' => $outdoorleaderlesstest->uuid])
    //             : '#'; // Fallback if no bodyselec exists
    //             $action = '<div class="btn-group" role="group">';
    //             // Add the link for viewing status
    //             $action .= '<a href="' . $statusUrl . '" class="btn btn-info btn-sm has-ripple"><i class="feather icon-edit"></i>&nbsp;Outdoor Test<span class="ripple ripple-animate"></span></a>';
    //             // Add the link for updating bodyselec status (only if bodyselec exists)
    //             if ($outdoorleaderlesstest) {
    //                 $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Status</a>';
    //             } else {
    //                 $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Not Yet</a>';
    //             }

    //             $action .= '</div>'; // End the button group
    //             return $action;
    //         })

    //         ->editColumn('qualification', function ($record) {
    //             switch ($record->qualification) {
    //                 case 'DISQUALIFIED':
    //                     return '<span class="badge badge-danger">DISQUALIFIED</span>';
    //                     case 'PENDING':
    //                         return '<span class="badge badge-warning">PENDING</span>';
    //                 case 'QUALIFIED':
    //                     return '<span class="badge badge-success">QUALIFIED</span>';
    //                 default:
    //                     return '';
    //             }
    //         })
    //         ->rawColumns(['action', 'qualification'])
    //         ->make(true);
    // }

    public function applicant_outdoorleaderless(Request $request)
    {
        $query = Applicant::with(['regions', 'branches'])
            ->whereHas('outdoorfitness_phase');
        // Check if there's a search query
        if ($request->has('search_query') && $request->input('search_query') !== '') {
            $searchQuery = $request->input('search_query');
            // Use `orWhere` to allow searching by multiple fields
            $query->where(function ($q) use ($searchQuery) {
                $q->where('applicant_serial_number', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('surname', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('other_names', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('commission_type', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('arm_of_service', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhereHas('branches', function ($branchQuery) use ($searchQuery) {
                        $branchQuery->where('branch', 'LIKE', '%' . $searchQuery . '%');
                    })
                    ->orWhereHas('regions', function ($regionQuery) use ($searchQuery) {
                        $regionQuery->where('region_name', 'LIKE', '%' . $searchQuery . '%');
                    });
            });
        }
        // Define other filters based on individual fields if needed
        $filters = [
            'sex' => 'sex',
            // other filters can be added here if necessary
        ];
        // Loop through each filter and apply to the query
        foreach ($filters as $input => $column) {
            if ($request->has($input) && $request->input($input) !== '') {
                $query->where($column, '=', $request->input($input));
            }
        }
        return DataTables::of($query)
            ->addColumn('region_name', function ($applicant) {
                return $applicant->regions ? $applicant->regions->region_name : 'N/A';
            })
            ->addColumn('branch_name', function ($applicant) {
                return $applicant->branches ? $applicant->branches->branch : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $statusUrl = route('test.outdoorlesstest-status', ['uuid' => $row->uuid]);
                $outdoorleaderlesstest = OutDoorLeaderless::where('applicant_id', $row->id)->first();
                $statusUpdateUrl = $outdoorleaderlesstest
                ? route('test.outdoorlesstest-status-update', ['uuid' => $outdoorleaderlesstest->uuid])
                : '#';

                $action = '<div class="btn-group" role="group">';
                $action .= '<a href="' . $statusUrl . '" class="btn btn-info btn-sm has-ripple"><i class="feather icon-edit"></i>&nbsp;Outdoor Test<span class="ripple ripple-animate"></span></a>';
                if ($outdoorleaderlesstest) {
                    $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Status</a>';
                } else {
                    $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Not Yet</a>';
                }
                $action .= '</div>';

                return $action;
            })
            ->editColumn('qualification', function ($record) {
                switch ($record->qualification) {
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
            ->rawColumns(['action', 'qualification'])
            ->make(true);
    }

    // public function master_outdoorleader_applicant(Request $request)
    // {
    //     $query = OutDoorLeaderless::with(['applicant', 'applicant.regions', 'applicant.branches']);
    //     // Filter by vetting status (QUALIFIED or DISQUALIFIED)
    //     if ($request->has('outdoorleaderless_status') && in_array($request->input('outdoorleaderless_status'), ['QUALIFIED', 'DISQUALIFIED'])) {
    //         $query->where('outdoorleaderless_status', '=', $request->input('outdoorleaderless_status'));
    //     }

    //     // Filter by applicant's sex
    //     if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('sex', '=', $request->input('sex'));
    //         });
    //     }

    //     // Filter by applicant's surname
    //     if ($request->has('surname') && $request->input('surname') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('surname', 'LIKE', '%' . $request->input('surname') . '%');
    //         });
    //     }

    //     // Filter by applicant's other names
    //     if ($request->has('other_names') && $request->input('other_names') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('other_names', 'LIKE', '%' . $request->input('other_names') . '%');
    //         });
    //     }

    //     // Filter by applicant's commission type
    //     if ($request->has('commission_type') && $request->input('commission_type') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('commission_type', '=', $request->input('commission_type'));
    //         });
    //     }

    //     // Filter by applicant's arm of service
    //     if ($request->has('arm_of_service') && $request->input('arm_of_service') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('arm_of_service', '=', $request->input('arm_of_service'));
    //         });
    //     }

    //     // Filter by applicant's branch
    //     if ($request->has('branch') && $request->input('branch') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('branch', '=', $request->input('branch'));
    //         });
    //     }

    //     // Filter by applicant's region
    //     if ($request->has('region') && $request->input('region') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('region', '=', $request->input('region'));
    //         });
    //     }

    //     // Filter by applicant's serial number
    //     if ($request->has('applicant_serial_number') && $request->input('applicant_serial_number') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('applicant_serial_number', 'LIKE', '%' . $request->input('applicant_serial_number') . '%');
    //         });
    //     }

    //     return DataTables::of($query)
    //         ->addColumn('surname', function ($outdoorleaderlesstest) {
    //             return $outdoorleaderlesstest->applicant->surname ?? 'N/A';
    //         })
    //         ->addColumn('other_names', function ($outdoorleaderlesstest) {
    //             return $outdoorleaderlesstest->applicant->other_names ?? 'N/A';
    //         })
    //         ->addColumn('sex', function ($outdoorleaderlesstest) {
    //             return $outdoorleaderlesstest->applicant->sex ?? 'N/A';
    //         })
    //         ->addColumn('commission_type', function ($outdoorleaderlesstest) {
    //             return $outdoorleaderlesstest->applicant->commission_type ?? 'N/A';
    //         })
    //         ->addColumn('arm_of_service', function ($outdoorleaderlesstest) {
    //             return $outdoorleaderlesstest->applicant->arm_of_service ?? 'N/A';
    //         })
    //         ->addColumn('contact', function ($outdoorleaderlesstest) {
    //             return $outdoorleaderlesstest->applicant->contact ?? 'N/A';
    //         })
    //         ->addColumn('region_name', function ($outdoorleaderlesstest) {
    //             return $outdoorleaderlesstest->applicant->regions->region_name ?? 'N/A';
    //         })
    //         ->addColumn('branch_name', function ($outdoorleaderlesstest) {
    //             return $outdoorleaderlesstest->applicant->branches->branch ?? 'N/A';
    //         })
    //         ->addColumn('applicant_serial_number', function ($outdoorleaderlesstest) {
    //             return $outdoorleaderlesstest->applicant->applicant_serial_number ?? 'N/A';
    //         })
    //         ->addColumn('action', function ($outdoorleaderlesstest) {
    //             $statusUpdateUrl = $outdoorleaderlesstest ? route('test.outdoorlesstest-status-update', ['uuid' => $outdoorleaderlesstest->uuid]) : '#';
    //             $action = '<div class="btn-group" role="group">';
    //             if ($outdoorleaderlesstest) {
    //                 $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Status</a>';
    //             } else {
    //                 $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update Not Yet</a>';
    //             }
    //             $action .= '</div>';
    //             return $action;
    //         })
    //         ->editColumn('outdoorleaderless_status', function ($outdoorleaderlesstest) {
    //             switch ($outdoorleaderlesstest->outdoorleaderless_status) {
    //                 case 'DISQUALIFIED':
    //                     return '<span class="badge badge-danger">DISQUALIFIED</span>';
    //                     case 'PENDING':
    //                         return '<span class="badge badge-warning">PENDING</span>';
    //                 case 'QUALIFIED':
    //                     return '<span class="badge badge-success">QUALIFIED</span>';
    //                 default:
    //                     return '';
    //             }
    //         })
    //         ->rawColumns(['action', 'outdoorleaderless_status'])
    //         ->make(true);
    // }

    public function master_outdoorleader_applicant(Request $request)
    {
        $query = OutDoorLeaderless::with(['applicant', 'applicant.regions', 'applicant.branches']);
        // Filter by vetting status (QUALIFIED or DISQUALIFIED)
        if ($request->has('outdoorleaderless_status') && in_array($request->input('outdoorleaderless_status'), ['QUALIFIED', 'DISQUALIFIED'])) {
            $query->where('outdoorleaderless_status', '=', $request->input('outdoorleaderless_status'));
        }
        // Check for a search query
        if ($request->has('search_query') && $request->input('search_query') !== '') {
            $searchQuery = $request->input('search_query');
            // Use `whereHas` for searching through applicant fields
            $query->whereHas('applicant', function ($q) use ($searchQuery) {
                $q->where(function ($query) use ($searchQuery) {
                    $query->where('applicant_serial_number', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('surname', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('other_names', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('commission_type', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('arm_of_service', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhereHas('branches', function ($branchQuery) use ($searchQuery) {
                            $branchQuery->where('branch', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('regions', function ($regionQuery) use ($searchQuery) {
                            $regionQuery->where('region_name', 'LIKE', '%' . $searchQuery . '%');
                        });
                });
            });
        }
        // Common filtering for applicant-related fields
        $applicantFilters = [
            'sex' => 'sex',
            // Add other filters as needed
        ];
        foreach ($applicantFilters as $input => $field) {
            if ($request->has($input) && $request->input($input) != '') {
                $query->whereHas('applicant', function ($q) use ($input, $field, $request) {
                    $q->where($field, '=', $request->input($input));
                });
            }
        }
        return DataTables::of($query)
            ->addColumn('surname', function ($outdoorleaderlesstest) {
                return $outdoorleaderlesstest->applicant->surname ?? 'N/A';
            })
            ->addColumn('other_names', function ($outdoorleaderlesstest) {
                return $outdoorleaderlesstest->applicant->other_names ?? 'N/A';
            })
            ->addColumn('sex', function ($outdoorleaderlesstest) {
                return $outdoorleaderlesstest->applicant->sex ?? 'N/A';
            })
            ->addColumn('commission_type', function ($outdoorleaderlesstest) {
                return $outdoorleaderlesstest->applicant->commission_type ?? 'N/A';
            })
            ->addColumn('arm_of_service', function ($outdoorleaderlesstest) {
                return $outdoorleaderlesstest->applicant->arm_of_service ?? 'N/A';
            })
            ->addColumn('contact', function ($outdoorleaderlesstest) {
                return $outdoorleaderlesstest->applicant->contact ?? 'N/A';
            })
            ->addColumn('region_name', function ($outdoorleaderlesstest) {
                return $outdoorleaderlesstest->applicant->regions->region_name ?? 'N/A';
            })
            ->addColumn('branch_name', function ($outdoorleaderlesstest) {
                return $outdoorleaderlesstest->applicant->branches->branch ?? 'N/A';
            })
            ->addColumn('applicant_serial_number', function ($outdoorleaderlesstest) {
                return $outdoorleaderlesstest->applicant->applicant_serial_number ?? 'N/A';
            })
            ->addColumn('action', function ($outdoorleaderlesstest) {
                $statusUpdateUrl = route('test.outdoorlesstest-status-update', ['uuid' => $outdoorleaderlesstest->uuid]);
                $action = '<div class="btn-group" role="group">';
                $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Status</a>';
                $action .= '</div>';
                return $action;
            })
            ->editColumn('outdoorleaderless_status', function ($outdoorleaderlesstest) {
                switch ($outdoorleaderlesstest->outdoorleaderless_status) {
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
            ->rawColumns(['action', 'outdoorleaderless_status'])
            ->make(true);
    }

}
