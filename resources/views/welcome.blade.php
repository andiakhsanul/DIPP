<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fc;
            min-height: 100vh;
            color: #2c3e50;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #4B6CB7;
        }

        .nav-link {
            font-weight: 500;
            color: #2c3e50;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #4B6CB7;
        }

        .hero-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, rgba(75,108,183,0.03) 0%, rgba(24,40,72,0.03) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #4B6CB7 0%, #182848 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #64748b;
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4B6CB7 0%, #182848 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(75,108,183,0.3);
        }

        .btn-outline-primary {
            border: 2px solid #4B6CB7;
            color: #4B6CB7;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #4B6CB7 0%, #182848 100%);
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(75,108,183,0.2);
        }

        .feature-section {
            padding: 5rem 0;
            background: white;
        }

        .feature-card {
            padding: 2rem;
            border-radius: 16px;
            background: white;
            border: 1px solid rgba(75,108,183,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(75,108,183,0.1);
            border-color: #4B6CB7;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(75,108,183,0.1) 0%, rgba(24,40,72,0.1) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4B6CB7;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background: linear-gradient(135deg, #4B6CB7 0%, #182848 100%);
            color: white;
            transform: scale(1.1);
        }

        .feature-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: #2c3e50;
        }

        .feature-text {
            color: #64748b;
            line-height: 1.6;
        }

        .stats-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, rgba(75,108,183,0.03) 0%, rgba(24,40,72,0.03) 100%);
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #4B6CB7;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #64748b;
            font-weight: 500;
        }

        .footer {
            background: #182848;
            padding: 3rem 0;
            color: white;
        }

        .footer-text {
            color: rgba(255,255,255,0.7);
        }

        .footer-link {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: #4B6CB7;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
            @if (Route::has('login'))
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Digital Information Processing Pipeline</h1>
                    <p class="hero-subtitle">
                        Experience seamless data processing with our modern tech stack, powered by Laravel 12, FrankenPHP, and Bootstrap 5.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="bi bi-rocket-takeoff me-2"></i>Get Started
                        </a>
                        <a href="https://github.com/andiakhsanul/DIPP" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-github me-2"></i>View Source
                        </a>
                        <a href="{{ route('test.show') }}" class="btn btn-outline-primary">
                            <i class="bi bi-envelope me-2"></i>Tes
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <img src="https://placehold.co/600x400/4B6CB7/ffffff?text=DIPP" alt="Hero Image" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="feature-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-title">Secure Authentication</h3>
                        <p class="feature-text">
                            Robust security features including email verification and seamless Google OAuth integration for enhanced user protection.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h3 class="feature-title">Lightning Fast</h3>
                        <p class="feature-text">
                            Powered by FrankenPHP for exceptional speed and performance in processing and handling web requests.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-puzzle"></i>
                        </div>
                        <h3 class="feature-title">Modern Tech Stack</h3>
                        <p class="feature-text">
                            Built with cutting-edge technologies including Laravel 12, MySQL, and Bootstrap 5 for optimal development.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">99.9%</div>
                        <div class="stat-label">System Uptime</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">500ms</div>
                        <div class="stat-label">Average Response Time</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support Available</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-4">{{ config('app.name', 'Laravel') }}</h4>
                    <p class="footer-text">
                        Digital Information Processing Pipeline - A modern solution for data processing needs.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="footer-text mb-0">
                        Made with <i class="bi bi-heart-fill text-danger"></i> by DIPP Team
                        <br>
                        <a href="https://github.com/andiakhsanul/DIPP" target="_blank" class="footer-link">
                            <i class="bi bi-github me-2"></i>GitHub Repository
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

                    <div class="text-center mt-5 pt-4 border-top">
                        <h4 class="mb-3">Ready to get started?</h4>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            @guest
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-rocket-takeoff"></i> Create Account
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg px-5">
                                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-speedometer2"></i> Go to Dashboard
                                </a>
                            @endguest
                        </div>
                    </div>

                    <div class="text-center mt-5 pt-4">
                        <p class="text-muted small mb-0">
                            <i class="bi bi-code-slash"></i> Built with Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
