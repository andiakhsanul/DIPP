@extends('layouts.app')

@section('title', 'Kelola Alert Registrasi')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Alert Registrasi</h2>
                <p class="text-muted mb-0">Kelola peringatan yang muncul saat user melakukan registrasi</p>
            </div>
            <a href="{{ route('admin.registration-alerts.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Alert
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($alerts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Tipe</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alerts as $alert)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $alert->title }}</div>
                                            <small class="text-muted">{{ Str::limit($alert->message, 50) }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $typeBadges = [
                                                    'info' => 'bg-info',
                                                    'warning' => 'bg-warning text-dark',
                                                    'error' => 'bg-danger',
                                                    'success' => 'bg-success'
                                                ];
                                            @endphp
                                            <span class="badge {{ $typeBadges[$alert->alert_type] ?? 'bg-secondary' }}">
                                                {{ ucfirst($alert->alert_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.registration-alerts.toggle', $alert) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm {{ $alert->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                    <i class="bi {{ $alert->is_active ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                                    {{ $alert->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $alert->created_at->format('d M Y, H:i') }}</small>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.registration-alerts.edit', $alert) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.registration-alerts.destroy', $alert) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin ingin menghapus alert ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $alerts->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-bell-slash text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Belum ada alert</h5>
                        <p class="text-muted">Buat alert registrasi baru untuk menampilkan peringatan kepada user.</p>
                        <a href="{{ route('admin.registration-alerts.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Buat Alert Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection