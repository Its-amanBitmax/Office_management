<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexlify - Skyrocketing Employee Performance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #22d3ee;
            --light: #f9fafb;
            --dark: #1f2937;
            --gray: #6b7280;
            --success: #10b981;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }
        
        /* Navigation */
        .navbar {
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-scrolled {
            background-color: white;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary) !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            margin: 0 0.5rem;
            position: relative;
        }
        
        .nav-link:before {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:before {
            width: 100%;
        }
        
        /* Hero Section */
        .hero-section {
            position: relative;
            padding: 8rem 0 10rem;
            color: white;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }
        
        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            opacity: 0.15;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .hero-title {
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Stats Section */
        .stats-section {
            position: relative;
            margin-top: -60px;
            z-index: 3;
        }
        
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary);
        }
        
        .stats-number {
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        /* Features Section */
        .section-title {
            position: relative;
            margin-bottom: 3rem;
            font-weight: 800;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 4px;
            background: var(--primary);
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .section-subtitle {
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto 4rem;
            text-align: center;
        }
        
        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card:hover:before {
            opacity: 1;
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary);
            font-size: 1.8rem;
        }
        
        .feature-title {
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        /* Pricing Section */
        .pricing-card {
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            height: 100%;
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .pricing-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .pricing-body {
            padding: 2rem;
        }
        
        .pricing-price {
            font-weight: 800;
            font-size: 2.5rem;
            margin: 1rem 0;
        }
        
        .pricing-feature {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
        }
        
        .pricing-feature i {
            color: var(--success);
            margin-right: 0.5rem;
        }
        
        .pricing-cta {
            margin-top: 2rem;
        }
        
        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            position: relative;
            height: 100%;
        }
        
        .testimonial-card:before {
            content: '"';
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 4rem;
            color: rgba(79, 70, 229, 0.1);
            font-family: Georgia, serif;
            line-height: 1;
        }
        
        .testimonial-text {
            position: relative;
            z-index: 1;
            margin-bottom: 1.5rem;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 1rem;
        }
        
        /* FAQ Section */
        .faq-item {
            border-radius: 12px;
            margin-bottom: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .faq-item:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .faq-header {
            background: white;
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
        }
        
        .faq-content {
            padding: 0 1.5rem 1.5rem;
            background: white;
        }
        
        /* Form Section */
        .form-section {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            position: relative;
            overflow: hidden;
        }
        
        .form-section:before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.05);
            transform: rotate(-15deg);
        }
        
        .form-container {
            background: white;
            border-radius: 16px;
            padding: 3rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }
        
        /* Footer */
        footer {
            background: var(--dark);
            position: relative;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 10px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 10px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }
        
        /* Utilities */
        .rounded-lg {
            border-radius: 16px;
        }
        
        .text-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .floating {
            animation: float 5s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Nexlify</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#stats">Impact</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item ms-2"><a class="btn btn-primary" href="#signup-form">Get Started</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <video class="hero-video" autoplay muted loop>
            <source src="{{ asset('storage/hero.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center hero-content" data-aos="fade-up">
                    <span class="hero-badge" data-aos="fade-up" data-aos-delay="200"><i class="fas fa-rocket me-2"></i>Transform your team's productivity</span>
                    <h1 class="hero-title display-3 fw-bold" data-aos="fade-up" data-aos-delay="300">Skyrocket Your Team's <span class="text-gradient">Performance</span></h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="400">Nexlify helps managers transform employee performance with cutting-edge task management, real-time analytics, and seamless collaboration.</p>
                    <div data-aos="fade-up" data-aos-delay="500">
                        <a href="#signup-form" class="btn btn-primary btn-lg me-3">Start Free Trial</a>
                        <a href="#features" class="btn btn-outline-light btn-lg">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stats-card text-center">
                        <div class="stats-icon mx-auto">
                            <i class="fas fa-smile"></i>
                        </div>
                        <h3 class="stats-number">95%</h3>
                        <p class="text-muted">Customer Satisfaction Rate</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stats-card text-center">
                        <div class="stats-icon mx-auto">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3 class="stats-number">50K+</h3>
                        <p class="text-muted">Tasks Tracked Monthly</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="stats-card text-center">
                        <div class="stats-icon mx-auto">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="stats-number">30%</h3>
                        <p class="text-muted">Average Productivity Boost</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5" style="margin-top: 5rem;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title" data-aos="fade-up">Why Choose Nexlify?</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Our platform is designed to address the unique challenges of modern team management with powerful, intuitive tools.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h5 class="feature-title">Smart Task Management</h5>
                        <p class="text-muted">Effortlessly assign, track, and manage tasks with AI-driven prioritization and workflows.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5 class="feature-title">Advanced Analytics</h5>
                        <p class="text-muted">Unlock actionable insights with real-time performance dashboards and KPI tracking.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="feature-title">Seamless Collaboration</h5>
                        <p class="text-muted">Empower teams with integrated communication and shared goal-setting tools.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title" data-aos="fade-up">Flexible Plans for Every Team</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Choose the plan that works best for your organization. All plans include a 14-day free trial.</p>
                </div>
            </div>
            <div class="row g-4 mt-3">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="pricing-card">
                        <div class="pricing-header">
                            <h5 class="card-title fw-bold">Starter</h5>
                            <p class="mb-0">Perfect for small teams</p>
                        </div>
                        <div class="pricing-body">
                            <h3 class="pricing-price">$29<span class="fs-6 fw-normal">/mo</span></h3>
                            <ul class="list-unstyled mb-4">
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Up to 10 users</li>
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Task Management</li>
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Basic Analytics</li>
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Email Support</li>
                            </ul>
                            <div class="pricing-cta">
                                <a href="#signup-form" class="btn btn-outline-primary w-100">Choose Starter</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="pricing-card" style="transform: scale(1.05);">
                        <div class="pricing-header">
                            <h5 class="card-title fw-bold">Pro</h5>
                            <p class="mb-0">Ideal for growing businesses</p>
                            <span class="badge bg-white text-primary mt-2">Most Popular</span>
                        </div>
                        <div class="pricing-body">
                            <h3 class="pricing-price">$79<span class="fs-6 fw-normal">/mo</span></h3>
                            <ul class="list-unstyled mb-4">
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Up to 50 users</li>
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Advanced Analytics</li>
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Team Collaboration Tools</li>
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Priority Support</li>
                            </ul>
                            <div class="pricing-cta">
                                <a href="#signup-form" class="btn btn-primary w-100">Choose Pro</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="pricing-card">
                        <div class="pricing-header">
                            <h5 class="card-title fw-bold">Enterprise</h5>
                            <p class="mb-0">For large organizations</p>
                        </div>
                        <div class="pricing-body">
                            <h3 class="pricing-price">Custom</h3>
                            <ul class="list-unstyled mb-4">
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Unlimited users</li>
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Custom Integrations</li>
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> Advanced Security</li>
                                <li class="pricing-feature"><i class="fas fa-check-circle"></i> 24/7 Dedicated Support</li>
                            </ul>
                            <div class="pricing-cta">
                                <a href="#signup-form" class="btn btn-outline-primary w-100">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section id="testimonials" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title" data-aos="fade-up">Trusted by Teams Worldwide</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Hear what our customers have to say about their experience with Nexlify.</p>
                </div>
            </div>
            <div class="row g-4 mt-3">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <p class="testimonial-text">"Nexlify has revolutionized our task management, boosting our productivity by 35%! The intuitive interface makes it easy for our entire team to adopt."</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">NS</div>
                            <div>
                                <h6 class="mb-0">Neha S.</h6>
                                <small class="text-muted">HR Manager</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <p class="testimonial-text">"The analytics are incredibly insightful, helping us make smarter decisions daily. We've identified bottlenecks we didn't even know existed."</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">AK</div>
                            <div>
                                <h6 class="mb-0">Arjun K.</h6>
                                <small class="text-muted">Operations Lead</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <p class="testimonial-text">"Team collaboration is seamless with Nexlify's intuitive interface. The shared goals feature has transformed how we work together on projects."</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">PV</div>
                            <div>
                                <h6 class="mb-0">Priya V.</h6>
                                <small class="text-muted">Project Manager</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title" data-aos="fade-up">Frequently Asked Questions</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Find answers to common questions about Nexlify and how it can benefit your organization.</p>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-lg-10">
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="faq-header" data-bs-toggle="collapse" data-bs-target="#faq1">
                            What is Nexlify? <i class="fas fa-chevron-down"></i>
                        </div>
                        <div id="faq1" class="collapse show">
                            <div class="faq-content">
                                Nexlify is a powerful platform designed to streamline task management, track employee performance, and enhance team collaboration with real-time analytics. It helps managers identify strengths, address weaknesses, and optimize team productivity.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="faq-header" data-bs-toggle="collapse" data-bs-target="#faq2">
                            How long is the free trial? <i class="fas fa-chevron-down"></i>
                        </div>
                        <div id="faq2" class="collapse">
                            <div class="faq-content">
                                Nexlify offers a 14-day free trial for all plans, allowing you to explore all features without any commitment. No credit card is required to start your trial.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="faq-header" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Does Nexlify integrate with other tools? <i class="fas fa-chevron-down"></i>
                        </div>
                        <div id="faq3" class="collapse">
                            <div class="faq-content">
                                Yes, Nexlify integrates seamlessly with popular HR, project management, and communication tools including Slack, Microsoft Teams, Asana, Trello, and more to enhance your workflow.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="faq-header" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Is my data secure with Nexlify? <i class="fas fa-chevron-down"></i>
                        </div>
                        <div id="faq4" class="collapse">
                            <div class="faq-content">
                                Absolutely. We take data security seriously. Nexlify uses enterprise-grade security measures including encryption, regular backups, and compliance with industry standards to keep your data safe.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Signup Form Section -->
    <section id="signup-form" class="form-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center text-white mb-5" data-aos="fade-up">
                    <h2 class="fw-bold mb-3">Join the Nexlify Revolution</h2>
                    <p class="fs-5">Start your 14-day free trial today. No credit card required.</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="form-container">
                        <form action="/submit-lead" method="POST" id="signupForm">
                            <div class="mb-4">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" required placeholder="Enter your full name">
                                <div class="invalid-feedback">Please enter your full name.</div>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" required placeholder="Enter your email address">
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            <div class="mb-4">
                                <label for="company" class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="company" name="company" required placeholder="Enter your company name">
                                <div class="invalid-feedback">Please enter your company name.</div>
                            </div>
                            <div class="mb-4">
                                <label for="team_size" class="form-label">Team Size</label>
                                <select class="form-select form-select-lg" id="team_size" name="team_size">
                                    <option value="">Select Team Size</option>
                                    <option value="1-10">1-10 Employees</option>
                                    <option value="11-50">11-50 Employees</option>
                                    <option value="51-200">51-200 Employees</option>
                                    <option value="200+">200+ Employees</option>
                                </select>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100">Start Free Trial</button>
                                <p class="text-muted mt-3">By signing up, you agree to our <a href="{{ route('terms') }}">Terms of Service</a> and <a href="{{ route('privacy') }}">Privacy Policy</a>.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold text-white">Nexlify</h5>
                    <p class="text-muted">Elevate your team's performance with smart task management and analytics.</p>
                    <form class="mt-4" id="newsletterForm">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Subscribe to our newsletter" required>
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="fw-bold text-white">Product</h5>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#">Integrations</a></li>
                        <li><a href="#">Updates</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="fw-bold text-white">Company</h5>
                    <ul class="footer-links">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Press</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="fw-bold text-white">Support</h5>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Community</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-12 mb-4">
                    <h5 class="fw-bold text-white">Connect</h5>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="bg-white">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2025 Nexlify. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="{{ route('privacy') }}" class="text-muted">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="{{ route('terms') }}" class="text-muted">Terms of Service</a></li>
                        <li class="list-inline-item"><a href="#" class="text-muted">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Form validation
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const company = document.getElementById('company');

            let isValid = true;

            if (!name.value) {
                name.classList.add('is-invalid');
                isValid = false;
            } else {
                name.classList.remove('is-invalid');
            }

            if (!email.value || !/\S+@\S+\.\S+/.test(email.value)) {
                email.classList.add('is-invalid');
                isValid = false;
            } else {
                email.classList.remove('is-invalid');
            }

            if (!company.value) {
                company.classList.add('is-invalid');
                isValid = false;
            } else {
                company.classList.remove('is-invalid');
            }

            if (isValid) {
                // Simulate form submission
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                submitBtn.disabled = true;
                
                setTimeout(() => {
                    alert('Thank you for your interest! Your trial account is being set up.');
                    this.reset();
                    submitBtn.innerHTML = 'Start Free Trial';
                    submitBtn.disabled = false;
                }, 2000);
            }
        });

        // Newsletter form validation
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]');
            if (/\S+@\S+\.\S+/.test(email.value)) {
                alert('Thank you for subscribing to our newsletter!');
                email.value = '';
            } else {
                alert('Please enter a valid email address.');
            }
        });

        // FAQ toggle animation
        document.querySelectorAll('.faq-header').forEach(header => {
            header.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon.classList.contains('fa-chevron-down')) {
                    icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                } else {
                    icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                }
            });
        });
    </script>
</body>
</html>