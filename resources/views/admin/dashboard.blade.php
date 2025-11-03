@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Admin Dashboard</h2>
                    <p class="text-muted mb-0">Kelola sistem pendaftaran pelatihan DIPP</p>
                </div>
                <div class="text-end">
                    <div class="text-muted small">{{ now()->format('l, d F Y') }}</div>
                    <div class="fw-semibold">{{ now()->format('H:i') }} WIB</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #667eea !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Total Pendaftaran</p>
                            <h2 class="fw-bold mb-0">{{ $stats['total_registrations'] }}</h2>
                            <small class="text-muted">Semua periode</small>
                        </div>
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-file-earmark-text text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #f59e0b !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Menunggu Approval</p>
                            <h2 class="fw-bold mb-0 text-warning">{{ $stats['pending_registrations'] }}</h2>
                            <small class="text-warning">Perlu ditindaklanjuti</small>
                        </div>
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-hourglass-split text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #10b981 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Telah Disetujui</p>
                            <h2 class="fw-bold mb-0 text-success">{{ $stats['approved_registrations'] }}</h2>
                            <small class="text-success">Peserta aktif</small>
                        </div>
                        <div class="stat-icon bg-success">
                            <i class="bi bi-check-circle text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card" style="border-left-color: #3b82f6 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Total Batch</p>
                            <h2 class="fw-bold mb-0 text-info">{{ $stats['total_batches'] }}</h2>
                            <small class="text-muted">{{ $stats['active_batches'] }} batch aktif</small>
                        </div>
                        <div class="stat-icon bg-info">
                            <i class="bi bi-calendar-event text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Registrations -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-clock-history text-primary me-2"></i>Pendaftaran Terbaru
                        </h5>
                        <a href="{{ route('admin.registrations.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recent_registrations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Peserta</th>
                                        <th>Batch</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th class="pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_registrations as $registration)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; font-size: 0.9rem;">
                                                        {{ strtoupper(substr($registration->user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $registration->user->name }}</div>
                                                        <small class="text-muted">{{ $registration->user->profile->nidn ?? '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold small">{{ Str::limit($registration->batch->name, 30) }}</div>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $registration->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                @if($registration->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($registration->status == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($registration->status == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
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
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3 mb-0">Belum ada pendaftaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Batch Overview & Quick Actions -->
        <div class="col-lg-4 mb-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-lightning text-warning me-2"></i>Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.batches.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Buat Batch Baru
                        </a>
                        <a href="{{ route('admin.registrations.index') }}" class="btn btn-outline-warning">
                            <i class="bi bi-hourglass-split me-2"></i>Review Pendaftaran
                            @if($stats['pending_registrations'] > 0)
                                <span class="badge bg-warning ms-1">{{ $stats['pending_registrations'] }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-calendar-event me-2"></i>Kelola Batch
                        </a>
                    </div>
                </div>
            </div>

            <!-- Active Batches -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-calendar-check text-success me-2"></i>Batch Aktif
                    </h5>
                </div>
                <div class="card-body">
                    @if($active_batches->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($active_batches as $batch)
                                <div class="list-group-item px-0 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-1 fw-semibold">{{ $batch->name }}</h6>
                                        <span class="badge bg-success">{{ $batch->status }}</span>
                                    </div>
                                    <div class="small text-muted mb-2">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $batch->start_date->format('d M') }} - {{ $batch->end_date->format('d M Y') }}
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="small">
                                            <span class="fw-semibold">{{ $batch->registrations_count }}</span> / {{ $batch->max_participants }} peserta
                                        </div>
                                        <div class="progress flex-grow-1 ms-3" style="height: 6px; max-width: 100px;">
                                            <div class="progress-bar bg-success" style="width: {{ ($batch->registrations_count / $batch->max_participants) * 100 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.batches.index') }}" class="btn btn-sm btn-outline-primary w-100">
                                Lihat Semua Batch
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted small mt-2 mb-0">Tidak ada batch aktif</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Batch Statistics -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-bar-chart text-primary me-2"></i>Statistik Batch
                    </h5>
                </div>
                <div class="card-body">
                    @if($all_batches->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Nama Batch</th>
                                        <th>Periode</th>
                                        <th>Kuota</th>
                                        <th>Terdaftar</th>
                                        <th>Disetujui</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_batches as $batch)
                                        <tr>
                                            <td class="fw-semibold">{{ $batch->name }}</td>
                                            <td>
                                                <small>{{ $batch->start_date->format('d M Y') }} - {{ $batch->end_date->format('d M Y') }}</small>
                                            </td>
                                            <td>{{ $batch->max_participants }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $batch->registrations_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $batch->registrations()->approved()->count() }}</span>
                                            </td>
                                            <td>
                                                @if($batch->status == 'open')
                                                    <span class="badge bg-success">Buka</span>
                                                @elseif($batch->status == 'scheduled')
                                                    <span class="badge bg-warning">Terjadwal</span>
                                                @elseif($batch->status == 'closed')
                                                    <span class="badge bg-secondary">Tutup</span>
                                                @elseif($batch->status == 'completed')
                                                    <span class="badge bg-dark">Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.batches.edit', $batch) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3 mb-3">Belum ada batch yang dibuat</p>
                            <a href="{{ route('admin.batches.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Buat Batch Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .list-group-item {
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f8fafc;
    }
</style>
@endpush
