<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>WorkPulse – All-in-One Workplace Platform</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   <link rel="icon" href="{{ $logo ?? asset('favicon.ico') }}" type="image/x-icon">
  <style>
    :root {
      --primary: #5856d6;
      --primary-dark: #4c4bc7;
      --navy: #0f172a;
      --white: #ffffff;
      --light: #f8fafc;
      --gray: #64748b;
      --border: #e2e8f0;
      --gradient: linear-gradient(135deg, #5856d6, #7c6aef);
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { 
      font-family: 'Inter', sans-serif; 
      color: var(--navy); 
      line-height: 1.6; 
      overflow-x: hidden; 
      position: relative;
      background: var(--white);
    }
    html { scroll-behavior: smooth; }

    /* ====================== BACKGROUND ANIMATIONS ====================== */
    .bg-animations {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 1;
    }
    #particles-canvas {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: linear-gradient(135deg, #f5f8ff 0%, #e0e7ff 100%);
    }
    .floating-blob {
      position: absolute;
      top: -60%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle at 35% 65%, rgba(88,86,214,0.22), transparent 65%);
      animation: float 30s infinite alternate ease-in-out;
      pointer-events: none;
    }
    @keyframes float {
      0%   { transform: translate(0, 0) rotate(0deg); }
      100% { transform: translate(12%, 18%) rotate(12deg); }
    }

    /* Content ko background ke upar rakho */
    main { position: relative; z-index: 2; }

    /* ====================== NAVBAR ====================== */
    nav {
      position: fixed;
      top: 0; width: 100%;
      padding: 20px 5%;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
      z-index: 1000;
    }
    .nav-container {
      max-width: 1400px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      font-family: 'Manrope', sans-serif;
      font-size: 28px;
      font-weight: 900;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .nav-links a {
      margin-left: 40px;
      text-decoration: none;
      font-weight: 600;
      color: #334155;
      font-size: 15.5px;
    }
    .nav-links a:hover, .nav-links a.active { color: var(--primary); }

    /* ====================== HERO ====================== */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 140px 5% 100px;
    }
    .hero-content {
      max-width: 1400px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
    }
    .hero-text h1 {
      font-family: 'Manrope', sans-serif;
      font-size: clamp(3rem, 7vw, 4.6rem);
      font-weight: 900;
      line-height: 1.1;
      color: var(--navy);
      margin-bottom: 16px;
    }
    .hero-text .tagline {
      font-size: 1.35rem;
      color: var(--primary);
      font-weight: 700;
      margin-bottom: 16px;
    }
    .hero-text p {
      font-size: 1.1rem;
      color: var(--gray);
      max-width: 480px;
      margin-bottom: 40px;
    }
    .btn {
      padding: 15px 32px;
      border-radius: 12px;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: all 0.3s;
    }
    .btn-primary {
      background: var(--gradient);
      color: white;
      box-shadow: 0 10px 30px rgba(88,86,214,0.25);
    }
    .btn-primary:hover { transform: translateY(-4px); }
    .btn-outline {
      border: 2px solid var(--primary);
      color: var(--primary);
    }
    .btn-outline:hover {
      background: var(--primary);
      color: white;
    }
    .hero-img {
      width: 100%;
      border-radius: 20px;
      box-shadow: 0 25px 60px rgba(0,0,0,0.12);
    }

    /* ====================== SECTIONS ====================== */
    section {
      padding: 110px 5%;
      max-width: 1400px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
    }
    .section-title {
      text-align: center;
      font-family: 'Manrope', sans-serif;
      font-size: clamp(2.4rem, 5vw, 3.4rem);
      font-weight: 900;
      margin-bottom: 80px;
      color: var(--navy);
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 40px;
    }
    .feature-big {
      background: white;
      padding: 48px 32px;
      border-radius: 20px;
      text-align: center;
      border: 1px solid var(--border);
      box-shadow: 0 15px 40px rgba(0,0,0,0.06);
      transition: all 0.4s;
    }
    .feature-big:hover {
      transform: translateY(-12px);
      box-shadow: 0 25px 60px rgba(88,86,214,0.15);
      border-color: var(--primary);
    }
    .feature-big i {
      font-size: 3.2rem;
      margin-bottom: 20px;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .pricing-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
    }
    .price-card {
      background: white;
      padding: 40px 30px;
      border-radius: 18px;
      text-align: center;
      box-shadow: 0 12px 40px rgba(0,0,0,0.08);
      border: 2px solid transparent;
      transition: all 0.4s;
      position: relative;
    }
    .price-card:hover { border-color: var(--primary); transform: translateY(-8px); }
    .price-card.popular {
      border-color: var(--primary);
      background: var(--gradient);
      color: white;
      transform: scale(1.05);
    }
    .price-card.popular::before {
      content: "Most Popular";
      position: absolute;
      top: 14px; right: -36px;
      background: #f59e0b;
      color: white;
      padding: 6px 40px;
      font-size: 0.8rem;
      font-weight: 700;
      transform: rotate(45deg);
    }

    #quote {
      background: var(--white);
      padding: 120px 5%;
      text-align: center;
    }
    .quote-text {
      font-size: 2.1rem;
      font-weight: 600;
      color: var(--navy);
      max-width: 900px;
      margin: 0 auto 24px;
      line-height: 1.5;
    }
    .quote-author {
      font-size: 1.2rem;
      color: var(--primary);
      font-weight: 600;
    }

    footer {
      position: relative;
      z-index: 2;
      background: var(--navy);
      color: #cbd5e1;
      padding: 90px 5% 50px;
      text-align: center;
    }
    .footer-links a {
      color: #e2e8f0;
      margin: 0 20px;
      text-decoration: none;
      font-weight: 500;
    }
    .copyright {
      margin-top: 60px;
      font-size: 0.95rem;
      opacity: 0.8;
    }

    @media (max-width: 992px) {
      .hero-content { grid-template-columns: 1fr; text-align: center; }
      .features-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  
  <div class="bg-animations">
    <div class="floating-blob"></div>
    <canvas id="particles-canvas"></canvas>
  </div>

  <main>
    <!-- Navbar -->
    <nav id="navbar">
      <div class="nav-container">
        <div style="display:flex; align-items:center; justify-content:center;">
    <img src="{{ $logo }}" alt="{{ $company_name }}"
         style="height:40px; width:auto; margin-right:10px;">
    <span style="line-height:1; display:inline-flex; align-items:center; font-weight:800; ">
        {{ $company_name }}
    </span>
</div>

        <div class="nav-links">
          <a href="#home" class="active">Home</a>
          <a href="#features">Features</a>
        
          <a href="#quote">Quote</a>
        </div>
      </div>
    </nav>

    <!-- Hero -->
    <section id="home" class="hero">
      <div class="hero-content">
        <div class="hero-text" data-aos="fade-right">
          <h1>One Platform.<br>Entire Workplace.</h1>
          <div class="tagline">Simple. Smart. Complete.</div>
          <p>Attendance • HR • Payroll • Helpdesk • CRM • WhatsApp Bot</p>
          <div style="margin:40px 0; display:flex; gap:18px; flex-wrap:wrap;">
            <a href="employee/login" class="btn btn-primary">Employee Login</a>
            <a href="admin/login" class="btn btn-outline">Admin Portal</a>
          </div>
        </div>
        <div data-aos="fade-left">
  <img
    src="{{ asset('images/ddb09208e3600460aae90eaa56a0c706-removebg-preview.png') }}"
    alt="Dashboard"
    class="hero-img"
    style="opacity:0.85; filter:drop-shadow(0 10px 25px rgba(0,0,0,0.15));"
  >
</div>

      </div>
    </section>

    <!-- Features -->
    <section id="features">
      <h2 class="section-title">Everything You Need in One Place</h2>
      <div class="features-grid">
        <div class="feature-big" data-aos="fade-up"><i class="fas fa-users-cog"></i><h3>Complete HR Management</h3><p>Recruitment, onboarding, payroll, compliance, performance appraisal – all in one</p></div>
        <div class="feature-big" data-aos="fade-up" data-aos-delay="100"><i class="fas fa-clock"></i><h3>Smart Attendance System</h3><p>Face recognition, geo-fencing, selfie check-in, shift roster, auto overtime & late marks</p></div>
        <div class="feature-big" data-aos="fade-up" data-aos-delay="200"><i class="fas fa-video"></i><h3>Online Interview Platform</h3><p>Video interviews, candidate scheduling, automated reminders, recording & evaluation</p></div>
        <div class="feature-big" data-aos="fade-up" data-aos-delay="300"><i class="fab fa-whatsapp"></i><h3>WhatsApp Bot & Automation</h3><p>Apply leave, view payslip, mark attendance, get alerts – everything on WhatsApp</p></div>
        <div class="feature-big" data-aos="fade-up" data-aos-delay="400"><i class="fas fa-headset"></i><h3>IT Helpdesk & Asset Management</h3><p>Ticketing system, hardware/software tracking, license management & remote support</p></div>
        <div class="feature-big" data-aos="fade-up" data-aos-delay="500"><i class="fas fa-chart-line"></i><h3>Business Development & CRM</h3><p>Lead management, sales pipeline, follow-ups, target vs achievement reports</p></div>
      </div>
    </section>



    <!-- Quote -->
    <section id="quote" data-aos="fade-up">
      <div class="quote-text">
        “The best workplaces run on trust, clarity, and the right tools.<br>
        We provide the tools. You build the culture.”
      </div>
      <div class="quote-author">— WorkPulse Team</div>
    </section>

    <!-- WhatsApp Floating Button with Auto Message -->
<a href="https://wa.me/917065170513?text=Hello%20%F0%9F%91%8B%0AI%20am%20interested%20in%20your%20CRM%20%2F%20HR%20management%20system.%0APlease%20share%20details%20and%20demo."
   target="_blank"
   style="
     position:fixed;
     bottom:20px;
     right:20px;
     width:55px;
     height:55px;
     background:#25D366;
     border-radius:50%;
     display:flex;
     align-items:center;
     justify-content:center;
     box-shadow:0 6px 18px rgba(0,0,0,0.3);
     z-index:9999;
     text-decoration:none;
   ">

  <svg xmlns="http://www.w3.org/2000/svg"
       viewBox="0 0 24 24"
       fill="white"
       width="28"
       height="28">
    <path d="M20.52 3.48A11.78 11.78 0 0012 0a11.8 11.8 0 00-10.2 17.8L0 24l6.4-1.68A11.82 11.82 0 0012 24a11.8 11.8 0 008.52-20.52zM12 22a9.78 9.78 0 01-5-1.38l-.36-.22-3.8 1 1-3.7-.25-.38A9.8 9.8 0 1112 22zm5.4-7.4c-.3-.15-1.8-.9-2.07-1-.28-.1-.48-.15-.7.15-.2.3-.8 1-.98 1.2-.18.2-.35.22-.65.07a8 8 0 01-2.35-1.45 8.7 8.7 0 01-1.65-2.05c-.17-.3 0-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.7-1.7-.95-2.32-.25-.6-.5-.52-.7-.53h-.6c-.2 0-.52.08-.8.37-.28.3-1.05 1-1.05 2.48s1.08 2.9 1.22 3.1c.15.2 2.15 3.28 5.2 4.6.73.32 1.3.5 1.75.65.73.23 1.4.2 1.92.12.6-.1 1.8-.73 2.05-1.43.25-.7.25-1.3.18-1.43-.07-.12-.28-.2-.58-.35z"/>
  </svg>
</a>


    <!-- Footer -->
    <footer>
      <div class="footer-links">
        <a href="#home">Home</a>
        <a href="#features">Features</a>
       
        <a href="#quote">Quote</a>
       
      </div>
      <div class="copyright">
        © 2025 WorkPulse Technologies Pvt Ltd. Made in India
      </div>
    </footer>
  </main>

  <!-- Scripts -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ once: true, duration: 800 });

    // Particles Animation
    const canvas = document.getElementById('particles-canvas');
    const ctx = canvas.getContext('2d');
    let particles = [];
    const numParticles = 90;

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    class Particle {
      constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 4 + 1;
        this.speedX = Math.random() * 1.2 - 0.6;
        this.speedY = Math.random() * 1.2 - 0.6;
      }
      update() {
        this.x += this.speedX;
        this.y += this.speedY;
        if (this.size > 0.2) this.size -= 0.01;
      }
      draw() {
        ctx.fillStyle = 'rgba(88, 86, 214, 0.6)';
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
      }
    }

    function init() {
      particles = [];
      for (let i = 0; i < numParticles; i++) {
        particles.push(new Particle());
      }
    }

    function animate() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      particles.forEach((p, i) => {
        p.update();
        p.draw();
        if (p.size <= 0.3) {
          particles.splice(i, 1);
          particles.push(new Particle());
        }
      });

      // Connect particles
      for (let a = 0; a < particles.length; a++) {
        for (let b = a + 1; b < particles.length; b++) {
          const dist = Math.hypot(particles[a].x - particles[b].x, particles[a].y - particles[b].y);
          if (dist < 130) {
            ctx.strokeStyle = `rgba(88, 86, 214, ${0.3 - dist / 400})`;
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(particles[a].x, particles[a].y);
            ctx.lineTo(particles[b].x, particles[b].y);
            ctx.stroke();
          }
        }
      }
      requestAnimationFrame(animate);
    }

    init();
    animate();

    window.addEventListener('resize', () => {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
      init();
    });
  </script>
</body>
</html>