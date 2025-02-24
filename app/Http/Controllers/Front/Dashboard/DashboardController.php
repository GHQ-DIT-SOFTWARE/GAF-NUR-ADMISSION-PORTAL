<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Applicant;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function welcomedashboard()
    {
        return view('admin.pages.homedash');
    }

    public function index()
    {
        $applicants = Applicant::count();
        $applicants_qualified = Applicant::where('qualification', 'QUALIFIED')->count();
        $applicants_disqualified = Applicant::where('qualification', 'DISQUALIFIED')->count();
        $applicants_bsc_nursing = Applicant::where('cause_offers', 'BSC NURSING')->count();
        $applicants_bcs_midwifery = Applicant::where('cause_offers', 'BSC MIDWIFERY')->count();
        $chartData = [
            'labels' => ['BSC MIDWIFERY', 'BSC NURSING'],
            'datasets' => [
                [
                    'data' => [$applicants_bsc_nursing, $applicants_bcs_midwifery],
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                ],
            ],
        ];
        return view('admin.layout.index', compact('applicants', 'applicants_bsc_nursing', 'applicants_bcs_midwifery', 'chartData', 'applicants_qualified', 'applicants_disqualified'));
    }
    
}
