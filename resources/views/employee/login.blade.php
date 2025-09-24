<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Login - {{ config('app.name', 'Laravel') }}</title>

    <style>
        /* Reset and Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        #background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-wrap: wrap;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        /* Left Panel */
        .left-panel {
            width: 50%;
            min-height: 100%;
            padding: 50px 30px;
            background: rgba(11, 29, 58, 0.8);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            align-items: center;
        }

        .left-panel .logo {
            background: rgba(255, 255, 255, 0.945);
            padding: 30px;
            border-radius: 50%;
            margin-bottom: 30px;
            max-width: 180px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        .left-panel .logo img {
            width: 100%;
            height: auto;
            display: block;
        }

        .left-panel h1 {
            font-size: 2.2rem;
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            color: #fff;
            margin-top: 40px;
        }

        .left-panel p {
            margin-top: 20px;
            font-size: 1rem;
            line-height: 1.7;
            color: #e4e4e4;
            font-family: 'Open Sans', sans-serif;
        }

        .left-panel .footer-text {
            font-size: 0.85rem;
            margin-top: auto;
            font-family: 'Open Sans', sans-serif;
            color: #ddd;
        }

        /* Right Panel */
        .right-panel {
            width: 50%;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Login Form */
        .login-form h2 {
            color: #005dd9;
            margin-bottom: 10px;
            font-family: 'Roboto', sans-serif;
            font-weight: 600;
            text-align: center;
        }

        .login-form .sub-text {
            font-size: 0.95rem;
            margin-bottom: 25px;
            color: #555;
            font-family: 'Open Sans', sans-serif;
        }

        .login-form label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.95rem;
            color: #333;
            font-family: 'Roboto', sans-serif;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: 0.3s;
        }

        .login-form input:focus {
            border-color: #005dd9;
            outline: none;
        }

        .options {
            margin-bottom: 20px;
        }

        .options label {
            font-size: 0.85rem;
            color: #333;
        }

        /* Login Button */
        .login-form button {
            width: 100%;
            padding: 12px;
            background-color: #005dd9;
            border: none;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-form button:hover {
            background-color: #003fa1;
        }

        /* Bottom Links */
        .bottom-links {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.9rem;
        }

        .bottom-links a {
            color: #005dd9;
            text-decoration: none;
            font-weight: 600;
        }

        .bottom-links a:hover {
            text-decoration: underline;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-panel,
            .right-panel {
                width: 100%;
                padding: 30px;
            }

            .left-panel h1 {
                font-size: 1.8rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <video id="background-video" autoplay muted loop>
        <source src="{{ asset('InShot_20250624_142253030 (online-video-cutter.com).mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="container">
        <!-- Left Panel -->
        <div class="left-panel">
            <div class="logo">
                <img src="https://bitmaxgroup.com/assets/logo/logo.png" alt="Bitmax Logo">
            </div>
            <h1>Welcome to CRM</h1>
            <p>
                Bitmax CRM — Secure, Fast & Simple. Manage employees, sales & support in one place.
            </p>
            <div class="footer-text">Bitmax Technology Private Limited</div>
        </div>

        <!-- Right Panel (Login Form) -->
        <div class="right-panel">
            <form class="login-form" method="POST" action="{{ route('employee.login') }}">
                @csrf
                <h2>Employee Login</h2>
                <p class="sub-text">Welcome! Please enter your credentials to access your account.</p>

                @if(session('success'))
                    <div class="alert alert-success" style="padding: 0.75rem; border-radius: 5px; margin-bottom: 1rem; font-size: 0.9rem; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger" style="padding: 0.75rem; border-radius: 5px; margin-bottom: 1rem; font-size: 0.9rem; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                        <ul style="margin: 0; padding-left: 1rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label for="employee_code">Employee Code</label>
                <input type="text" id="employee_code" name="employee_code" value="{{ old('employee_code') }}" required autofocus />

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required />

              <div class="options">
    <label>
        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        Remember Me
    </label>
</div>

<button type="submit">Login</button>


            </form>
        </div>
    </div>

