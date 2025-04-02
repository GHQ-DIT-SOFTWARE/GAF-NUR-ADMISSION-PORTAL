@extends('admin.layout.master')
@section('main')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ Main Content ] start -->
            <!-- profile header start -->
            <div class="user-profile user-card mb-4">
                <div class="card-header border-0 p-0 pb-0">
                    <div class="cover-img-block">
                        <!-- <img src="assets/images/profile/cover.jpg" alt="" class="img-fluid"> -->
                        <div class="overlay"></div>
                        <div class="change-cover">
                            <div class="dropdown">
                                <a class="drp-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="icon feather icon-camera"></i></a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#"><i
                                            class="feather icon-upload-cloud mr-2"></i>upload new</a>
                                    <a class="dropdown-item" href="#"><i class="feather icon-image mr-2"></i>from
                                        photos</a>
                                    <a class="dropdown-item" href="#"><i class="feather icon-film mr-2"></i> upload
                                        video</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="feather icon-trash-2 mr-2"></i>remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body py-0">
                    <div class="user-about-block m-0">
                        <div class="row">
                            <div class="col-md-4 text-center mt-n5">
                                <div class="profile-dp">
                                    <img class="img-radius img-fluid wid-100"
                                        src="{{ !empty($personnel->photo) ? asset('upload/profile/' . $personnel->photo) : asset('upload/no_image.jpg') }}"
                                        alt="{{ $personnel->first_name }} {{ $personnel->surname }}">
                                </div>
                                <h5 class="mb-1"> {{ $personnel->service_no }}
                                    {{ $personnel->currentRank?->getRankDisplayAttribute($personnel->arm_of_service) ?? 'Rank Unknown' }}
                                    {{ $personnel->first_name }} {{ $personnel->surname }}</h5>

                            </div>
                            <div class="col-md-8 mt-md-4">
                                <div class="row">
                                    <div class="col-md-8 mt-md-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Service Number:</strong>
                                                    {{ $personnel->service_no }}</p>
                                                <p class="mb-1"><strong>Email:</strong> {{ $personnel->email }}</p>
                                                <p class="mb-1"><strong>Phone:</strong> {{ $personnel->phone }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Present Unit:</strong>
                                                    {{ $personnel->present_units?->unit ?? 'Unknown' }}</p>
                                                <p class="mb-1"><strong>Years in Service:</strong>
                                                    {{ $personnel->years_in_service }}</p>
                                                <p class="mb-1"><strong>Branch:</strong>
                                                    {{ $personnel->branches->branch }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs profile-tabs nav-fill" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link text-reset active" id="home-tab" data-toggle="tab"
                                            href="#home" role="tab" aria-controls="home" aria-selected="true"><i
                                                class="feather icon-user mr-2"></i>Overview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-reset" id="profile-tab" data-toggle="tab" href="#profile"
                                            role="tab" aria-controls="profile" aria-selected="false"><i
                                                class="feather icon-user mr-2"></i>Promotion</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-reset" id="contact-tab" data-toggle="tab" href="#contact"
                                            role="tab" aria-controls="contact" aria-selected="false"><i
                                                class="feather icon-user mr-2"></i>Postings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-reset" id="gallery-tab" data-toggle="tab" href="#gallery"
                                            role="tab" aria-controls="gallery" aria-selected="false"><i
                                                class="feather icon-user mr-2"></i>Operations</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-reset" id="course-tab" data-toggle="tab" href="#course"
                                            role="tab" aria-controls="gallery" aria-selected="false"><i
                                                class="feather icon-user mr-2"></i>Course</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- profile header end -->

            <!-- profile body start -->
            <div class="row">
                <div class="col-md-12 order-md-2">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Personal Details</h5>
                                </div>
                                <div class="card-body border-top pro-det-edit collapse show" id="pro-det-edit-1">
                                    <div class="row">
                                        <!-- Column 1 -->
                                        <div class="col-md-3">
                                            <!-- Full Name -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Svc No:</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->service_no }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Surname</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->surname }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">First
                                                    Name</label>
                                                <div class="col-sm-8">

                                                    {{ $personnel->first_name }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Other
                                                    Names</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->other_names }}
                                                </div>
                                            </div>
                                            <!-- Gender -->

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Gender</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->sex ?? 'Not specified' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <!-- Full Name -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Blood
                                                    Group</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->blood_group }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Marital
                                                    Status:</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->marital_status }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Birth
                                                    Date</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->date_of_birth ? \Carbon\Carbon::parse($personnel->date_of_birth)->format('j F Y') : 'Not specified' }}

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Place of
                                                    Birth</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->place_of_birth }}
                                                </div>
                                            </div>
                                            <!-- Gender -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Hometown</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->hometown ?? 'Not specified' }}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <!-- Full Name -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Hometown
                                                    Region:</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->home_regions->region }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Home
                                                    District</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->hometown_district ?? '...' }}

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Tribe</label>
                                                <div class="col-sm-8">

                                                    {{ $personnel->tribe->name ?? '...' }}
                                                </div>
                                            </div>
                                            <!-- Gender -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Language
                                                    Spoken</label>
                                                <div class="col-sm-8">
                                                    @if (is_array($personnel->languages_spoken) && count($personnel->languages_spoken))
                                                        @foreach ($personnel->languages_spoken as $language)
                                                            {{ $language }}{{ !$loop->last ? ',' : '' }}
                                                        @endforeach
                                                    @else
                                                        No languages specified.
                                                    @endif
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <!-- Full Name -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Religion</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->religion }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-4 col-form-label font-weight-bolder">Denomination</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->denominations->denomination ?? '...' }}
                                                </div>
                                            </div>
                                            <!-- Gender -->
                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-4 col-form-label font-weight-bolder">Hobbies/Interest</label>
                                                <div class="col-sm-8">
                                                    @foreach ($personnel->hobbies ?? [] as $hobby)
                                                        {{ $hobby . (!$loop->last ? ',' : '') }}
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- Birth Date -->
                                        </div>
                                        <!-- Column 2 -->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Mil Info</h5>
                                </div>
                                <div class="card-body border-top pro-det-edit collapse show" id="pro-det-edit-1">
                                    <div class="row">
                                        <!-- Column 1 -->
                                        <div class="col-md-3">
                                            <!-- Full Name -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Status:</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->status ?? '...' }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Enlistment
                                                    Date:</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->enlistment_date ?? '...' }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Commission
                                                    Date:</label>
                                                <div class="col-sm-8">

                                                    {{ $personnel->commission_date ?? '...' }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Place of
                                                    Commission:</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->place_of_commission ?? '...' }}
                                                </div>
                                            </div>
                                            <!-- Gender -->

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder"> Commission
                                                    Type:</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->commission_type ?? '...' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <!-- Full Name -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Intake:</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->intake ?? '...' }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Rank on
                                                    Commission</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->commission_rank
                                                        ? $personnel->commission_rank->getCommissionRankDisplayAttribute($personnel->arm_of_service)
                                                        : '...' }}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Present
                                                    Rank:</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->currentRank?->getRankDisplayAttribute($personnel->arm_of_service) ?? 'Rank Unknown' }}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Present Rank
                                                    Date:</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->present_rank_date ?? '...' }}
                                                </div>
                                            </div>
                                            <!-- Gender -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Seniority
                                                    Date</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->seniority_date ?? '...' }}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <!-- Full Name -->
                                            @if ($personnel->commission_type == 'SSC(R)' || $personnel->commission_type == 'SMI(R)')
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label font-weight-bolder">Conversion
                                                        Seniority Date:</label>
                                                    <div class="col-sm-8">
                                                        {{ $personnel->conversion_snr_date ?? '...' }}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Branch</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->branches->branch ?? '..' }}

                                                </div>
                                            </div>
                                            @if ($personnel->arm_of_service != 'ARMY')
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label font-weight-bolder">Trade</label>
                                                    <div class="col-sm-8">

                                                        {{ $personnel->trade->trade ?? '...' }}
                                                    </div>
                                                </div>
                                            @endif
                                            <!-- Gender -->
                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-4 col-form-label font-weight-bolder">Profession</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->profession->name ?? '...' }}
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <!-- Full Name -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Organic
                                                    Unit</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->organic_unit != null ? $personnel?->organic_unit?->unit : null ?? '...' }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Present
                                                    Unit</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->present_location != null ? $personnel?->present_units?->unit : null ?? '...' }}
                                                </div>
                                            </div>
                                            <!-- Gender -->
                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-4 col-form-label font-weight-bolder">ATT/DET/LOC</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->attach_unit->name ?? '...' }}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-4 col-form-label font-weight-bolder">Appointment</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->appointments->appointment ?? '...' }}
                                                </div>
                                            </div>
                                            <!-- Birth Date -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Contact Info</h5>
                                </div>
                                <div class="card-body border-top pro-det-edit collapse show" id="pro-det-edit-1">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Primary
                                                    Phone</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->phone ?? '...' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Secondary
                                                    Phone</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->secondary_phone ?? '...' }}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Email</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->email }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bolder">Resident
                                                    Address</label>
                                                <div class="col-sm-8">
                                                    {{ $personnel->residential_address ?? '...' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Promotion</h5>
                                </div>
                                <div class="card-body">
                                    @include('admin.personnel.details.promotion_details')
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Posting</h5>
                                </div>
                                <div class="card-body">
                                    @include('admin.personnel.details.postings_details')
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Operations</h5>
                                </div>
                                <div class="card-body">
                                    @include('admin.personnel.details.operations_details')
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="course" role="tabpanel" aria-labelledby="course-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Courses</h5>
                                </div>
                                <div class="card-body">
                                    @include('admin.personnel.details.courses_details')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
