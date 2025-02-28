<!DOCTYPE html>
<html>

<head>
    <title>Applicant Summary Sheet</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ public_path('37 school.png') }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            z-index: -1;
            opacity: 0.07; /* Lower opacity to make the background less prominent */
        }

        .watermark {
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

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
        }

        .image-border {
            border: 2px solid #000;
            border-radius: 6px;
            display: block;
            margin: 20px auto; /* Center the applicant image */
            height: 160px;
            width: 160px;
        }

        .status-right {
            text-align: right;
        }

        .no-break {
            page-break-inside: avoid;
        }

        p {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 18px;
        }
    </style>
</head>

<body>
<div class="background"></div>

<table>
    <tr>
        <td><b>37 MILITARY HOSPITAL NMTC</b></td>
        <td></td>
        <td class="status-right"><b>Status:</b> {{ $applied_applicant->qualification }}</td>
    </tr>
    <tr>
        <td><b>Online Application</b></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><b>Applied At:</b> {{ \Carbon\Carbon::parse($applied_applicant->created_at)->format('d M, Y h:i A') }}</td>
        <td></td>
        <td></td>
    </tr>
</table>

<p>Application Summary Report</p>

<table class="no-break" style="width: 100%; text-align: center;">
    <tr>
        <td>
            <div style="text-align: center;">
                @php $imagePath = public_path($applied_applicant->applicant_image); @endphp
                @if (file_exists($imagePath))
                    <img src="{{ public_path($applied_applicant->applicant_image) }}" alt="Applicant Image" class="image-border">
                @else
                    <img src="{{ asset('assets/images/img_placeholder_avatar.jpg') }}" alt="Placeholder Image" class="image-border">
                @endif
            </div>
        </td>
    </tr>
</table>


<table>
    @if ($applied_applicant->qualification === 'QUALIFIED')
        <tr>
            <td><b>NMTC Number:</b></td>
            <td>{{ $applied_applicant->applicant_serial_number }}</td>
        </tr>
    @endif
    <tr>
        <td><b>Selected Course:</b></td>
        <td>{{ $applied_applicant->cause_offers }}</td>
    </tr>
</table>

@if (!is_null($applied_applicant->disqualification_reason))
    <table>
        <tr>
            <td><b>Disqualification Reason:</b></td>
            <td>{{ $applied_applicant->disqualification_reason }}</td>
        </tr>
    </table>
@endif

<div class="watermark">37 MILITARY HOSPITAL NMTC</div>

</body>

</html>
