<!DOCTYPE html>
<html>

<head>
    <title>Applicant Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .cont {
            border: none;
        }

        .content {
            width: 100%;
            margin: 0 auto;
        }

        .section-title {
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 10px;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        ,
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <table>
        <tr>
            <b>GHANA ARMED FORCES</b>
        </tr>
        <tr>
            <b>ONLINE ENLISTMENT.</b>
        </tr>
        <tr>
            <p style="margin:0"> Created at:
                {{ \Carbon\Carbon::parse($applied_applicant->created_at)->format('d M, Y h:i A') }}
            </p>
        </tr>
    </table>

    <style>
        h2 {
            font-weight: normal;
        }

        h3 {
            font-weight: normal;
        }

        h4 {
            font-weight: normal;
        }

        h6 {
            font-weight: normal;
        }

        tr,
        td {
            padding: 0px;
        }
    </style>
    <p align="center"><b>APPLICATION SUMMARY REPORT</b></p>
    <table>
        <tr align="center">
            @php
                $imagePath = public_path($applied_applicant->applicant_image);
            @endphp
            <td style="border-collapse: collapse; border: none;">
                @if (file_exists($imagePath))
                    <img id="showImage" src="{{ public_path($applied_applicant->applicant_image) }}" alt=""
                        height="150px" width="150px" class="img-thumbnail">
                @else
                    <img id="showImage" src="{{ asset('assets/images/img_placeholder_avatar.jpg') }}" alt=""
                        width="200px" class="img-thumbnail">
                @endif
            </td>
        </tr>
    </table>
    <p style="margin:0;">
        <b> GAF NUMBER:{{ $applied_applicant->applicant_serial_number }} </b>
    </p>
    <p style="margin:0;">
        <b>ARM OF SERVICE:</b>{{ $applied_applicant->arm_of_service }}
    </p>
    <p style="margin:0;">
        <b>COMMISSION TYPE:</b>{{ $applied_applicant->commission_type }}
    </p>
    <p style="margin:0;">
        <b>BRANCH:</b>{{ $applied_applicant->branches->branch }}
    </p>
    <p style="margin:0;">
        @if ($applied_applicant->qualification == 'QUALIFIED')
            <span class="badge badge-success"> <b>STATUS:</b>{{ $applied_applicant->qualification }}</span>
        @elseif ($applied_applicant->qualification == 'DISQUALIFIED')
            <span class="badge badge-danger"><b>STATUS:</b>{{ $applied_applicant->qualification }}</span>
        @endif
    </p>
    <span></span>
    <p style="background-color: #F0FFFF;"><b>Bio Data:</b></p>
    <table class="cont" style="padding:0;">
        <tr>
            <td><b>Surname :</td>/td>
            <td>{{ $applied_applicant->surname }}</td>
            <td>
            </td>
            <td><b>Date of Birth :</b></td>
            <td>{{ \Carbon\Carbon::parse($applied_applicant->date_of_birth)->format('d M, Y') }}</td>
        </tr>
        <tr>
            <td><b>Other Names :</b></td>
            <td>{{ $applied_applicant->other_names }}</td>
            <td></td>
            <td><b>Place of Birth :</b></td>
            <td>{{ $applied_applicant->place_of_birth }}</td>
        </tr>
        <tr>
            <td><b>Height :</b></td>
            <td>{{ $applied_applicant->height }}</td>
            <td></td>
            <td><b>Region :</b></td>
            <td>{{ $applied_applicant->regions->region_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><b>Weight :</b></td>
            <td>{{ $applied_applicant->weight }}</td>
        </tr>
        <tr>
            <td><b>Address :</b></td>
            <td>{{ $applied_applicant->residential_address }}</td>
            <td></td>
            <td><b>Hometown :</b></td>
            <td>{{ $applied_applicant->hometown }}</td>
        </tr>
        <tr>
            <td><b>Email :</b></td>
            <td>{{ $applied_applicant->email }}</td>
            <td></td>
            <td><b>Mobile Number :</b></td>
            <td>{{ $applied_applicant->contact }}</td>
        </tr>
        <tr>
            <td><b>Employment :</b></td>
            <td>{{ $applied_applicant->employment }}</td>
            <td></td>
            <td><b>Marital Status :</b></td>
            <td>{{ $applied_applicant->marital_status }}</td>
        </tr>
        <tr>
            <td><b>Sex :</b></td>
            <td>{{ $applied_applicant->sex }}</td>
            <td></td>
            <td><b>Language(s)</b></td>
            <td> @php
                $languages = is_string($applied_applicant->language)
                    ? json_decode($applied_applicant->language, true)
                    : $applied_applicant->language;
            @endphp
                {{ implode(', ', $languages ?? []) }}</td>
        </tr>
        <tr>
            <td><b>Sports Interest(s) :</b></td>
            <td> @php
                $sportsInterests = is_string($applied_applicant->sports_interest)
                    ? json_decode($applied_applicant->sports_interest, true)
                    : $applied_applicant->sports_interest;
            @endphp
                {{ implode(', ', $sportsInterests ?? []) }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <span></span>
    <p style="background-color: #F0FFFF"><b>Educational Data:</b></p>
    <p style="background-color: #DAF7A6; width:  180px;"><b>BECE Results:</b></p>
    <table class="cont" style="padding:0; margin-right: 5px;">
        <tr>
            <td width="280px"><b>{{ $applied_applicant->bece_english }}</b></td>
            <td> {{ $applied_applicant->bece_subject_english_grade }}</td>
            <td width="280px"><b>{{ $applied_applicant->bece_subject_four }}</b></td>
            <td align="left">{{ $applied_applicant->bece_subject_four_grade }}</td>
        </tr>
        <tr>
            <td width="280px"><b>{{ $applied_applicant->bece_mathematics }}</b></td>
            <td>{{ $applied_applicant->bece_subject_maths_grade }}</td>
            <td width="280px"> <b>{{ $applied_applicant->bece_subject_five }}</b></td>
            <td align="left">{{ $applied_applicant->bece_subject_five_grade }}</td>
        </tr>
        <tr>
            <td width="280px"><b>{{ $applied_applicant->bece_subject_three }}</b></td>
            <td>{{ $applied_applicant->bece_subject_three_grade }}</td>
            <td width="280px"><b>{{ $applied_applicant->bece_subject_six }}</b></td>
            <td align="left">{{ $applied_applicant->bece_subject_six_grade }}</td>
        </tr>
    </table>
    <p style="background-color: #DAF7A6; width:  180px;"><b>WASSCE Results:</b></p>
    <table class="cont" style="padding:0; margin-right: 5px;">
        <tr>
            <td width="280px"><b>{{ $applied_applicant->wassce_english }}</b></td>
            <td>{{ $applied_applicant->wassce_subject_english_grade }}</td>
            <td width="280px"><b>{{ $applied_applicant->wassce_subject_four }}</b></td>
            <td align="left">{{ $applied_applicant->wassce_subject_four_grade }}</td>
        </tr>
        <tr>
            <td width="280px"><b>{{ $applied_applicant->wassce_mathematics }}</b></td>
            <td>{{ $applied_applicant->wassce_subject_maths_grade }}</td>
            <td width="280px"> <b>{{ $applied_applicant->wassce_subject_five }}</b></td>
            <td align="left">{{ $applied_applicant->wassce_subject_five_grade }}</td>
        </tr>
        <tr>
            <td width="280px"><b>{{ $applied_applicant->wassce_subject_three }}</b></td>
            <td>{{ $applied_applicant->wassce_subject_three_grade }}</td>
            <td width="280px"><b>{{ $applied_applicant->wassce_subject_six }}</b></td>
            <td align="left">{{ $applied_applicant->wassce_subject_six_grade }}</td>
        </tr>
    </table>
    <p style="background-color: #DAF7A6; width:  180px;"><b>Education Details:</b></p>
    <table class="cont" style="padding:0; margin-right: 5px;">
        <tr>
            <td><b>Secondary School:</b></td>
            <td>{{ $applied_applicant->name_of_secondary_school }}</td>
            <td><b>Year of Completion:</b></td>
            <td align="left">
                {{ \Carbon\Carbon::parse($applied_applicant->wassce_year_completion)->format('d M, Y') }}
            </td>
        </tr>
        <tr>
            <td><b>WASSCE Index No:</b></td>
            <td>{{ $applied_applicant->wassce_index_number }}</td>
            <td> <b>WASSCE Serial No:</b></td>
            <td align="left">{{ $applied_applicant->wassce_serial_number }}</td>
        </tr>
        <tr>
            <td><b>BECE Index No:</b></td>
            <td>{{ $applied_applicant->bece_index_number }}</td>
            <td><b>Year of Completion:</b></td>
            <td align="left">
                {{ \Carbon\Carbon::parse($applied_applicant->bece_year_completion)->format('d M, Y') }}
            </td>
        </tr>
    </table>
    </div>
    <div class="row" style="margin-left: 0.5cm; margin-right: 0.5cm;">
        <table class="table table-bordered">
            <thead>
                <th>Name of Institution</th>
                <th>Qualification</th>
                <th>Year of Completion</th>
                <th>Class Attained</th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ $applied_applicant->name_of_tertiary }}
                    </td>
                    <td>
                        {{ $applied_applicant->tertiary_qualification }}
                        {{ $applied_applicant->programme }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($applied_applicant->year_of_completion)->format('d M, Y') }}
                    </td>
                    <td>
                        {{ $applied_applicant->class_attained }}
                    </td>
                </tr>
                <label class="custom-control-label">
                    I <b>{{ $applied_applicant->surname }}
                        {{ $applied_applicant->other_names }}</b>declare that all the information given on this form
                    are correct to the best of my knowledge and understand that
                    <span class="text-danger">any false statement or omission may be liable for prosecution.</span>
                </label>
            </tbody>
        </table>
    </div>
    </table>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

</html>
