<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .hero-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
    </style>
</head>
<body class="d-flex align-items-center">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="hero-card p-5">
                    @if (Route::has('login'))
                        <div class="text-end mb-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
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

                    <div class="text-center py-5">
                        <h1 class="display-3 fw-bold mb-3">
                            <span class="text-primary">Welcome to</span><br>
                            {{ config('app.name', 'Laravel') }}
                        </h1>
                        <p class="lead text-muted mb-4">
                            Modern application with Laravel 12, FrankenPHP, and Bootstrap 5
                        </p>
                    </div>

                    <div class="row g-4 mt-4">
                        <div class="col-md-4">
                            <div class="text-center p-4">
                                <div class="feature-icon mx-auto mb-3">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h5 class="fw-bold">Secure Authentication</h5>
                                <p class="text-muted">Email verification & Google OAuth</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-center p-4">
                                <div class="feature-icon mx-auto mb-3">
                                    <i class="bi bi-lightning-charge"></i>
                                </div>
                                <h5 class="fw-bold">Fast Performance</h5>
                                <p class="text-muted">Powered by FrankenPHP</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-center p-4">
                                <div class="feature-icon mx-auto mb-3">
                                    <i class="bi bi-puzzle"></i>
                                </div>
                                <h5 class="fw-bold">Modern Stack</h5>
                                <p class="text-muted">Laravel 12, MySQL, Bootstrap 5</p>
                            </div>
                        </div>
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
