<!DOCTYPE html>
<html>
<head>
    <title>Aptitude Test Invitation</title>
</head>
<body>
    <p>Dear {{ $applicant->surname }} {{ $applicant->other_names }},</p>

    <p>Congratulations! You have passed the result verification phase.</p>
    <p>You are kindly requested to report for your Aptitude Test on <strong>{{ $formattedDate }}</strong>.</p>
    <p>Good luck!</p>

    <p>Regards,<br>
    Admission Team</p>
</body>
</html>
