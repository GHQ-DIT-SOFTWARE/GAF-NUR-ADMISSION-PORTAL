<!DOCTYPE html>
<html>
<head>
    <title>Nursing Admission Interview Invitation</title>
</head>
<body>
    <p>Dear {{ $applicant->surname }} {{ $applicant->other_names }},</p>

    <p>Congratulations! You have successfully passed the aptitude test phase.</p>

    <p>You are kindly invited to attend the <strong>Nursing Admission Interview</strong> scheduled for <strong>{{ $formattedDate }}</strong>.</p>

    <p>We wish you the very best in the next stage of the selection process.</p>

    <p>Regards,<br>
    Admission Team</p>
</body>
</html>
