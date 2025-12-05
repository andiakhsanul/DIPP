@extends('layouts.app')

@section('title', 'Kelola Registrasi')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Kelola Registrasi</h2>
                    <p class="text-muted mb-0">Review dan approve pendaftaran peserta</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Filter & Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1">{{ $registrations->count() }}</h3>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-warning border-3">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1 text-warning">{{ $registrations->where('status', 'pending')->count() }}</h3>
                    <small class="text-muted">Menunggu</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-success border-3">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1 text-success">{{ $registrations->where('status', 'approved')->count() }}</h3>
                    <small class="text-muted">Disetujui</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-danger border-3">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-1 text-danger">{{ $registrations->where('status', 'rejected')->count() }}</h3>
                    <small class="text-muted">Ditolak</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Registrations Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-list-ul text-primary me-2"></i>Daftar Registrasi
                    </h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Cari nama, NIDN, atau batch...">
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-primary active" onclick="filterStatus('all')">
                        Semua
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="filterStatus('pending')">
                        Menunggu
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="filterStatus('approved')">
                        Disetujui
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="filterStatus('rejected')">
                        Ditolak
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($registrations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="registrationsTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Peserta</th>
                                <th>NIDN</th>
                                <th>Universitas</th>
                                <th>Batch</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th class="pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $index => $registration)
                                <tr data-status="{{ $registration->status }}">
                                    <td class="ps-4">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 0.85rem;">
                                                {{ strtoupper(substr($registration->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $registration->user->name }}</div>
                                                <small class="text-muted">{{ $registration->user->email }}</small>
                                            </div>
                                        </div>
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
                                        <div class="fw-semibold small">{{ $registration->batch->batch_name }}</div>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>{{ $registration->batch->start_date->format('d M Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>{{ $registration->created_at->format('d M Y') }}</small>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ $registration->created_at->format('H:i') }}</div>
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
                                    <td class="pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-primary" onclick="viewDetail({{ $registration->id }})" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @if($registration->status == 'pending')
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
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3 mb-0">Belum ada registrasi</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Detail Registrasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#registrationsTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Filter by status
    let currentFilter = 'all';
    
    function filterStatus(status) {
        currentFilter = status;
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

    // View detail
    function viewDetail(registrationId) {
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        const modalContent = document.getElementById('modalContent');
        
        modalContent.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        
        modal.show();
        
        // Fetch registration details via AJAX
        fetch(`/admin/registrations/${registrationId}/detail`)
            .then(response => response.json())
            .then(data => {
                modalContent.innerHTML = renderDetail(data);
            })
            .catch(error => {
                modalContent.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Gagal memuat detail. Silakan coba lagi.
                    </div>
                `;
            });
    }

    function renderDetail(data) {
        return `
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Informasi Peserta</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted" width="150">Nama Lengkap</td>
                            <td class="fw-semibold">: ${data.user.profile.full_name || '-'}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">NIDN/NIDK/NUPTK</td>
                            <td class="font-monospace">: ${data.user.profile.nidn || '-'}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Institusi/Universitas</td>
                            <td>: ${data.user.profile.university || '-'}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. Telepon</td>
                            <td>: ${data.user.profile.phone_number || '-'}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td>: ${data.user.email}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3"><i class="bi bi-calendar-event me-2"></i>Informasi Batch & Pendaftaran</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted" width="150">Nama Batch</td>
                            <td class="fw-semibold">: ${data.batch.batch_name}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jenis Pelatihan</td>
                            <td>: ${data.batch.training_type}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Periode</td>
                            <td>: ${data.batch.start_date} - ${data.batch.end_date}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Lokasi</td>
                            <td>: ${data.batch.location}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kuota</td>
                            <td>: ${data.batch.max_participants} peserta</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>: <span class="badge bg-${getStatusColor(data.status)}">${getStatusLabel(data.status)}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Daftar</td>
                            <td>: ${data.created_at}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terakhir Update</td>
                            <td>: ${data.updated_at}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12">
                    <h6 class="fw-bold mb-3"><i class="bi bi-file-earmark me-2"></i>Dokumen Pendaftaran</h6>
                    ${data.payment_receipt || data.npwp_ktp || data.surat_tugas || data.pekerti_certificate ? `
                    <div class="row g-3">
                        ${data.payment_receipt ? `
                        <div class="${data.pekerti_certificate ? 'col-md-3' : 'col-md-4'}">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="bi bi-file-earmark-pdf text-primary" style="font-size: 2.5rem;"></i>
                                    <p class="small mt-2 mb-2 fw-semibold">Bukti Pembayaran</p>
                                    <a href="${data.payment_receipt}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                    <a href="${data.payment_receipt}" target="_blank" class="btn btn-sm btn-outline-primary ms-1">
                                        <i class="bi bi-eye me-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                        ` : ''}
                        ${data.npwp_ktp ? `
                        <div class="${data.pekerti_certificate ? 'col-md-3' : 'col-md-4'}">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <i class="bi bi-file-earmark-pdf text-info" style="font-size: 2.5rem;"></i>
                                    <p class="small mt-2 mb-2 fw-semibold">NPWP/KTP</p>
                                    <a href="${data.npwp_ktp}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                    <a href="${data.npwp_ktp}" target="_blank" class="btn btn-sm btn-outline-info ms-1">
                                        <i class="bi bi-eye me-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                        ` : ''}
                        ${data.surat_tugas ? `
                        <div class="${data.pekerti_certificate ? 'col-md-3' : 'col-md-4'}">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <i class="bi bi-file-earmark-pdf text-success" style="font-size: 2.5rem;"></i>
                                    <p class="small mt-2 mb-2 fw-semibold">Surat Tugas</p>
                                    <a href="${data.surat_tugas}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                    <a href="${data.surat_tugas}" target="_blank" class="btn btn-sm btn-outline-success ms-1">
                                        <i class="bi bi-eye me-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                        ` : ''}
                        ${data.pekerti_certificate ? `
                        <div class="col-md-3">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <i class="bi bi-award text-warning" style="font-size: 2.5rem;"></i>
                                    <p class="small mt-2 mb-2 fw-semibold">Sertifikat Pekerti</p>
                                    <a href="${data.pekerti_certificate}" target="_blank" class="btn btn-sm btn-warning">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                    <a href="${data.pekerti_certificate}" target="_blank" class="btn btn-sm btn-outline-warning ms-1">
                                        <i class="bi bi-eye me-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                    ` : `
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Belum ada dokumen yang diupload
                        </div>
                    `}
                </div>
            </div>
        `;
    }

    function getStatusLabel(status) {
        const labels = {
            'pending': 'Menunggu',
            'approved': 'Disetujui',
            'rejected': 'Ditolak',
            'waitlisted': 'Waiting List'
        };
        return labels[status] || status;
    }

    function getStatusColor(status) {
        const colors = {
            'pending': 'warning',
            'approved': 'success',
            'rejected': 'danger',
            'waitlisted': 'info'
        };
        return colors[status] || 'secondary';
    }
</script>
@endpush
