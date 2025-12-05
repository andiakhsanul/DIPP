@extends('layouts.app')

@section('title', 'Register')

@push('styles')
    <style>
        .registration-blocked {
            pointer-events: none;
            opacity: 0.5;
            filter: blur(2px);
            transition: all 0.3s ease;
        }

        .registration-enabled {
            pointer-events: auto;
            opacity: 1;
            filter: none;
            transition: all 0.3s ease;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-md-6">
                <div class="auth-card p-5 shadow-lg rounded-4 bg-white border-0" style="transition: all 0.3s ease;"
                    id="registration-form-container">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold mb-2" style="color: #2c3e50;">Create Account</h2>
                        <p class="text-muted" style="font-size: 0.95rem;">Sign up to get started with your journey</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" id="registration-form">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-medium" style="color: #2c3e50;">Full Name</label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                style="border-radius: 10px; transition: border-color 0.2s ease;" id="name" name="name"
                                value="{{ old('name') }}" required autofocus placeholder="Enter your full name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium" style="color: #2c3e50;">Email Address</label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                style="border-radius: 10px; transition: border-color 0.2s ease;" id="email" name="email"
                                value="{{ old('email') }}" required placeholder="Enter your email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium" style="color: #2c3e50;">Password</label>
                            <input type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                style="border-radius: 10px; transition: border-color 0.2s ease;" id="password"
                                name="password" required placeholder="Min. 8 characters">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text" style="font-size: 0.85rem;">Password must be at least 8 characters long.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-medium" style="color: #2c3e50;">Confirm
                                Password</label>
                            <input type="password" class="form-control form-control-lg"
                                style="border-radius: 10px; transition: border-color 0.2s ease;" id="password_confirmation"
                                name="password_confirmation" required placeholder="Re-enter your password">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-4 py-3 fw-medium"
                            style="border-radius: 10px; background: linear-gradient(135deg, #4B6CB7 0%, #182848 100%); border: none; font-size: 1rem; transition: transform 0.2s ease, box-shadow 0.2s ease;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(75, 108, 183, 0.3)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                            <i class="bi bi-person-plus me-2"></i> Create Account
                        </button>

                        <div class="text-center mb-4">
                            <span class="text-muted px-3" style="position: relative;">
                                <span style="background: white; padding: 0 10px; position: relative; z-index: 1;">or</span>
                                <hr
                                    style="position: absolute; width: 100%; top: 50%; left: 0; margin: 0; border-top: 1px solid #dee2e6;">
                            </span>
                        </div>

                        <a href="{{ route('google.redirect') }}"
                            class="btn btn-light w-100 mb-4 py-3 fw-medium d-flex align-items-center justify-content-center"
                            id="google-register-btn"
                            style="border-radius: 10px; border: 1px solid #dee2e6; transition: all 0.2s ease;"
                            onmouseover="this.style.backgroundColor='#f8f9fa'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'"
                            onmouseout="this.style.backgroundColor=''; this.style.transform='none'; this.style.boxShadow='none'">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="me-3">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                            Sign up with Google
                        </a>

                        <div class="text-center">
                            <p class="mb-0 text-muted" style="font-size: 0.95rem;">Already have an account?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold"
                                    style="color: #4B6CB7; transition: color 0.2s ease;"
                                    onmouseover="this.style.color='#182848'" onmouseout="this.style.color='#4B6CB7'">
                                    Login here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Registration alerts data from server
            const registrationAlerts = @json($registrationAlerts ?? []);

            if (registrationAlerts.length > 0) {
                // Show alerts sequentially
                showAlertsSequentially(registrationAlerts, 0);
            }

            function showAlertsSequentially(alerts, index) {
                if (index >= alerts.length) {
                    return;
                }

                const alert = alerts[index];
                const iconMap = {
                    'info': 'info',
                    'warning': 'warning',
                    'error': 'error',
                    'success': 'success'
                };

                Swal.fire({
                    title: alert.title,
                    html: alert.message.replace(/\n/g, '<br>'),
                    icon: iconMap[alert.alert_type] || 'info',
                    confirmButtonText: index < alerts.length - 1 ? 'Lanjut' : 'Saya Mengerti',
                    confirmButtonColor: '#4B6CB7',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        showAlertsSequentially(alerts, index + 1);
                    }
                });
            }
        });
    </script>
@endpush