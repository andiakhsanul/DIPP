@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    @if(session('verified'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> Your email has been verified successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle" width="100" height="100">
                            @else
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <h2 class="fw-bold mb-1">Welcome, {{ Auth::user()->name }}! 👋</h2>
                            <p class="text-muted mb-3">
                                <i class="bi bi-envelope"></i> {{ Auth::user()->email }}
                                @if(Auth::user()->email_verified_at)
                                    <span class="badge bg-success ms-2">
                                        <i class="bi bi-patch-check-fill"></i> Verified
                                    </span>
                                @endif
                            </p>
                            <p class="mb-0">
                                @if(Auth::user()->google_id)
                                    <span class="badge bg-info">
                                        <i class="bi bi-google"></i> Connected with Google
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-person-badge"></i> Email Registration
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <i class="bi bi-person-circle text-primary" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Profile</h5>
                    <p class="card-text text-muted">Manage your account settings and preferences</p>
                    <button class="btn btn-outline-primary" disabled>Coming Soon</button>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <i class="bi bi-shield-check text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Security</h5>
                    <p class="card-text text-muted">Update password and security settings</p>
                    <button class="btn btn-outline-success" disabled>Coming Soon</button>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <i class="bi bi-bell text-warning" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Notifications</h5>
                    <p class="card-text text-muted">Manage your notification preferences</p>
                    <button class="btn btn-outline-warning" disabled>Coming Soon</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Account Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td width="200"><strong>Account Created:</strong></td>
                                <td>{{ Auth::user()->created_at->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Last Updated:</strong></td>
                                <td>{{ Auth::user()->updated_at->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email Verified:</strong></td>
                                <td>
                                    @if(Auth::user()->email_verified_at)
                                        <span class="text-success">
                                            <i class="bi bi-check-circle-fill"></i> Yes, verified on {{ Auth::user()->email_verified_at->format('F d, Y') }}
                                        </span>
                                    @else
                                        <span class="text-danger">
                                            <i class="bi bi-x-circle-fill"></i> Not verified
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Login Method:</strong></td>
                                <td>
                                    @if(Auth::user()->google_id)
                                        <i class="bi bi-google"></i> Google OAuth
                                    @else
                                        <i class="bi bi-envelope"></i> Email & Password
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: #f8f9fa !important;
    }
</style>
@endpush
