@extends('layouts.app')

@section('title', 'Buat Alert Registrasi')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="mb-4">
                    <a href="{{ route('admin.registration-alerts.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Buat Alert Registrasi Baru</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.registration-alerts.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Alert <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    name="title" value="{{ old('title') }}"
                                    placeholder="Contoh: Perhatian Sebelum Mendaftar" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan Alert <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message"
                                    name="message" rows="4"
                                    placeholder="Tulis pesan peringatan yang ingin ditampilkan kepada user..."
                                    required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Pesan ini akan ditampilkan dalam SweetAlert saat user membuka halaman
                                    registrasi.</div>
                            </div>

                            <div class="mb-3">
                                <label for="alert_type" class="form-label">Tipe Alert <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('alert_type') is-invalid @enderror" id="alert_type"
                                    name="alert_type" required>
                                    <option value="info" {{ old('alert_type') == 'info' ? 'selected' : '' }}>Info (Biru)
                                    </option>
                                    <option value="warning" {{ old('alert_type') == 'warning' ? 'selected' : '' }}>Warning
                                        (Kuning)</option>
                                    <option value="error" {{ old('alert_type') == 'error' ? 'selected' : '' }}>Error (Merah)
                                    </option>
                                    <option value="success" {{ old('alert_type') == 'success' ? 'selected' : '' }}>Success
                                        (Hijau)</option>
                                </select>
                                @error('alert_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Aktifkan Alert</label>
                                </div>
                                <div class="form-text">Jika diaktifkan, alert akan langsung ditampilkan di halaman
                                    registrasi.</div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i> Simpan Alert
                                </button>
                                <a href="{{ route('admin.registration-alerts.index') }}"
                                    class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection