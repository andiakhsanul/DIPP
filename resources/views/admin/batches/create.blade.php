@extends('layouts.app')

@section('title', 'Buat Batch Baru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Buat Batch Baru</h2>
                    <p class="text-muted mb-0">Tambahkan batch pelatihan baru</p>
                </div>
                <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <form action="{{ route('admin.batches.store') }}" method="POST" id="batchForm">
                @csrf

                <!-- Basic Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-info-circle text-primary me-2"></i>Informasi Dasar
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Batch Name -->
                        <div class="mb-4">
                            <label for="batch_name" class="form-label">
                                Nama Batch <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('batch_name') is-invalid @enderror" 
                                   id="batch_name" 
                                   name="batch_name" 
                                   value="{{ old('batch_name') }}"
                                   placeholder="Contoh: Pelatihan Pekerti Batch 1 - 2025"
                                   required>
                            @error('batch_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Nama batch harus jelas dan mudah diidentifikasi</div>
                        </div>

                        <!-- Training Type -->
                        <div class="mb-4">
                            <label for="training_type" class="form-label">
                                Jenis Pelatihan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('training_type') is-invalid @enderror" 
                                    id="training_type" 
                                    name="training_type"
                                    required>
                                <option value="">Pilih Jenis Pelatihan</option>
                                <option value="Pekerti" {{ old('training_type') == 'Pekerti' ? 'selected' : '' }}>Pekerti</option>
                                <option value="AA" {{ old('training_type') == 'AA' ? 'selected' : '' }}>AA (Applied Approach)</option>
                                <option value="Sertifikasi Dosen" {{ old('training_type') == 'Sertifikasi Dosen' ? 'selected' : '' }}>Sertifikasi Dosen</option>
                            </select>
                            @error('training_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label">
                                Deskripsi
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Deskripsi singkat tentang batch pelatihan ini">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Max Participants -->
                        <div class="mb-4">
                            <label for="max_participants" class="form-label">
                                Kuota Maksimal Peserta <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('max_participants') is-invalid @enderror" 
                                   id="max_participants" 
                                   name="max_participants" 
                                   value="{{ old('max_participants', 50) }}"
                                   min="1"
                                   required>
                            @error('max_participants')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Jumlah maksimal peserta yang dapat diterima</div>
                        </div>

                        <!-- Quota -->
                        <div class="mb-4">
                            <label for="quota" class="form-label">
                                Kuota <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('quota') is-invalid @enderror" 
                                   id="quota" 
                                   name="quota" 
                                   value="{{ old('quota', 50) }}"
                                   min="1"
                                   required>
                            @error('quota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <label for="location" class="form-label">
                                Lokasi
                            </label>
                            <input type="text" 
                                   class="form-control @error('location') is-invalid @enderror" 
                                   id="location" 
                                   name="location" 
                                   value="{{ old('location') }}"
                                   placeholder="Contoh: Ruang Seminar UNAIR">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Schedule -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-calendar-range text-primary me-2"></i>Jadwal Pelatihan
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Start Date -->
                            <div class="col-md-6 mb-4">
                                <label for="start_date" class="form-label">
                                    Tanggal Mulai <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" 
                                       name="start_date" 
                                       value="{{ old('start_date') }}"
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div class="col-md-6 mb-4">
                                <label for="end_date" class="form-label">
                                    Tanggal Selesai <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" 
                                       name="end_date" 
                                       value="{{ old('end_date') }}"
                                       required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info border-0">
                            <i class="bi bi-info-circle me-2"></i>
                            <small>Durasi pelatihan akan dihitung otomatis berdasarkan tanggal mulai dan selesai</small>
                        </div>
                    </div>
                </div>

                <!-- Registration Period -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-calendar-event text-primary me-2"></i>Periode Pendaftaran
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Registration Start -->
                            <div class="col-md-6 mb-4">
                                <label for="registration_start" class="form-label">
                                    Pendaftaran Dibuka <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('registration_start') is-invalid @enderror" 
                                       id="registration_start" 
                                       name="registration_start" 
                                       value="{{ old('registration_start') }}"
                                       required>
                                @error('registration_start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Registration End -->
                            <div class="col-md-6 mb-4">
                                <label for="registration_end" class="form-label">
                                    Pendaftaran Ditutup <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('registration_end') is-invalid @enderror" 
                                       id="registration_end" 
                                       name="registration_end" 
                                       value="{{ old('registration_end') }}"
                                       required>
                                @error('registration_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-warning border-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <small>Pastikan periode pendaftaran dimulai sebelum tanggal mulai pelatihan</small>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-toggle-on text-primary me-2"></i>Status Batch
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>
                                    Terjadwal (Belum dibuka untuk pendaftaran)
                                </option>
                                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>
                                    Dibuka (Pendaftaran aktif)
                                </option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>
                                    Ditutup (Pendaftaran ditutup)
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info border-0 mb-0">
                            <i class="bi bi-lightbulb me-2"></i>
                            <small><strong>Tips:</strong> Gunakan status "Terjadwal" untuk batch yang belum siap dibuka. Ubah ke "Dibuka" ketika siap menerima pendaftaran.</small>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Simpan Batch
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('batchForm');
        const submitBtn = document.getElementById('submitBtn');
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const regStart = document.getElementById('registration_start');
        const regEnd = document.getElementById('registration_end');

        // Validate dates
        endDate.addEventListener('change', function() {
            if (startDate.value && endDate.value) {
                if (new Date(endDate.value) < new Date(startDate.value)) {
                    alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai!');
                    endDate.value = '';
                }
            }
        });

        regEnd.addEventListener('change', function() {
            if (regStart.value && regEnd.value) {
                if (new Date(regEnd.value) < new Date(regStart.value)) {
                    alert('Tanggal tutup pendaftaran tidak boleh lebih awal dari tanggal buka!');
                    regEnd.value = '';
                }
            }
            
            if (startDate.value && regEnd.value) {
                if (new Date(regEnd.value) > new Date(startDate.value)) {
                    alert('Pendaftaran harus ditutup sebelum pelatihan dimulai!');
                    regEnd.value = '';
                }
            }
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        });

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        startDate.setAttribute('min', today);
        endDate.setAttribute('min', today);
    });
</script>
@endpush
