@extends('layouts.app')

@section('title', 'Lengkapi Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Welcome Card -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        <i class="bi bi-person-circle text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="fw-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-muted mb-0">Silakan lengkapi profile Anda untuk melanjutkan pendaftaran pelatihan</p>
                </div>
            </div>

            <!-- Profile Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-file-person text-primary me-2"></i>Informasi Profile
                    </h5>
                    <p class="text-muted small mb-0 mt-2">Pastikan semua data yang Anda masukkan sudah benar</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.store') }}" method="POST" id="profileForm">
                        @csrf

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
                                       value="{{ old('full_name', Auth::user()->name) }}"
                                       placeholder="Masukkan nama lengkap sesuai KTP"
                                       required>
                            </div>
                            @error('full_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Nama lengkap harus sesuai dengan dokumen resmi</small>
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
                                       value="{{ old('nidn') }}"
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
                                       value="{{ old('university') }}"
                                       placeholder="Masukkan nama perguruan tinggi"
                                       required>
                            </div>
                            @error('university')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Nama lengkap institusi tempat Anda mengajar</small>
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
                                       value="{{ old('phone_number') }}"
                                       placeholder="Contoh: 081234567890"
                                       pattern="[0-9]{10,13}"
                                       required>
                            </div>
                            @error('phone_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Nomor yang dapat dihubungi (10-13 digit)</small>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-info border-0 mb-4" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Informasi:</strong> Data yang Anda isi akan digunakan untuk keperluan administrasi pelatihan. Pastikan semua informasi sudah benar sebelum menyimpan.
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Simpan Profile & Lanjutkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="bi bi-question-circle text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <div class="col">
                            <h6 class="mb-1">Butuh Bantuan?</h6>
                            <p class="text-muted small mb-0">Hubungi admin jika Anda mengalami kesulitan dalam mengisi profile</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .input-group-text {
        border-color: #e2e8f0;
    }

    .form-control.border-start-0:focus {
        border-left-color: #e2e8f0 !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:active {
        transform: translateY(0);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('profileForm');
        const submitBtn = document.getElementById('submitBtn');
        const nidnInput = document.getElementById('nidn');
        const phoneInput = document.getElementById('phone_number');

        // NIDN validation - only numbers
        nidnInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });

        // Phone number validation - only numbers
        phoneInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 13) {
                this.value = this.value.slice(0, 13);
            }
        });

        // Form submission with loading state
        form.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        });

        // Auto-focus first input
        document.getElementById('full_name').focus();
    });
</script>
@endpush
