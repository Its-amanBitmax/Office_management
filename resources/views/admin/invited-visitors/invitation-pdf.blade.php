<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invitation - {{ $invitedVisitor->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
            color: #333;
        }
        h1 {
            color: #4a4a4a;
            font-size: 24px;
            margin-bottom: 1rem;
        }
        .details {
            margin-bottom: 1.5rem;
        }
        .details label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        .qr-code {
            margin-top: 2rem;
            text-align: center;
        }
        .footer {
            margin-top: 3rem;
            font-size: 0.9rem;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Invitation for {{ $invitedVisitor->name }}</h1>
    <div class="details">
        <p><label>Name:</label> {{ $invitedVisitor->name }}</p>
        <p><label>Email:</label> {{ $invitedVisitor->email ?? 'N/A' }}</p>
        <p><label>Phone:</label> {{ $invitedVisitor->phone ?? 'N/A' }}</p>
        <p><label>Purpose:</label> {{ $invitedVisitor->purpose ?? 'N/A' }}</p>
        <p><label>Invited At:</label> {{ $invitedVisitor->invited_at ? $invitedVisitor->invited_at->format('M d, Y H:i') : 'N/A' }}</p>
    </div>
    <div class="qr-code">
        <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(150)->generate(route('invited-visitors.show', $invitedVisitor))) }}" alt="QR Code">
        <p>Scan this QR code for more details</p>
    </div>
    <div class="footer">
        <p>Thank you for your visit. Please carry this invitation with you.</p>
    </div>
</body>
</html>
