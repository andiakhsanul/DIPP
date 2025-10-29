@extends('layouts.app')

@section('title', 'Detail Batch')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">{{ $batch->batch_name }}</h2>
                    <p class="text-muted mb-0">Detail informasi batch pelatihan</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.batches.edit', $batch) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Batch
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #667eea !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Pendaftar</p>
                            <h2 class="fw-bold mb-0">{{ $batch->registrations_count }}</h2>
                            <small class="text-muted">dari {{ $batch->max_participants }} kuota</small>
                        </div>
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-people text-white"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 8px;">
                        @php
                            $percentage = ($batch->registrations_count / $batch->max_participants) * 100;
                        @endphp
                        <div class="progress-bar {{ $percentage >= 90 ? 'bg-danger' : ($percentage >= 70 ? 'bg-warning' : 'bg-success') }}" 
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #10b981 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Disetujui</p>
                            <h2 class="fw-bold mb-0 text-success">{{ $batch->registrations()->approved()->count() }}</h2>
                            <small class="text-success">Peserta aktif</small>
                        </div>
                        <div class="stat-icon bg-success">
                            <i class="bi bi-check-circle text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #f59e0b !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Menunggu Approval</p>
                            <h2 class="fw-bold mb-0 text-warning">{{ $batch->registrations()->pending()->count() }}</h2>
                            <small class="text-warning">Perlu review</small>
                        </div>
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-hourglass-split text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #3b82f6 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Sisa Kuota</p>
                            <h2 class="fw-bold mb-0 text-info">{{ $batch->availableSlots() }}</h2>
                            <small class="text-muted">Slot tersedia</small>
                        </div>
                        <div class="stat-icon bg-info">
                            <i class="bi bi-clipboard-check text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Batch Information -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-info-circle text-primary me-2"></i>Informasi Batch
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Status -->
                    <div class="mb-3 pb-3 border-bottom">
                        <label class="text-muted small mb-2">Status</label>
                        <div>
                            @if($batch->status == 'open')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-unlock"></i> Dibuka
                                </span>
                            @elseif($batch->status == 'scheduled')
                                <span class="badge bg-warning fs-6">
                                    <i class="bi bi-clock"></i> Terjadwal
                                </span>
                            @elseif($batch->status == 'closed')
                                <span class="badge bg-secondary fs-6">
                                    <i class="bi bi-lock"></i> Ditutup
                                </span>
                            @elseif($batch->status == 'completed')
                                <span class="badge bg-dark fs-6">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    @if($batch->description)
                        <div class="mb-3 pb-3 border-bottom">
                            <label class="text-muted small mb-2">Deskripsi</label>
                            <p class="mb-0">{{ $batch->description }}</p>
                        </div>
                    @endif

                    <!-- Training Period -->
                    <div class="mb-3 pb-3 border-bottom">
                        <label class="text-muted small mb-2">Periode Pelatihan</label>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-calendar-check text-success me-2"></i>
                            <span class="fw-semibold">{{ $batch->start_date->format('d F Y') }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-x text-danger me-2"></i>
                            <span class="fw-semibold">{{ $batch->end_date->format('d F Y') }}</span>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            Durasi: {{ $batch->start_date->diffInDays($batch->end_date) }} hari
                        </small>
                    </div>

                    <!-- Registration Period -->
                    <div class="mb-3 pb-3 border-bottom">
                        <label class="text-muted small mb-2">Periode Pendaftaran</label>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-play-circle text-success me-2"></i>
                            <span>{{ $batch->registration_start->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-stop-circle text-danger me-2"></i>
                            <span>{{ $batch->registration_end->format('d M Y, H:i') }} WIB</span>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="mb-0">
                        <label class="text-muted small mb-2">Informasi Sistem</label>
                        <div class="small">
                            <div class="mb-1">
                                <i class="bi bi-clock me-1"></i>
                                Dibuat: {{ $batch->created_at->format('d M Y, H:i') }}
                            </div>
                            <div>
                                <i class="bi bi-pencil me-1"></i>
                                Update: {{ $batch->updated_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registrations List -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-list-ul text-primary me-2"></i>Daftar Peserta
                        </h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary active" onclick="filterRegistrations('all')">
                                Semua
                            </button>
                            <button type="button" class="btn btn-outline-warning" onclick="filterRegistrations('pending')">
                                Menunggu
                            </button>
                            <button type="button" class="btn btn-outline-success" onclick="filterRegistrations('approved')">
                                Disetujui
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="filterRegistrations('rejected')">
                                Ditolak
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($batch->registrations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="registrationsTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">No</th>
                                        <th>Peserta</th>
                                        <th>NIDN</th>
                                        <th>Universitas</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Status</th>
                                        <th class="pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($batch->registrations as $index => $registration)
                                        <tr data-status="{{ $registration->status }}">
                                            <td class="ps-4">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $registration->user->name }}</div>
                                                <small class="text-muted">{{ $registration->user->email }}</small>
                                            </td>
                                            <td>
                                                <span class="font-monospace small">{{ $registration->user->profile->nidn ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;">
                                                    {{ $registration->user->profile->university ?? '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <small>{{ $registration->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td>
                                                @if($registration->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($registration->status == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($registration->status == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif($registration->status == 'waitlisted')
                                                    <span class="badge bg-info">Waiting List</span>
                                                @endif
                                            </td>
                                            <td class="pe-4">
                                                @if($registration->status == 'pending')
                                                    <div class="btn-group btn-group-sm">
                                                        <form action="{{ route('admin.registrations.approve', $registration) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success" title="Setujui" onclick="return confirm('Setujui pendaftaran ini?')">
                                                                <i class="bi bi-check"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.registrations.reject', $registration) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger" title="Tolak" onclick="return confirm('Tolak pendaftaran ini?')">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3 mb-0">Belum ada peserta terdaftar</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterRegistrations(status) {
        const rows = document.querySelectorAll('#registrationsTable tbody tr');
        const buttons = document.querySelectorAll('.btn-group button');
        
        // Update button states
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        // Filter rows
        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            if (status === 'all' || rowStatus === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endpush
