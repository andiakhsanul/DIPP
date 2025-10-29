@extends('layouts.app')

@section('title', 'Kelola Batch')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Kelola Batch Pelatihan</h2>
                    <p class="text-muted mb-0">Manajemen batch pelatihan dan jadwal</p>
                </div>
                <div>
                    <a href="{{ route('admin.batches.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Buat Batch Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1">{{ $batches->count() }}</h3>
                    <small class="text-muted">Total Batch</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-success border-3">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1 text-success">{{ $batches->where('status', 'open')->count() }}</h3>
                    <small class="text-muted">Dibuka</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-warning border-3">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1 text-warning">{{ $batches->where('status', 'scheduled')->count() }}</h3>
                    <small class="text-muted">Terjadwal</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-secondary border-3">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1 text-secondary">{{ $batches->whereIn('status', ['closed', 'completed'])->count() }}</h3>
                    <small class="text-muted">Selesai</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Batches Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-calendar-event text-primary me-2"></i>Daftar Batch
                    </h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Cari nama batch...">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($batches->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="batchesTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" style="width: 5%">No</th>
                                <th style="width: 25%">Nama Batch</th>
                                <th style="width: 20%">Periode</th>
                                <th style="width: 15%">Pendaftaran</th>
                                <th style="width: 10%">Kuota</th>
                                <th style="width: 10%">Terdaftar</th>
                                <th style="width: 10%">Status</th>
                                <th class="pe-4" style="width: 5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($batches as $index => $batch)
                                <tr>
                                    <td class="ps-4">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $batch->batch_name }}</div>
                                        <small class="text-muted">
                                            <i class="bi bi-tag me-1"></i>{{ $batch->training_type }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="bi bi-calendar-check text-success me-1"></i>
                                            {{ $batch->start_date->format('d M Y') }}
                                        </div>
                                        <div class="small">
                                            <i class="bi bi-calendar-x text-danger me-1"></i>
                                            {{ $batch->end_date->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="bi bi-play-circle text-success me-1"></i>
                                            {{ $batch->registration_start->format('d M Y') }}
                                        </div>
                                        <div class="small">
                                            <i class="bi bi-stop-circle text-danger me-1"></i>
                                            {{ $batch->registration_end->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $batch->max_participants }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-info">{{ $batch->registrations_count }}</span>
                                            <div class="progress flex-grow-1" style="height: 6px; width: 50px;">
                                                @php
                                                    $percentage = $batch->max_participants > 0 ? ($batch->registrations_count / $batch->max_participants) * 100 : 0;
                                                @endphp
                                                <div class="progress-bar {{ $percentage >= 90 ? 'bg-danger' : ($percentage >= 70 ? 'bg-warning' : 'bg-success') }}" 
                                                     style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($batch->status == 'open')
                                            <span class="badge bg-success">
                                                <i class="bi bi-unlock"></i> Dibuka
                                            </span>
                                        @elseif($batch->status == 'scheduled')
                                            <span class="badge bg-warning">
                                                <i class="bi bi-clock"></i> Terjadwal
                                            </span>
                                        @elseif($batch->status == 'closed')
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-lock"></i> Ditutup
                                            </span>
                                        @elseif($batch->status == 'completed')
                                            <span class="badge bg-dark">
                                                <i class="bi bi-check-circle"></i> Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.batches.show', $batch) }}" class="btn btn-outline-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.batches.edit', $batch) }}" class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.batches.destroy', $batch) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus" 
                                                        onclick="return confirm('Yakin ingin menghapus batch ini? Semua registrasi terkait akan ikut terhapus!')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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
@endsection

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#batchesTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endpush
