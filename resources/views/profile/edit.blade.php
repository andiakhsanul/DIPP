@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Edit Profile</h2>
                    <p class="text-muted mb-0">Perbarui informasi profile Anda</p>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <!-- Profile Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Update Informasi Profile
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                        @csrf
                        @method('PUT')

                        <!-- Full Name -->
                        <div class="mb-4">
                            <label for="full_name" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('full_name') is-invalid @enderror" 
                                       id="full_name" 
                                       name="full_name" 
                                       value="{{ old('full_name', $profile->full_name ?? '') }}"
                                       placeholder="Masukkan nama lengkap sesuai KTP"
                                       required>
                            </div>
                            @error('full_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NIDN -->
                        <div class="mb-4">
                            <label for="nidn" class="form-label">
                                NIDN (Nomor Induk Dosen Nasional) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-card-text"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('nidn') is-invalid @enderror" 
                                       id="nidn" 
                                       name="nidn" 
                                       value="{{ old('nidn', $profile->nidn ?? '') }}"
                                       placeholder="Contoh: 0012345678"
                                       pattern="[0-9]{10}"
                                       maxlength="10"
                                       required>
                            </div>
                            @error('nidn')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">NIDN terdiri dari 10 digit angka</small>
                        </div>

                        <!-- University -->
                        <div class="mb-4">
                            <label for="university" class="form-label">
                                Perguruan Tinggi <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-building"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('university') is-invalid @enderror" 
                                       id="university" 
                                       name="university" 
                                       value="{{ old('university', $profile->university ?? '') }}"
                                       placeholder="Masukkan nama perguruan tinggi"
                                       required>
                            </div>
                            @error('university')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-4">
                            <label for="phone_number" class="form-label">
                                Nomor Telepon/HP <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="tel" 
                                       class="form-control border-start-0 @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" 
                                       name="phone_number" 
                                       value="{{ old('phone_number', $profile->phone_number ?? '') }}"
                                       placeholder="Contoh: 081234567890"
                                       pattern="[0-9]{10,13}"
                                       required>
                            </div>
                            @error('phone_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Nomor yang dapat dihubungi (10-13 digit)</small>
                        </div>

                        <!-- Warning Box -->
                        <div class="alert alert-warning border-0 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Perhatian:</strong> Pastikan data yang Anda update sudah benar. Data ini akan digunakan untuk keperluan administrasi pelatihan.
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Info Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-shield-check text-success me-2"></i>Informasi Akun
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Email</label>
                            <div class="fw-semibold">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Status Email</label>
                            <div>
                                @if(Auth::user()->hasVerifiedEmail())
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Terverifikasi
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="bi bi-exclamation-circle me-1"></i>Belum Terverifikasi
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Tanggal Bergabung</label>
                            <div class="fw-semibold">{{ Auth::user()->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Role</label>
                            <div>
                                <span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('profileForm');
        const submitBtn = document.getElementById('submitBtn');
        const nidnInput = document.getElementById('nidn');
        const phoneInput = document.getElementById('phone_number');

        // NIDN validation
        nidnInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });

        // Phone number validation
        phoneInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 13) {
                this.value = this.value.slice(0, 13);
            }
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengupdate...';
        });
    });
</script>
@endpush
