@extends('admin.layout.master')
@section('title')
    Analysis Dashboard
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- 18570a --}}
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-yellow">{{ $total_applicants }}</h4>
                            <h6 class="text-muted m-b-0">TOTAL APPLICANTS</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-bar-chart-2 f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-yellow">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">TOTAL APPLICANTS</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">{{ $qualified_bsc_midwifery}}</h4>
                            <h6 class="text-muted m-b-0">BSC MIDWIFERY</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-file-text f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-green">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">TOTAL BSC MIDWIFERY</p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-up text-white f-16"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">{{ $qualified_bsc_nursing }}</h4>
                            <h6 class="text-muted m-b-0">BSC NURSING</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-file-text f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-green">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">TOTAL BSC NURSING</p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-up text-white f-16"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-black">{{ $incomplete_applications }}</h4>
                            <h6 class="text-muted m-b-0">INCOMPLETE APP</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-calendar f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-dark">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">INCOMPLETE APP</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Applicant Distribution by Arm of Service</h5>
                </div>
                <div class="card-body" style="height:250px;width:400px;">
                    <canvas id="applicantsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12">
            <div class="card bg-c-yellow text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white">{{ $total_qualified_courses }}</h2>
                    <h6 class="text-white">TOTAL QUALIFIED APPLICANTS</h6>
                    <i class="feather icon-file-text"></i>
                </div>
            </div>

            <div class="card bg-c-red text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white">{{ $total_disqualified_courses }}</h2>
                    <h6 class="text-white">TOTAL DISQUALIFIED APPICANTS</h6>
                    <i class="feather icon-award"></i>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('applicantsChart').getContext('2d');
        const chartData = @json($chartData);
        new Chart(ctx, {
            type: 'pie',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    </script>
@endsection
