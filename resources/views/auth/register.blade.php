@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6">
            <div class="auth-card p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Create Account</h2>
                    <p class="text-muted">Sign up to get started</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               placeholder="Enter your full name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="Enter your email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               required
                               placeholder="Min. 8 characters">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Password must be at least 8 characters long.</div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password"
                               class="form-control"
                               id="password_confirmation"
                               name="password_confirmation"
                               required
                               placeholder="Re-enter your password">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-person-plus"></i> Create Account
                    </button>

                    <div class="text-center mb-3">
                        <span class="text-muted">or</span>
                    </div>

                    <a href="{{ route('google.redirect') }}" class="btn btn-google w-100 mb-3">
                        <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="me-2">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                        </svg>
                        Sign up with Google
                    </a>

                    <div class="text-center">
                        <p class="mb-0">Already have an account?
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
