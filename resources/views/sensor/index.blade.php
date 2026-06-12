@extends('layouts.app')

@section('title', 'Master Sensor - FR-SIOT Platform')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-active">Sensor</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <h1>Master Sensor</h1>
        <p>Definisikan parameter sensor fisik Anda untuk memetakan nilai telemetri di sistem.</p>
    </div>
    <a href="{{ route('sensor.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 18px; height: 18px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.75-7.75h-15" />
        </svg>
        Tambah Sensor
    </a>
</div>

<div class="dashboard-grid">
    @forelse($sensors as $sensor)
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">{{ $sensor->nama_sensor }}</span>
                <span class="badge {{ $sensor->status ? 'badge-online' : 'badge-offline' }}">
                    <span class="badge-dot {{ $sensor->status ? 'pulse' : '' }}"></span>
                    {{ $sensor->status ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <div style="margin: var(--spacing-sm) 0 var(--spacing-md) 0;">
                <div style="font-size: 0.825rem; color: var(--text-muted); margin-bottom: 2px;">Lokasi Ruangan:</div>
                <div style="font-weight: 600; color: var(--text-primary);">{{ $sensor->lokasi }}</div>
            </div>

            <div class="stat-value" style="font-size: 2.75rem; color: var(--primary); font-family: var(--font-heading); margin-bottom: var(--spacing-md);">
                {{ $sensor->nilai }}
                @if($sensor->nama_sensor == 'Suhu' || str_contains(strtolower($sensor->nama_sensor), 'temp'))
                    <span style="font-size: 1.5rem; vertical-align: top;">°C</span>
                @elseif($sensor->nama_sensor == 'Kelembapan' || str_contains(strtolower($sensor->nama_sensor), 'humid'))
                    <span style="font-size: 1.5rem; vertical-align: top;">%</span>
                @endif
            </div>

            <div class="stat-meta" style="border-top: 1px solid var(--border-color); padding-top: var(--spacing-sm); display: flex; justify-content: space-between; align-items: center;">
                <span>Diperbarui: {{ $sensor->updated_at ? $sensor->updated_at->diffForHumans() : 'Belum pernah' }}</span>
                <div style="display: flex; gap: var(--spacing-xs);">
                    <a href="{{ route('sensor.edit', $sensor->id) }}" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.825rem;">Edit</a>
                    <form action="{{ route('sensor.destroy', $sensor->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sensor ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.825rem;">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="stat-card" style="grid-column: 1 / -1; align-items: center; justify-content: center; text-align: center; padding: var(--spacing-xl);">
            <div class="stat-icon-wrapper" style="width: 50px; height: 50px; border-radius: var(--radius-full); font-size: 1.5rem; margin-bottom: var(--spacing-md);">🌡️</div>
            <h3>Belum Ada Sensor</h3>
            <p style="color: var(--text-secondary); margin-top: var(--spacing-xs); max-width: 400px;">
                Daftarkan parameter sensor baru untuk memetakan nilainya ke panel dashboard.
            </p>
            <a href="{{ route('sensor.create') }}" class="btn btn-primary" style="margin-top: var(--spacing-lg);">Tambah Sensor Sekarang</a>
        </div>
    @endforelse
</div>
@endsection