<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Interview Access - {{ $interview->candidate_name }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #4f46e5;
      --primary-light: #6366f1;
      --gray-100: #f8f9fc;
      --gray-200: #e2e8f0;
      --gray-500: #64748b;
      --gray-700: #334155;
      --gray-900: #1e293b;
      --radius: 16px;
      --transition: all 0.4s ease;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
      color: var(--gray-900);
      overflow: hidden;
      position: relative;
      background: #f0f4ff;
    }

    /* ===== SHARED ANIMATED BACKGROUND ===== */
    .bg-container {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      z-index: -1;
      background: url('/images/interview3.jpg') center/cover no-repeat;
      filter: brightness(1.05) contrast(1.1);
    }

    .bg-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: linear-gradient(135deg, rgba(245, 247, 252, 0.75) 0%, rgba(248, 250, 255, 0.85) 100%);
      pointer-events: none;
      z-index: 2;
    }

    /* Floating Particles */
    .particle {
      position: absolute;
      width: 6px; height: 6px;
      background: rgba(79, 70, 229, 0.35);
      border-radius: 50%;
      pointer-events: none;
      animation: float 18s infinite linear;
      z-index: 0;
    }

    @keyframes float {
      0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
      10% { opacity: 1; }
      90% { opacity: 1; }
      100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
    }

    /* ===== WELCOME SCREEN (5 sec) ===== */
    .welcome {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      z-index: 10;
      transition: opacity 0.8s ease;
      padding: 20px;
      text-align: center;
    }

    .welcome-logo {
      width: 200px;
      height: 120px;
      margin-bottom: 32px;
    }

    .logo-img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(79, 70, 229, 0.3);
      transition: var(--transition);
    }

    .logo-img:hover {
      transform: scale(1.05);
    }

    .card-logo {
      width: 80px;
      height: 80px;
      margin: 0 auto 20px;
      border-radius: 50%;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    .card-logo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .welcome h1 {
      font-size: 48px;
      font-weight: 800;
      color: #0f1a6b;
      letter-spacing: -1.5px;
      margin-bottom: 16px;
      text-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .welcome p {
      font-size: 19px;
      color: #4b5563;
      max-width: 600px;
      line-height: 1.6;
    }

    /* ===== LOGIN CARD (after 5 sec) ===== */
    .login-card {
      position: relative;
      background: rgba(255, 255, 255, 0.94);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      padding: 44px 36px;
      border-radius: var(--radius);
      width: 90%;
      max-width: 450px;
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
      border: 1px solid rgba(226, 232, 240, 0.8);
      z-index: 10;
      opacity: 0;
      transform: translateY(40px);
      transition: all 0.7s ease;
      margin: 20px auto;
    }

    .login-card.show {
      opacity: 1;
      transform: translateY(0);
    }

    .card-header {
      text-align: center;
      margin-bottom: 32px;
    }

    .card-logo {
      width: 80px;
      height: 80px;
      margin: 0 auto 20px;
    }

    .title {
      font-size: 36px;
      font-weight: 700;
      color: #11117b;
      letter-spacing: -0.5px;
    }

    .subtitle {
      font-size: 16px;
      color: var(--gray-500);
      margin-top: 8px;
    }

    /* Input */
    .input-group {
      margin-bottom: 24px;
      position: relative;
    }

    .input-group input {
      width: 100%;
      height: 56px;
      padding: 0 18px;
      border: 2px solid var(--gray-200);
      border-radius: 12px;
      background: white;
      font-size: 16px;
      color: var(--gray-900);
      transition: var(--transition);
    }

    .input-group input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
    }

    .input-group label {
      position: absolute;
      left: 18px; top: 16px;
      font-size: 15px;
      color: var(--gray-500);
      pointer-events: none;
      transition: var(--transition);
      background: white;
      padding: 0 6px;
    }

    .input-group input:focus ~ label,
    .input-group input:valid ~ label {
      top: -10px; left: 14px; font-size: 12px;
      color: var(--primary);
      font-weight: 600;
    }

    /* Button */
    .btn {
      width: 100%;
      padding: 16px;
      background: linear-gradient(to right, var(--primary), var(--primary-light));
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 17px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      margin-top: 10px;
      letter-spacing: 0.3px;
    }

    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 28px rgba(79, 70, 229, 0.35);
    }

    .back {
      display: block;
      text-align: center;
      margin-top: 28px;
      color: var(--gray-500);
      font-size: 14px;
      text-decoration: none;
      transition: var(--transition);
    }

    .back:hover {
      color: var(--primary);
      text-decoration: underline;
    }

    /* ===== POPUP ===== */
    .popup {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(12px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      transition: var(--transition);
    }

    .popup.show {
      display: flex;
    }

    .popup-content {
      background: white;
      padding: 36px;
      border-radius: var(--radius);
      text-align: center;
      max-width: 360px;
      width: 90%;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
      transform: scale(0.9);
      transition: transform 0.4s ease;
    }

    .popup.show .popup-content {
      transform: scale(1);
    }

    .popup-icon {
      width: 70px; height: 70px;
      margin: 0 auto 18px;
      background: #10b981;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .popup-icon svg {
      width: 40px; height: 40px;
      stroke: white;
      stroke-width: 3.5;
      fill: none;
    }

    .popup h3 {
      font-size: 24px;
      font-weight: 700;
      color: var(--gray-900);
      margin-bottom: 10px;
    }

    .popup p {
      color: var(--gray-500);
      font-size: 15px;
      margin-bottom: 22px;
    }

    .popup button {
      background: var(--primary);
      color: white;
      padding: 13px 28px;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
    }

    .popup button:hover {
      background: var(--primary-light);
      transform: translateY(-1px);
    }

    /* Alert for messages */
    .alert {
      border-radius: 10px;
      margin-bottom: 20px;
    }

    /* Interview Info */
    .interview-info {
      background: rgba(255, 255, 255, 0.8);
      border-radius: 12px;
      padding: 16px;
      margin-top: 20px;
      border: 1px solid rgba(226, 232, 240, 0.6);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .interview-info-icon {
      width: 20px;
      height: 20px;
      margin-right: 8px;
      vertical-align: middle;
      opacity: 0.7;
    }

    .interview-info-text {
      font-size: 14px;
      color: var(--gray-600);
      font-weight: 500;
      margin: 0;
    }
  </style>
</head>
<body>

  <!-- SHARED ANIMATED BACKGROUND -->
  <div class="bg-container" id="bgContainer"></div>
  <div class="bg-overlay"></div>

  <!-- Welcome Screen (5 sec) -->
  <div class="welcome" id="welcome">
    <div class="welcome-logo">
      <img src="http://127.0.0.1:8000/storage/company_logos/1759835482.png" alt="Bitmax Group Logo" class="logo-img">
    </div>
    <h1>Welcome to Bitmax Group</h1>
    <p>Prepare for your interview with confidence, {{ $interview->candidate_name }}</p>
  </div>

  <!-- Login Card (after 5 sec) -->
  <div class="login-card" id="loginCard">
    <div class="card-header">
      <div class="card-logo">
        <img src="http://127.0.0.1:8000/storage/company_logos/1759835482.png" alt="Bitmax Group Logo" class="logo-img">
      </div>
      <div class="title">Welcome Candidate</div>
      <div class="subtitle">Enter your credentials to begin</div>
    </div>

    <div id="message" class="alert d-none" role="alert"></div>

    <form id="interviewForm">
      <div class="input-group">
        <input type="text" id="interview_code" name="interview_code" required />
        <label for="interview_code">Interview Code</label>
      </div>

      <div class="input-group">
        <input type="password" id="password" name="password" required />
        <label for="password">Password</label>
      </div>

      <button type="submit" class="btn" id="submitBtn">
        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
        Verify Credentials
      </button>
    </form>

    <div class="interview-info">
      <svg class="interview-info-icon" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
      </svg> {{ $interview->date->format('l, F j, Y') }} at {{ $interview->time->format('g:i A') }}
      <p class="interview-info-text">
        
      </p>
    </div>

    <a href="/" class="back">Back to Home</a>
  </div>

  <!-- Success Popup -->
  <div class="popup" id="popup">
    <div class="popup-content">
      <div class="popup-icon">
        <svg viewBox="0 0 24 24">
          <polyline points="20 6 9 17 4 12" />
        </svg>
      </div>
      <h3>Login Successful!</h3>
      <p>Can the candidate access the room?</p>
      <button onclick="startInterview()">Yes, Start Interview</button>
    </div>
  </div>

  <script>
    // Generate Floating Particles
    const bg = document.getElementById('bgContainer');
    for (let i = 0; i < 30; i++) {
      const p = document.createElement('div');
      p.className = 'particle';
      p.style.left = Math.random() * 100 + 'vw';
      p.style.animationDelay = Math.random() * 18 + 's';
      p.style.animationDuration = (Math.random() * 12 + 15) + 's';
      bg.appendChild(p);
    }

    // Show login after 5 seconds
    setTimeout(() => {
      const welcome = document.getElementById('welcome');
      const loginCard = document.getElementById('loginCard');

      welcome.style.opacity = '0';
      setTimeout(() => {
        welcome.style.display = 'none';
        loginCard.classList.add('show');
      }, 800);
    }, 5000);

    // Login Submit
    document.getElementById('interviewForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const submitBtn = document.getElementById('submitBtn');
      const spinner = submitBtn.querySelector('.spinner-border');
      const messageDiv = document.getElementById('message');

      // Show loading state
      submitBtn.disabled = true;
      spinner.classList.remove('d-none');

      // Clear previous messages
      messageDiv.className = 'alert d-none';

      const formData = new FormData(this);

      fetch(`{{ route('interview.verify', $interview->unique_link) }}`, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        // Hide loading state
        submitBtn.disabled = false;
        spinner.classList.add('d-none');

        // Show message
        messageDiv.className = `alert ${data.success ? 'alert-success' : 'alert-danger'}`;
        messageDiv.textContent = data.message;
        messageDiv.classList.remove('d-none');

        if (data.success) {
          if (data.is_started) {
            // Interview already started, redirect immediately
            window.location.href = '/interview/start/{{ $interview->unique_link }}';
          } else {
            // Show popup asking to start interview
            document.getElementById('popup').classList.add('show');
          }
        }
      })
      .catch(error => {
        // Hide loading state
        submitBtn.disabled = false;
        spinner.classList.add('d-none');

        // Show error message
        messageDiv.className = 'alert alert-danger';
        messageDiv.textContent = 'An error occurred. Please try again.';
        messageDiv.classList.remove('d-none');

        console.error('Error:', error);
      });
    });

    // Start Interview
    function startInterview() {
      fetch(`{{ route('interview.start', $interview->unique_link) }}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Redirect to interview room
          window.location.href = '/interview/start/{{ $interview->unique_link }}';
        } else {
          alert('Failed to start interview. Please try again.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
      });
    }

    // Go to Schedule (for backward compatibility)
    function goToSchedule() {
      // Redirect to interview page or schedule
      window.location.href = '/interview/start/{{ $interview->unique_link }}';
    }
  </script>

</body>
</html>
