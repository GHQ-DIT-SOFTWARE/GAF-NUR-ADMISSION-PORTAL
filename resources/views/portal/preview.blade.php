@extends('portal.master')
@section('content')
    <style>
        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .input_container {
            border: 1px solid #e5e5e5;
            /* height: 42px; */
        }

        input[type=file]::file-selector-button {
            background-color: #fff;
            color: #000;
            border: 0px;
            border-right: 1px solid #e5e5e5;
            /* padding: 10px 15px; */
            margin-right: 10px;
            transition: .5s;

        }

        input[type=file]::file-selector-button:hover {
            background-color: #eee;
            border: 0px;
            border-right: 1px solid #e5e5e5;
        }

        #img-upload {
            /* width: 255px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                height: 220px; */
            width: 100%;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

    <body
        class=""style="background-image: url('assets/images/nav-bg/body-bg-9.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;">
        <section class="pcoded-apply-container">
            <div class="pcoded-content">
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <nav class="navbar justify-content-between p-0 align-items-center">
                                        <h5>Home</h5>
                                        <div class="input-group" style="width: auto;">
                                            <div class="col text-right">
                                                <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-link"
                                                            style="color: white;">Cancel Application</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </nav>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!"> COURSE SELECTED:
                                            {{ $applied_applicant->cause_offers}}
                                          </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 style="text-align: center; font-family: Arial Black, Helvetica, sans-serif;">
                                    GHANA ARMED FORCES - ONLINE ENLISTMENT PORTAL
                                </h4>
                                <marquee behavior="scroll" direction="left" scrollamount="2"
                                    style="font-family: Arial, sans-serif; font-size: 16px; color: #ff0000; font-weight: bold; text-transform: uppercase;">
                                    PLEASE COMPLETE THE VARIOUS FORMS BY CLICKING "NEXT" TO COMPLETE YOUR APPLICATION.
                                </marquee>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Application Form</h5>
                            </div>
                            <div class="card-body" style="margin-left: 2cm; margin-right: 2cm;">
                                <div class="bt-wizard" id="progresswizard">
                                    <ul class="nav nav-pills nav-fill mb-3"
                                        style="text-align: center; font-family: Arial Black, Helvetica, sans-serif;">
                                        <li class="nav-item"><a href="#b-w-tab4" class="nav-link"
                                                data-toggle="tab">PREVIEW</a></li>
                                        <li class="nav-item"><a href="{{ route('bio-data') }}" class="nav-link">BIO
                                                DATA
                                                DETAILS (AMEDMENT)</a></li>
                                        <li class="nav-item"><a href="{{ route('education-details') }}"
                                                class="nav-link">EDUCATIONAL
                                                DETAILS (AMEDMENT)</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="b-w-tab4">
                                            <div class="text-center">
                                                <div class="alert alert-danger" role="alert">
                                                    <h5>Carefully review the information you provided below. Once
                                                        submitted it cannot be changed.</h5>
                                                </div>
                                                <hr>
                                                <h4 class="text-center"
                                                    style="font-weight: bolder;text-transform: uppercase; margin-top: 20px; margin-bottom: 20px;">
                                                    Details of Application
                                                </h4>
                                                <hr>
                                                @php
                                                    $imagePath = public_path($applied_applicant->applicant_image);
                                                @endphp
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <td>
                                                            @if (file_exists($imagePath))
                                                                <img id="showImage"
                                                                    src="{{ asset($applied_applicant->applicant_image) }}"
                                                                    alt="" width="200px" class="img-thumbnail">
                                                            @else
                                                                <img id="showImage"
                                                                    src="{{ asset('assets/images/img_placeholder_avatar.jpg') }}"
                                                                    alt="" width="200px" class="img-thumbnail">
                                                            @endif
                                                        </td>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="container" id="printTable">
                                                                <div>
                                                                    <h5 style="margin-top: 10px; color:red"><b>
                                                                             COURSE SELECTED:
                                                                            {{ $applied_applicant->cause_offers }}
                                                                            
                                                                          
                                                                        </b>
                                                                    </h5>
                                                                    <span></span>
                                                                    <h5 class="mt-5"
                                                                        style="text-transform: uppercase; text-align:left; margin-left: 0.5cm">
                                                                        Biodata details</h5>
                                                                    <div class="row"
                                                                        style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th>Surname</th>
                                                                                <th>Other Name(s)</th>
                                                                                <th>Sex</th>
                                                                                <th>Marital Status</th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td id="preview-surname">
                                                                                        {{ $applied_applicant->surname }}
                                                                                    </td>
                                                                                    <td id="preview-othernames">
                                                                                        {{ $applied_applicant->other_names }}
                                                                                    </td>
                                                                                    <td id="preview-sex">
                                                                                        {{ $applied_applicant->sex }}
                                                                                    </td>
                                                                                    <td id="preview-marital-status">
                                                                                        {{ $applied_applicant->marital_status }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <div class="row"
                                                                        style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th>Height</th>
                                                                                <th>Weight</th>
                                                                                <th>Place of birth</th>
                                                                                <th>Date of Birth</th>
                                                                                <th>Hometown</th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td id="preview-height">
                                                                                        {{ $applied_applicant->height }}
                                                                                    </td>
                                                                                    <td id="preview-weight">
                                                                                        {{ $applied_applicant->weight }}
                                                                                    </td>
                                                                                    <td id="preview-place-of-birth">
                                                                                        {{ $applied_applicant->place_of_birth }}
                                                                                    </td>
                                                                                    <td id="preview-date-of-birth">
                                                                                        {{ \Carbon\Carbon::parse($applied_applicant->date_of_birth)->format('d M, Y') }}
                                                                                    </td>
                                                                                    <td id="preview-hometown">
                                                                                        {{ $applied_applicant->hometown }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <div class="row"
                                                                        style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th>Home District</th>
                                                                                <th>Home Region</th>
                                                                                <th>Mobile</th>
                                                                                <th>Email</th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td id="preview-district">
                                                                                        {{ $applied_applicant->districts->district_name ?? 'N/A' }}
                                                                                    </td>
                                                                                    <td id="preview-region">
                                                                                        {{ $applied_applicant->regions->region_name ?? 'N/A' }}
                                                                                    </td>
                                                                                    <td id="preview-contact">
                                                                                        {{ $applied_applicant->contact }}
                                                                                    </td>
                                                                                    <td id="preview-email">
                                                                                        {{ $applied_applicant->email }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="row"
                                                                        style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                              
                                                                                <th>Residential Address</th>
                                                                                <th>Language(s) Spoken </th>
                                                                                <th>Sports Interest</th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td id="preview-residential-address">
                                                                                        {{ $applied_applicant->residential_address }}
                                                                                    </td>
                                                                                    <td id="preview-languages">
                                                                                        @php
                                                                                            $languages = is_string(
                                                                                                $applied_applicant->language,
                                                                                            )
                                                                                                ? json_decode(
                                                                                                    $applied_applicant->language,
                                                                                                    true,
                                                                                                )
                                                                                                : $applied_applicant->language;
                                                                                        @endphp
                                                                                        {{ implode(', ', $languages ?? []) }}
                                                                                    </td>
                                                                                    <td id="preview-sports-interests">
                                                                                        @php
                                                                                            $sportsInterests = is_string(
                                                                                                $applied_applicant->sports_interest,
                                                                                            )
                                                                                                ? json_decode(
                                                                                                    $applied_applicant->sports_interest,
                                                                                                    true,
                                                                                                )
                                                                                                : $applied_applicant->sports_interest;
                                                                                        @endphp
                                                                                        {{ implode(', ', $sportsInterests ?? []) }}
                                                                                    </td>
                                                                                </tr>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <h5 class="mt-5"
                                                                        style="text-transform: uppercase; text-align:left; margin-left: 0.5cm">
                                                                        Educational details</h5>
                                                                    <div class="row"
                                                                        style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th>BECE Index Number</th>
                                                                                <th>JHS Completion Year</th>
                                                                                <th>WASSCE Index Number</th>
                                                                                <th>SHS Completion Year</th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td id="preview-bece-index">
                                                                                        {{ $applied_applicant->bece_index_number }}
                                                                                    </td>
                                                                                    <td id="preview-jhs-completion-year">
                                                                                        {{ \Carbon\Carbon::parse($applied_applicant->bece_year_completion)->format('d M, Y') }}
                                                                                    </td>
                                                                                    <td id="wassce_index_number">
                                                                                        {{ $applied_applicant->wassce_index_number }}
                                                                                    </td>
                                                                                    <td id="wassce_year_completion">
                                                                                        {{ \Carbon\Carbon::parse($applied_applicant->wassce_year_completion)->format('d M, Y') }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="row"
                                                                        style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th>Results Slip Number</th>
                                                                                <th>School Name</th>
                                                                                <th>Course Offered</th>
                                                                                
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td id="preview-shs-completion-year">
                                                                                        {{ $applied_applicant->wassce_serial_number }}
                                                                                    </td>
                                                                                    <td id="preview-shs-name">
                                                                                        {{ $applied_applicant->name_of_secondary_school }}
                                                                                    </td>
                                                                                    <td>
                                                                                        {{ $applied_applicant->secondary_course_offered }}
                                                                                    </td>
                                                                                  
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="row"
                                                                        style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th>BECE Subjects</th>
                                                                                <th>Grades</th>
                                                                                <th>WASSCE Exams Type</th>
                                                                                <th>WASSCE Subjects</th>
                                                                                <th>Grades</th>
                                                                                <th>WASSCE Resultslip Number</th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <select readonly id="bece_english"
                                                                                            class="form-control col-sm-12 required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_english }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="bece_maths"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_mathematics }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="bece_sub1"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_subject_three }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="bece_sub2"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_subject_four }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="bece_sub3"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_subject_five }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="bece_sub4"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_subject_six }}
                                                                                            </option>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select readonly
                                                                                            id="bece_english_grade"
                                                                                            name="bece_english_grade"
                                                                                            class="form-control required"
                                                                                            readonly>
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_subject_english_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly
                                                                                            id="bece_maths_grade"
                                                                                            name="bece_maths_grade"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_subject_maths_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="bece_sub1"
                                                                                            name="bece_sub1"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_subject_three_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="bece_sub2"
                                                                                            name="bece_sub2"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_subject_four_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="bece_sub3"
                                                                                            name="bece_sub3"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_subject_five_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="bece_sub4"
                                                                                            name="bece_sub4"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->bece_subject_six_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select readonly id="exam_type_one"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->exam_type_one }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="exam_type_two"
                                                                                            class="form-control required">
                                                                                            <option>
                                                                                                {{ $applied_applicant->exam_type_two }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub1"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->exam_type_three }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub2"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->exam_type_four }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub3"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->exam_type_five }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub4"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->exam_type_six }}
                                                                                            </option>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select readonly
                                                                                            id="wassce_english"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_english }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_maths"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_mathematics }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub1"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_subject_three }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub2"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_subject_four }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub3"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_subject_five }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub4"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_subject_six }}
                                                                                            </option>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select readonly
                                                                                            id="wassce_english_grade"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_subject_english_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly
                                                                                            id="wassce_maths_grade"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_subject_maths_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub1"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_subject_three_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub2"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_subject_four_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub3"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_subject_five_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub4"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->wassce_subject_six_grade }}
                                                                                            </option>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select readonly id="wassce_sub4"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->results_slip_one }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub4"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->results_slip_two }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub4"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->results_slip_three }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub4"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->results_slip_four }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub4"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->results_slip_five }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <select readonly id="wassce_sub4"
                                                                                            class="form-control ">
                                                                                            <option>
                                                                                                {{ $applied_applicant->results_slip_six }}
                                                                                            </option>
                                                                                        </select>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div style="">
                                                                        <div class="form-group row">
                                                                            <div class="col-md-12">
                                                                                <h5 class="mt-12" style="color: red">
                                                                                    Applicant Declaration</h5>
                                                                                <hr>
                                                                                <form
                                                                                    action="{{ route('declaration-and-acceptance') }}"
                                                                                    method="POST" id="declarationForm">
                                                                                    @csrf
                                                                                    <div
                                                                                        class="custom-control custom-checkbox">
                                                                                        <input type="checkbox"
                                                                                            class="custom-control-input"
                                                                                            id="customCheck1"
                                                                                            name="final_checked"
                                                                                            value="YES">
                                                                                        <label class="custom-control-label"
                                                                                            for="customCheck1">
                                                                                            I <b>{{ $applied_applicant->surname }}
                                                                                                {{ $applied_applicant->other_names }}</b>
                                                                                            declare that all the information
                                                                                            given on this form are correct
                                                                                            to the best of my knowledge and
                                                                                            understand that
                                                                                            <span class="text-danger">any
                                                                                                false statement or omission
                                                                                                may be liable for
                                                                                                prosecution.</span>
                                                                                        </label>
                                                                                        @error('final_checked')
                                                                                            <span
                                                                                                class="badge badge-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <button type="submit"
                                                                                                class="btn btn-success">Submit
                                                                                                Application</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--  Js -->
    <script src="{{ asset('frontend/assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/ripple.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/daterangepicker.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/pages/ac-datepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.full.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/pages/form-select-custom.js') }}"></script>

    <script>
        document.getElementById('declarationForm').addEventListener('submit', function(e) {
            const checkbox = document.getElementById('customCheck1');
            if (!checkbox.checked) {
                e.preventDefault(); // Prevent form submission
                alert('You must agree to the declaration before submitting the application.');
                return;
            }
            // Proceed with form submission
            e.preventDefault(); // Prevent default form submission
            let form = this;
            let formData = new FormData(form);
            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response Data:', data); // Debugging log
                    // Open the PDF in a new tab regardless of qualified or disqualified status
                    window.open(data.pdf_url, '_blank');
                    // Short delay before logging out
                    setTimeout(() => {
                        logoutUser();
                    }, 500); // 500ms delay to ensure PDF opens first
                })
                .catch(error => console.error('Error:', error));
        });

        function logoutUser() {
            fetch('{{ route('apply_logout') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(() => {
                    // After logging out, redirect the user to the portal page
                    window.location.href = '/Portal';
                })
                .catch(error => console.error('Logout failed:', error));
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $(document).on('change', '.btn-file :file', function() {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });
            $('.btn-file :file').on('fileselect', function(event, label) {
                var input = $(this).parents('.input-group').find(':text'),
                    log = label;
                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#img-upload').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#imgInp").change(function() {
                readURL(this);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#besicwizard').bootstrapWizard({
                withVisible: false,
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                'firstSelector': '.button-first',
                'lastSelector': '.button-last'
            });
            $('#btnwizard').bootstrapWizard({
                withVisible: false,
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                'firstSelector': '.button-first',
                'lastSelector': '.button-last'
            });
            $('#progresswizard').bootstrapWizard({
                withVisible: false,
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                'firstSelector': '.button-first',
                'lastSelector': '.button-last',
                onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index + 1;
                    var $percent = ($current / $total) * 100;
                    $('#progresswizard .progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });
            $('#validationwizard').bootstrapWizard({
                withVisible: false,
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                'firstSelector': '.button-first',
                'lastSelector': '.button-last',
                onNext: function(tab, navigation, index) {
                    if (index == 1) {
                        if (!$('#validation-t-name').val()) {
                            $('#validation-t-name').focus();
                            $('.form-1').addClass('was-validated');
                            return false;
                        }
                        if (!$('#validation-t-email').val()) {
                            $('#validation-t-email').focus();
                            $('.form-1').addClass('was-validated');
                            return false;
                        }
                        if (!$('#validation-t-pwd').val()) {
                            $('#validation-t-pwd').focus();
                            $('.form-1').addClass('was-validated');
                            return false;
                        }
                    }
                    if (index == 2) {
                        if (!$('#validation-t-address').val()) {
                            $('#validation-t-address').focus();
                            $('.form-2').addClass('was-validated');
                            return false;
                        }
                    }
                }
            });
            $('#tabswizard').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
            });
            $('#verticalwizard').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
            });
        });
    </script>
    <script type="text/javascript">
        $('#jhs_completion_year').datepicker({
            format: "yyyy",
            endDate: "31/12/2024",
            startView: 2,
            minViewMode: 2,
            autoclose: true,
            calendarWeeks: true

        });
    </script>

    <script>
        function printData() {
            var divToPrint = document.getElementById("printTable");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }
        $('.btn-print-invoice').on('click', function() {
            printData();
        })
    </script>

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });
        })
    </script>
@endsection
