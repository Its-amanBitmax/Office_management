<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company_name ?? 'Office CRM' }} Welcome</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="icon" href="{{ $logo ?? asset('favicon.ico') }}" type="image/x-icon">

    <style>
      body {
    font-family: 'Roboto', Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    color: #333;

    /* ✅ Image + gradient together */
    background:
        linear-gradient(135deg, rgba(0,123,255,0.6), rgba(0,221,235,0.6)),
        url('https://www.bitmaxgroup.com/management/public/images/bg-welcome.png');

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
       .container {
    text-align: center;
    background-color: rgba(255, 255, 255, 0.7);
    padding: 50px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    max-width: 400px;
    width: 90%;
    animation: fadeIn 1s ease-in-out;
}

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        h1 {
            font-size: 2em;
            margin-bottom: 10px;
            color: #1a73e8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        h1 .material-symbols-outlined {
            font-size: 1.5em;
            color: #1a73e8;
        }
        p.greeting {
            font-size: 1.1em;
            margin-bottom: 20px;
            color: #555;
        }
        .role-selection {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        button {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            border: none;
            border-radius: 8px;
            background-color: #1a73e8;
            color: #fff;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:hover {
            background-color: #1557b0;
            transform: scale(1.05);
        }
        button .material-symbols-outlined {
            font-size: 1.2em;
        }
        @media (max-width: 600px) {
            .container {
                padding: 30px;
            }
            button {
                padding: 10px 18px;
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>
            <span class="material-symbols-outlined">business</span>
            Office CRM
        </h1>
        <p class="greeting">Welcome! Please select your role to continue.</p>
        
        <div class="role-selection">
            <button onclick="redirectToLogin('admin')">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                Admin
            </button>
            <button onclick="redirectToLogin('employee')">
                <span class="material-symbols-outlined">person</span>
                Employee
            </button>
        </div>
    </div>

    <script>
        function redirectToLogin(role) {
            if (role === 'admin') {
                window.location.href = 'admin/login';
            } else if (role === 'employee') {
                window.location.href = 'employee/login';
            }
        }
    </script>
</body>
</html>