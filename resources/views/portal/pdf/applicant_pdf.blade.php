<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GAFCONM - Application Summary</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background: #f9f9f9;
            color: #333;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 900px;
            margin: auto;
        }

        .header, .section-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;

        }

        .section-title {
            background-color: #e9f0ff;
            padding: 10px;
            font-weight: bold;
            border-left: 5px solid;
            margin-top: 40px;
        }

        .summary-table, .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .summary-table td, .data-table td, .data-table th {
            padding: 10px;
            border-bottom: 1px solid ;
        }

        .data-table th {
            background-color: ;
            text-align: left;
        }

        .applicant-photo {
            text-align: center;
            margin-top: 20px;
        }

        .applicant-photo img {
            height: 160px;
            width: 160px;
            border-radius: 8px;
            border: 2px solid #000;
        }

        .watermark {
            text-align: center;
            font-size: 12px;
            color: rgba(0, 0, 0, 0.3);
            margin-top: 50px;
            text-transform: uppercase;
        }
         .watermark2 {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 20px;
            color: rgba(0, 0, 0, 0.3);
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
        }
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ public_path('37.png') }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            z-index: -1;
            opacity: 0.07; /* Lower opacity to make the background less prominent */
        }.background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ public_path('37.png') }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            z-index: -1;
            opacity: 0.05; /* Lower opacity to make the background less prominent */
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Ghana Armed Forces College of Nursing and Midwifery</h1>
        <p><strong>Application Summary</strong></p>
    </div>
<div class="background"></div>
    <table class="summary-table">
        <tr>
            <td><strong>Application ID:</strong> {{ $applied_applicant->applicant_serial_number }}</td>
            <td><strong>Status:</strong> {{ $applied_applicant->qualification }}</td>
        </tr>
        <tr>
            <td><strong>Applied At:</strong>{{ strtoupper(\Carbon\Carbon::parse($applied_applicant->created_at)->format('d F Y h:i A')) }}</td>
            <td><strong>Selected Course:</strong> {{ $applied_applicant->cause_offers }}</td>
        </tr>
    </table>
    <div class="applicant-photo">
        @php $imagePath = public_path($applied_applicant->applicant_image); @endphp
        @if (file_exists($imagePath))
            <img src="{{ public_path($applied_applicant->applicant_image) }}" alt="Applicant Image">
        @else
            <img src="{{ asset('assets/images/img_placeholder_avatar.jpg') }}" alt="Placeholder Image">
        @endif
    </div>
    <div class="section-title">Bio Data</div>
    <table class="data-table">
        <tr>
            <th>Surname</th>
            <td>{{ $applied_applicant->surname }}</td>
            <th>Other Names</th>
            <td>{{ $applied_applicant->other_names }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
           <td>{{ strtoupper(\Carbon\Carbon::parse($applied_applicant->date_of_birth)->format('d F Y')) }}</td>
            <th>Sex</th>
            <td>{{ $applied_applicant->sex }}</td>
        </tr>
        <tr>
           <th>Contact</th>
            <td>{{ $applied_applicant->contact }}</td>
            <th>Marital Status</th>
            <td>{{ $applied_applicant->marital_status }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td colspan="3">{{ $applied_applicant->email }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td colspan="3">{{ $applied_applicant->residential_address }}</td>
        </tr>
        <tr>
            <th>Disability Status</th>
            <td>{{ $applied_applicant->disability_status }}</td>
            <th>Languages</th>
            <td>
                @php
                    $languages = is_string($applied_applicant->language)
                        ? json_decode($applied_applicant->language, true)
                        : $applied_applicant->language;
                @endphp
                {{ implode(', ', $languages ?? []) }}
            </td>
        </tr>
    </table>
    <br><br>
    <div class="section-title">BECE Results</div>
    <table class="data-table">
        <tr>
            <th>Subject</th>
            <th>Grade</th>
            <th>Subject</th>
            <th>Grade</th>
        </tr>
        <tr>
            <td>{{ $applied_applicant->bece_english }}</td>
            <td>{{ $applied_applicant->bece_subject_english_grade }}</td>
            <td>{{ $applied_applicant->bece_subject_four }}</td>
            <td>{{ $applied_applicant->bece_subject_four_grade }}</td>
        </tr>
        <tr>
            <td>{{ $applied_applicant->bece_mathematics }}</td>
            <td>{{ $applied_applicant->bece_subject_maths_grade }}</td>
            <td>{{ $applied_applicant->bece_subject_five }}</td>
            <td>{{ $applied_applicant->bece_subject_five_grade }}</td>
        </tr>
        <tr>
            <td>{{ $applied_applicant->bece_subject_three }}</td>
            <td>{{ $applied_applicant->bece_subject_three_grade }}</td>
            <td>{{ $applied_applicant->bece_subject_six }}</td>
            <td>{{ $applied_applicant->bece_subject_six_grade }}</td>
        </tr>
    </table>
    <div class="section-title">WASSCE Results</div>
    <table class="data-table">
        <tr>
            <td>{{ $applied_applicant->wassce_english }}</td>
            <td>{{ $applied_applicant->wassce_subject_english_grade }}</td>
            <td>{{ $applied_applicant->wassce_subject_four }}</td>
            <td>{{ $applied_applicant->wassce_subject_four_grade }}</td>
        </tr>
        <tr>
            <td>{{ $applied_applicant->wassce_mathematics }}</td>
            <td>{{ $applied_applicant->wassce_subject_maths_grade }}</td>
            <td>{{ $applied_applicant->wassce_subject_five }}</td>
            <td>{{ $applied_applicant->wassce_subject_five_grade }}</td>
        </tr>
        <tr>
            <td>{{ $applied_applicant->wassce_subject_three }}</td>
            <td>{{ $applied_applicant->wassce_subject_three_grade }}</td>
            <td>{{ $applied_applicant->wassce_subject_six }}</td>
            <td>{{ $applied_applicant->wassce_subject_six_grade }}</td>
        </tr>
    </table>
    <div class="section-title">Education Details</div>
    <table class="data-table">
        <tr>
            <th>Secondary School</th>
            <td>{{ $applied_applicant->name_of_secondary_school }}</td>
            <th>WASSCE Completion</th>
            <td>{{ strtoupper(\Carbon\Carbon::parse($applied_applicant->wassce_year_completion)->format('d F Y')) }}</td>
        </tr>
        <tr>
            <th>WASSCE Index No</th>
            <td>{{ $applied_applicant->wassce_index_number }}</td>
            <th>WASSCE Serial No</th>
            <td>{{ $applied_applicant->wassce_serial_number }}</td>
        </tr>
        <tr>
            <th>BECE Index No</th>
            <td>{{ $applied_applicant->bece_index_number }}</td>
            <th>BECE Completion</th>
           <td>{{ strtoupper(\Carbon\Carbon::parse($applied_applicant->bece_year_completion)->format('d F Y')) }}</td>
        </tr>
    </table>
    @if (!is_null($applied_applicant->disqualification_reason))
        <div class="section-title">Disqualification</div>
        <p><strong>Reason:</strong> {{ $applied_applicant->disqualification_reason }}</p>
    @endif
    <div class="watermark">GAFCONM Admissions Office</div>
</div>
</body>
</html>
