<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invitation - {{ $invitedVisitor->name }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20mm;
            color: #333;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20mm;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 140px;
            height: auto;
            display: block;
            margin: 0 auto 10px;
        }
        h1 {
            color: #1d67a3; /* Bitmax brand color */
            font-size: 22px;
            margin: 0;
            text-align: center;
            font-weight: bold;
        }
        .details {
            margin: 20px 0;
            font-size: 14px;
            line-height: 1.6;
        }
        .details p {
            margin: 8px 0;
            display: flex;
            align-items: flex-start;
        }
        .details label {
            font-weight: bold;
            width: 110px;
            color: #4a4a4a;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .qr-code img {
            width: 140px;
            height: 140px;
            display: block;
            margin: 0 auto;
        }
        .qr-code p {
            font-size: 12px;
            color: #555;
            margin-top: 10px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .footer img {
            width: 90px;
            height: auto;
            opacity: 0.25;
            margin: 10px auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @php
                $logoPath = public_path('images/logo.png');
                $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : base64_encode(file_get_contents('https://www.bitmaxgroup.com/assets/logo/logo.png'));
                $logoMime = 'image/png';
                $qrPath = public_path('images/qr-code.png');
                $qrData = file_exists($qrPath) ? base64_encode(file_get_contents($qrPath)) : base64_encode(file_get_contents('public\images\qr-code.png')); // Replace with your QR code URL if needed
                $qrMime = 'image/png';
            @endphp
            <img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="Bitmax Logo">
            <h1>Invitation for {{ $invitedVisitor->name }}</h1>
        </div>
        <div class="details">
            <p><label>Name:</label> {{ $invitedVisitor->name }}</p>
            <p><label>Email:</label> {{ $invitedVisitor->email ?? 'N/A' }}</p>
            <p><label>Phone:</label> {{ $invitedVisitor->phone ?? 'N/A' }}</p>
            <p><label>Purpose:</label> {{ $invitedVisitor->purpose ?? 'N/A' }}</p>
            <p><label>Invited At:</label> {{ $invitedVisitor->invited_at ? $invitedVisitor->invited_at->format('M d, Y H:i') : 'N/A' }}</p>
        </div>
        <div class="qr-code">
            <img src="data:{{ $qrMime }};base64,{{ $qrData }}" alt="QR Code">
            <p>Scan this QR code for more details</p>
        </div>
        <div class="footer">
            <p>Thank you for your visit. Please carry this invitation with you.</p>
            <img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="Bitmax Watermark">
            <p>Bitmax Technology Pvt Ltd</p>
        </div>
    </div>
</body>
</html>