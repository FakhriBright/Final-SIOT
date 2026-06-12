@extends('layouts.app')

@section('title', 'Kelola Perangkat - FR-SIOT Platform')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-active">Perangkat</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <h1>Manajemen Perangkat IoT</h1>
        <p>Registrasikan dan atur perangkat mikrokontroler Anda untuk berkomunikasi via MQTT.</p>
    </div>
    <a href="{{ route('device.create') }}" class="btn btn-primary">
        <!-- Plus Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 18px; height: 18px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.75-7.75h-15" />
        </svg>
        Tambah Perangkat
    </a>
</div>

<div class="dashboard-grid">
    @forelse($devices as $device)
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">{{ $device->nama_device }}</span>
                <span class="badge {{ $device->status === 'online' ? 'badge-online' : 'badge-offline' }}">
                    <span class="badge-dot {{ $device->status === 'online' ? 'pulse' : '' }}"></span>
                    {{ ucfirst($device->status) }}
                </span>
            </div>
            
            <div style="margin: var(--spacing-sm) 0 var(--spacing-md) 0; display: flex; flex-direction: column; gap: var(--spacing-xs);">
                <div>
                    <small style="color: var(--text-muted);">Serial Number:</small>
                    <code style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary);">{{ $device->serial_number }}</code>
                </div>
                <div>
                    <small style="color: var(--text-muted);">Client ID:</small>
                    <code style="font-size: 0.9rem;">{{ $device->mqtt_client_id ?? 'N/A' }}</code>
                </div>
                <div>
                    <small style="color: var(--text-muted);">Topic Prefix:</small>
                    <code style="font-size: 0.9rem;">{{ $device->topic_prefix }}/#</code>
                </div>
            </div>

            <div class="stat-meta" style="border-top: 1px solid var(--border-color); padding-top: var(--spacing-sm); margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                <span>Aktif: {{ $device->last_seen ? $device->last_seen->diffForHumans() : 'Belum pernah' }}</span>
                <div style="display: flex; gap: var(--spacing-xs);">
                    <a href="{{ route('device.edit', $device->id) }}" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.825rem;">Edit</a>
                    <form action="{{ route('device.destroy', $device->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.825rem;">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="stat-card" style="grid-column: 1 / -1; align-items: center; justify-content: center; text-align: center; padding: var(--spacing-xl);">
            <div class="stat-icon-wrapper" style="width: 50px; height: 50px; border-radius: var(--radius-full); font-size: 1.5rem; margin-bottom: var(--spacing-md);">📱</div>
            <h3>Belum Ada Perangkat</h3>
            <p style="color: var(--text-secondary); margin-top: var(--spacing-xs); max-width: 400px;">
                Mulailah dengan mendaftarkan mikrokontroler pertama Anda (seperti ESP32) agar data sensor dapat dikirim dan disimpan.
            </p>
            <a href="{{ route('device.create') }}" class="btn btn-primary" style="margin-top: var(--spacing-lg);">Tambah Perangkat Sekarang</a>
        </div>
    @endforelse
</div>
@endsection