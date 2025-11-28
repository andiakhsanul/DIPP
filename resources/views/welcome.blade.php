<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
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

    <!-- WhatsApp Sticky Button -->
    <div class="whatsapp-sticky">
        <span class="whatsapp-tooltip">Hubungi Admin</span>
        <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20bertanya%20tentang%20DIPP"
           target="_blank"
           class="whatsapp-btn"
           title="Hubungi Admin via WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </a>
    </div>

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
