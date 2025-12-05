@extends('layouts.app')

@section('title', 'Pendaftaran Pelatihan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2">Pendaftaran Pelatihan</h2>
                <p class="text-muted">Lengkapi formulir di bawah ini untuk mendaftar pelatihan</p>
            </div>

            <!-- Progress Steps -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="d-flex flex-column align-items-center">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                    <i class="bi bi-check-lg fs-4"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Profile Lengkap</h6>
                                <small class="text-muted">Data diri telah diisi</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                    <i class="bi bi-pencil fs-4"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Isi Formulir</h6>
                                <small class="text-muted">Sedang diproses</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column align-items-center">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                    <i class="bi bi-hourglass-split fs-4"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Menunggu Approval</h6>
                                <small class="text-muted">Setelah submit</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
                @csrf

                <!-- Batch Selection -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-calendar-event text-primary me-2"></i>Pilih Batch Pelatihan
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="batch_id" class="form-label">
                                Batch Pelatihan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('batch_id') is-invalid @enderror" 
                                    id="batch_id" 
                                    name="batch_id" 
                                    required>
                                <option value="">-- Pilih Batch --</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" 
                                            data-quota="{{ $batch->max_participants }}"
                                            data-registered="{{ $batch->registrations_count }}"
                                            data-available="{{ $batch->availableSlots() }}"
                                            {{ old('batch_id') == $batch->id ? 'selected' : '' }}>
                                        {{ $batch->name }} 
                                        ({{ $batch->start_date->format('d M Y') }} - {{ $batch->end_date->format('d M Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('batch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Batch Info (Hidden by default) -->
                        <div id="batchInfo" class="alert alert-info border-0 d-none">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="mb-2 fw-bold" id="batchName"></h6>
                                    <p class="mb-2 small" id="batchDescription"></p>
                                    <div class="d-flex gap-3 small">
                                        <span><i class="bi bi-calendar3 me-1"></i><strong>Mulai:</strong> <span id="batchStart"></span></span>
                                        <span><i class="bi bi-calendar-check me-1"></i><strong>Selesai:</strong> <span id="batchEnd"></span></span>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <div class="quota-info">
                                        <div class="small text-muted mb-1">Kuota Batch</div>
                                        <h3 class="mb-0 fw-bold" id="maxQuota">-</h3>
                                        <small class="text-muted">peserta</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Uploads -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-file-earmark-arrow-up text-primary me-2"></i>Upload Dokumen
                        </h5>
                        <p class="text-muted small mb-0 mt-2">Semua file harus dalam format JPG, PNG, atau PDF (Max: 2MB)</p>
                    </div>
                    <div class="card-body p-4">
                        <!-- Payment Receipt -->
                        <div class="mb-4">
                            <label for="payment_receipt" class="form-label">
                                Bukti Pembayaran <span class="text-danger">*</span>
                            </label>
                            <input type="file" 
                                   class="form-control @error('payment_receipt') is-invalid @enderror" 
                                   id="payment_receipt" 
                                   name="payment_receipt" 
                                   accept="image/*,.pdf"
                                   required>
                            @error('payment_receipt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Upload bukti transfer pembayaran pelatihan
                            </div>
                            <div class="mt-2" id="payment_receipt_preview"></div>
                        </div>

                        <!-- NPWP/KTP -->
                        <div class="mb-4">
                            <label for="npwp_ktp" class="form-label">
                                NPWP atau KTP <span class="text-danger">*</span>
                            </label>
                            <input type="file" 
                                   class="form-control @error('npwp_ktp') is-invalid @enderror" 
                                   id="npwp_ktp" 
                                   name="npwp_ktp" 
                                   accept="image/*,.pdf"
                                   required>
                            @error('npwp_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Upload scan/foto NPWP atau KTP Anda
                            </div>
                            <div class="mt-2" id="npwp_ktp_preview"></div>
                        </div>

                        <!-- Surat Tugas -->
                        <div class="mb-4">
                            <label for="surat_tugas" class="form-label">
                                Surat Tugas dari Institusi <span class="text-danger">*</span>
                            </label>
                            <input type="file" 
                                   class="form-control @error('surat_tugas') is-invalid @enderror" 
                                   id="surat_tugas" 
                                   name="surat_tugas" 
                                   accept="image/*,.pdf"
                                   required>
                            @error('surat_tugas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Upload surat tugas resmi dari perguruan tinggi
                            </div>
                            <div class="mt-2" id="surat_tugas_preview"></div>
                        </div>

                        <!-- Sertifikat Pekerti (Conditional for AA batch) -->
                        <div class="mb-4 d-none" id="pekerti_certificate_field">
                            <label for="pekerti_certificate" class="form-label">
                                Sertifikat Pekerti <span class="text-danger">*</span>
                            </label>
                            <input type="file" 
                                   class="form-control @error('pekerti_certificate') is-invalid @enderror" 
                                   id="pekerti_certificate" 
                                   name="pekerti_certificate" 
                                   accept="image/*,.pdf">
                            @error('pekerti_certificate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Upload sertifikat pekerti (Required untuk batch jenis AA)
                            </div>
                            <div class="mt-2" id="pekerti_certificate_preview"></div>
                        </div>

                        <!-- File Size Warning -->
                        <div class="alert alert-warning border-0">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Perhatian:</strong> Pastikan semua file yang diupload jelas dan terbaca. Ukuran maksimal setiap file adalah 2MB.
                        </div>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Saya menyatakan bahwa data yang saya isi adalah benar dan dapat dipertanggungjawabkan. 
                                Saya bersedia mengikuti seluruh rangkaian pelatihan yang telah dijadwalkan. <span class="text-danger">*</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="bi bi-send me-2"></i>Submit Pendaftaran
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .file-preview {
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .file-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 6px;
    }

    .progress-bar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .quota-full {
        color: #ef4444;
    }

    .quota-limited {
        color: #f59e0b;
    }

    .quota-available {
        color: #10b981;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const batchSelect = document.getElementById('batch_id');
        const batchInfo = document.getElementById('batchInfo');
        const form = document.getElementById('registrationForm');
        const submitBtn = document.getElementById('submitBtn');

        // Batch data (from backend)
        const batchesData = @json($batches);

        // Handle batch selection
        batchSelect.addEventListener('change', function() {
            const batchId = this.value;
            if (batchId) {
                const batch = batchesData.find(b => b.id == batchId);
                if (batch) {
                    displayBatchInfo(batch);
                    batchInfo.classList.remove('d-none');
                }
            } else {
                batchInfo.classList.add('d-none');
            }
        });

        function displayBatchInfo(batch) {
            const available = batch.max_participants - batch.registrations_count;
            
            document.getElementById('batchName').textContent = batch.name;
            document.getElementById('batchDescription').textContent = batch.description || 'Tidak ada deskripsi';
            document.getElementById('batchStart').textContent = formatDate(batch.start_date);
            document.getElementById('batchEnd').textContent = formatDate(batch.end_date);
            document.getElementById('maxQuota').textContent = batch.max_participants;
            
            // Show/hide pekerti certificate field based on batch requirement
            const pekertiField = document.getElementById('pekerti_certificate_field');
            const pekertiInput = document.getElementById('pekerti_certificate');
            
            if (batch.requires_pekerti_certificate) {
                pekertiField.classList.remove('d-none');
                pekertiInput.setAttribute('required', 'required');
            } else {
                pekertiField.classList.add('d-none');
                pekertiInput.removeAttribute('required');
                pekertiInput.value = ''; // Clear file input
                document.getElementById('pekerti_certificate_preview').innerHTML = ''; // Clear preview
            }
            
            // Check if quota is full and disable submit button
            if (available === 0) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-x-circle me-2"></i>Kuota Penuh';
            } else {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-send me-2"></i>Submit Pendaftaran';
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            return date.toLocaleDateString('id-ID', options);
        }

        // File preview handlers
        const fileInputs = ['payment_receipt', 'npwp_ktp', 'surat_tugas', 'pekerti_certificate'];
        fileInputs.forEach(inputName => {
            const input = document.getElementById(inputName);
            const preview = document.getElementById(inputName + '_preview');

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 2MB');
                        this.value = '';
                        preview.innerHTML = '';
                        return;
                    }

                    // Show preview
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.innerHTML = `
                                <div class="file-preview">
                                    <img src="${e.target.result}" alt="Preview">
                                    <div class="mt-2 small text-muted">
                                        <i class="bi bi-file-earmark-image me-1"></i>${file.name} (${(file.size / 1024).toFixed(2)} KB)
                                    </div>
                                </div>
                            `;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.innerHTML = `
                            <div class="file-preview">
                                <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 3rem;"></i>
                                <div class="mt-2 small">
                                    <i class="bi bi-check-circle text-success me-1"></i>${file.name} (${(file.size / 1024).toFixed(2)} KB)
                                </div>
                            </div>
                        `;
                    }
                }
            });
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
            
            // Show loading overlay
            document.getElementById('loadingOverlay').classList.add('show');
        });

        // Trigger batch info if already selected
        if (batchSelect.value) {
            batchSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
