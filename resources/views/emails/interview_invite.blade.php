<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Interview Invitation</title>
</head>
<body>

<p>Dear Candidate,</p>

<p>
    We are pleased to inform you that you have been shortlisted for the
    <strong>Virtual interview process</strong>.  
    Please find the details below:
</p>

<p>
    <strong>Position:</strong> {{ $interview->candidate_profile ?? '—' }}<br>
    <strong>Interview Mode:</strong> Online<br>
    <strong>Date & Time:</strong>
    {{ \Carbon\Carbon::parse($interview->date)->format('d M Y') }}
    at {{ $interview->time }}<br>
   <strong>Location / Link:</strong>
<a href="https://www.bitmaxgroup.com/management/interview/{{ $interview->unique_link }}">
    https://www.bitmaxgroup.com/management/interview/{{ $interview->unique_link }}
</a><br>

    <strong>Interview Code:</strong> {{ $interview->interview_code }}<br>
    <strong>Password:</strong> {{ $interview->decrypted_password }}
</p>

<p>
    Kindly confirm your availability for the interview by replying to this email
    at the earliest. If you have any queries, feel free to contact us.
</p>

<p>We look forward to meeting you.</p>

<br>

<p>
    Regards,<br>
    <strong>Sakshi Sharma</strong><br>
    Senior HR Executive<br>
    9999999999
</p>

</body>
</html>
