<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation - {{ $invitedVisitor->name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap');
        
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .invitation-card {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 20px 40px;
            position: relative;
            page-break-inside: avoid;
        }

        .logo {
            display: block;
            margin: 0 auto 15px;
            width: 120px;
            height: auto;
            margin-left: 225px;
            
        }

        .divider {
            width: 60px;
            height: 3px;
            background: #d4af37;
            margin: 10px auto 25px;
            border-radius: 2px;
        }

        .guest-details, .date-time-box {
            background: #fff7e6;
            border: 1px solid #f1e1b5;
            padding: 10px;
            border-radius: 8px;
            margin: 10px auto;
            text-align: center;
            width: 80%;
        }

        .guest-details p, .date-time-box p {
            margin: 4px 0;
            font-size: 14px;
        }

        .date-time-box {
            font-weight: bold;
        }

        .honor-text {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-top: 15px;
            font-style: italic;
        }

        .meeting-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: #d4af37;
            margin: 10px 0 15px;
        }

        .welcome-message {
            text-align: center;
            font-size: 14px;
            color: #555;
            font-style: italic;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .invite-box {
            background: #f1f3f5;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-size: 14px;
            color: #333;
            font-weight: 500;
            margin: 0 auto 15px;
            width: 80%;
        }

        .qr-code {
            text-align: center;
            margin: 15px auto;
        }

        .qr-code img {
            width: 100px;
            height: 100px;
            border-radius: 6px;
            border: 2px solid #d4af37;
        }

        .qr-code p {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .location-section {
            background: #f8f9fa;
            border-top: 1px solid #ddd;
            padding: 10px 15px;
            font-size: 13px;
            color: #444;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            font-style: italic;
            margin-top: 15px;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            opacity: 0.05;
            font-size: 70px;
            font-family: 'Playfair Display', serif;
            color: #d4af37;
            pointer-events: none;
            z-index: 0;
        }

        @media print {
            @page { size: A4; margin: 10mm; }
            body { background: white; padding: 0; }
            .invitation-card { box-shadow: none; border-radius: 0; max-width: none; padding: 15mm; }
            .logo { width: 40mm; }
            .meeting-title { font-size: 18pt; }
            .guest-details, .date-time-box, .invite-box { width: 90%; font-size: 11pt; }
        }
    </style>
</head>
<body>
    <div class="invitation-card">
        @php
            $logoPath = public_path('images/logo.png');
            $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : base64_encode(file_get_contents('https://www.bitmaxgroup.com/assets/logo/logo.png'));
            $logoMime = 'image/png';
            
            $qrPath = public_path('images/Qr.svg');
            $qrData = file_exists($qrPath) ? base64_encode(file_get_contents($qrPath)) : null;
            if (!$qrData) {
                $qrData = base64_encode(file_get_contents(public_path('images/Qr.svg')));
            }
            $qrMime = 'image/svg+xml';
        @endphp
        
        <img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="Bitmax Logo" class="logo">
        <div class="divider"></div>

        <div class="guest-details">
            <p><strong>{{ $invitedVisitor->name ?? 'Aman Singh' }}</strong></p>
            <p>+{{ $invitedVisitor->phone ?? '91 97670513' }}</p>
            <p>{{ $invitedVisitor->email ?? 'aman.singh@gmail.com' }}</p>
        </div>
        
        <div class="date-time-box">
            <p>Date & Time: {{ $invitedVisitor->invited_at ? $invitedVisitor->invited_at->format('M d, Y, g:i A') : now()->format('M d, Y, g:i A') }}</p>
        </div>

        <div class="honor-text">
            It's an honor to invite you to
        </div>
        
        <h1 class="meeting-title">{{ $invitedVisitor->purpose ?? 'test' }}</h1>
        
        <div class="welcome-message">
            We look forward to your gracious presence,<br>
            as together we build stronger bonds,<br>
            unlock new opportunities,<br>
            and celebrate the spirit of growth with Bitmax.
        </div>
        
        <div class="invite-box">
            <strong>Invite Code</strong><br>
            {{ $invitedVisitor->invitation_code ?? 'FG4WD3' }}<br><br>
            <strong>Contact Person</strong><br>
            {{ $invitedVisitor->contact_person_name ?? 'Arju' }} ({{ $invitedVisitor->contact_person_phone ?? '+91 9197689432' }})
        </div>
        
        <div class="qr-code">
            <img src="data:{{ $qrMime }};base64,{{ $qrData }}" alt="QR Code">
            <p>Scan for details</p>
        </div>
        
        <div class="location-section">
            <p><strong>Location:</strong> 'Bhutani Alphathum, Unit -1034, Tower A, 10th Floor, Noida-201305' </p>
            <p><strong>Phone:</strong>'+91 1123456789'  
               <strong>Email:</strong>'contact@bitmax.example' </p>
        </div>
        
        <div class="footer">
            Thank you for your visit. Please carry this invitation with you.<br>
            Bitmax Technology Pvt Ltd
        </div>
        
        <div class="watermark">Bitmax</div>
    </div>
</body>
</html>
