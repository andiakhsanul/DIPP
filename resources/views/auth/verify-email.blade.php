@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6">
            <div class="auth-card p-5 text-center">
                <div class="mb-4">
                    <i class="bi bi-envelope-check text-primary" style="font-size: 4rem;"></i>
                </div>

                <h2 class="fw-bold mb-3">Verify Your Email Address</h2>

                @if(session('resent'))
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle-fill"></i> A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <p class="text-muted mb-4">
                    Before proceeding, please check your email for a verification link.
                    If you didn't receive the email, click the button below to request another.
                </p>

                <div class="d-grid gap-2">
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-arrow-repeat"></i> Resend Verification Email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>

                <div class="mt-4">
                    <p class="text-muted small mb-0">
                        <i class="bi bi-info-circle"></i> Check your spam folder if you don't see the email
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
