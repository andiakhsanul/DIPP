@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle border border-3 border-white" width="80" height="80">
                            @else
                                <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center border border-3 border-white" style="width: 80px; height: 80px; font-size: 2rem; font-weight: 700;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            <h3 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                            <p class="mb-2 opacity-75">
                                <i class="bi bi-envelope me-1"></i> {{ Auth::user()->email }}
                                @if(Auth::user()->hasVerifiedEmail())
                                    <span class="badge bg-success ms-2">
                                        <i class="bi bi-check-circle-fill"></i> Terverifikasi
                                    </span>
                                @endif
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                @if(Auth::user()->google_id)
                                    <span class="badge bg-white text-primary">
                                        <i class="bi bi-google"></i> Google Account
                                    </span>
                                @endif
                                <span class="badge bg-white text-primary">
                                    <i class="bi bi-calendar3"></i> Bergabung {{ Auth::user()->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!Auth::user()->hasCompletedProfile())
        <!-- Alert: Profile Incomplete -->
        <div class="alert alert-warning border-0 shadow-sm mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-3 me-3"></i>
                <div class="flex-grow-1">
                    <h5 class="alert-heading mb-1">Profile Belum Lengkap</h5>
                    <p class="mb-2">Anda harus melengkapi profile terlebih dahulu sebelum dapat mendaftar pelatihan.</p>
                    <a href="{{ route('profile.create') }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square me-1"></i>Lengkapi Profile Sekarang
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #667eea !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Pendaftaran</p>
                            <h3 class="fw-bold mb-0">{{ $registrations->count() }}</h3>
                        </div>
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-file-earmark-text text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #10b981 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Disetujui</p>
                            <h3 class="fw-bold mb-0 text-success">{{ $registrations->where('status', 'approved')->count() }}</h3>
                        </div>
                        <div class="stat-icon bg-success">
                            <i class="bi bi-check-circle text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #f59e0b !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Menunggu</p>
                            <h3 class="fw-bold mb-0 text-warning">{{ $registrations->where('status', 'pending')->count() }}</h3>
                        </div>
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-hourglass-split text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #ef4444 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Ditolak</p>
                            <h3 class="fw-bold mb-0 text-danger">{{ $registrations->where('status', 'rejected')->count() }}</h3>
                        </div>
                        <div class="stat-icon bg-danger">
                            <i class="bi bi-x-circle text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person-badge text-primary me-2"></i>Profile Saya
                        </h5>
                        @if(Auth::user()->hasCompletedProfile())
                            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(Auth::user()->hasCompletedProfile())
                        <div class="mb-3">
                            <label class="text-muted small mb-1">Nama Lengkap</label>
                            <div class="fw-semibold">{{ Auth::user()->profile->full_name }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small mb-1">NIDN</label>
                            <div class="fw-semibold">{{ Auth::user()->profile->nidn }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small mb-1">Perguruan Tinggi</label>
                            <div class="fw-semibold">{{ Auth::user()->profile->university }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small mb-1">Nomor Telepon</label>
                            <div class="fw-semibold">{{ Auth::user()->profile->phone_number }}</div>
                        </div>
                        <div class="alert alert-success border-0 mb-0">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <small>Profile sudah lengkap</small>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-person-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3 mb-3">Profile belum dilengkapi</p>
                            <a href="{{ route('profile.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Lengkapi Profile
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Registration History -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-clock-history text-primary me-2"></i>Riwayat Pendaftaran
                        </h5>
                        @if(Auth::user()->hasCompletedProfile())
                            <a href="{{ route('registration.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Daftar Baru
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($registrations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Batch</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrations as $registration)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $registration->batch->name }}</div>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    {{ $registration->batch->start_date->format('d M Y') }} - {{ $registration->batch->end_date->format('d M Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                <small>{{ $registration->created_at->format('d M Y H:i') }}</small>
                                            </td>
                                            <td>
                                                @if($registration->status == 'pending')
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-hourglass-split"></i> Menunggu
                                                    </span>
                                                @elseif($registration->status == 'approved')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle-fill"></i> Disetujui
                                                    </span>
                                                @elseif($registration->status == 'rejected')
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle-fill"></i> Ditolak
                                                    </span>
                                                @elseif($registration->status == 'waitlisted')
                                                    <span class="badge bg-info">
                                                        <i class="bi bi-list-ul"></i> Waiting List
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewDetails({{ $registration->id }})">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3 mb-3">Belum ada riwayat pendaftaran</p>
                            @if(Auth::user()->hasCompletedProfile())
                                <a href="{{ route('registration.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Daftar Pelatihan Sekarang
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registration Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Detail Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function viewDetails(registrationId) {
        // This would typically load data via AJAX
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        document.getElementById('modalContent').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        modal.show();
        
        // Simulate loading (replace with actual AJAX call)
        setTimeout(() => {
            document.getElementById('modalContent').innerHTML = `
                <div class="alert alert-info border-0">
                    <i class="bi bi-info-circle me-2"></i>Detail lengkap pendaftaran
                </div>
                <p class="text-muted">Fitur detail akan segera tersedia.</p>
            `;
        }, 500);
    }
</script>
@endpush
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
