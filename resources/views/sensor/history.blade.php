@extends('layouts.app')

@section('title', 'Riwayat Sensor - FR-SIOT Platform')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-active">Riwayat Sensor</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <h1>Riwayat Data Sensor</h1>
        <p>Lihat, filter, dan unduh seluruh data telemetri yang terekam dari broker MQTT.</p>
    </div>
    <a href="{{ request()->fullUrlWithQuery(['export' => 'true']) }}" class="btn btn-primary">
        <!-- Download/Export icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 18px; height: 18px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        Ekspor CSV
    </a>
</div>

<!-- FILTER BAR -->
<div class="filter-bar">
    <form action="{{ route('sensor.history') }}" method="GET" class="filter-form-group">
        
        <!-- Search Input -->
        <input 
            type="text" 
            name="search" 
            placeholder="Cari nilai, topic..." 
            value="{{ request('search') }}" 
            class="form-control search-input"
        >

        <!-- Device Filter -->
        <select name="device_id" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Perangkat</option>
            @foreach($devices as $device)
                <option value="{{ $device->id }}" {{ request('device_id') == $device->id ? 'selected' : '' }}>
                    {{ $device->nama_device }} ({{ $device->serial_number }})
                </option>
            @endforeach
        </select>

        <!-- Type Filter -->
        <select name="type" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Tipe</option>
            @foreach($types as $type)
                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-secondary">Filter</button>
        
        @if(request()->anyFilled(['search', 'device_id', 'type', 'sort']))
            <a href="{{ route('sensor.history') }}" class="btn btn-secondary" style="background-color: var(--danger-bg); color: var(--danger); border-color: rgba(239,68,68,0.1)">Reset</a>
        @endif
    </form>
</div>

<!-- LOGS TABLE -->
<div class="table-wrapper">
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Perangkat</th>
                    <th>Topic MQTT</th>
                    
                    <!-- Sortable Column: Type -->
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'type', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                            Tipe Data
                            @if(request('sort') === 'type')
                                {!! request('direction') === 'asc' ? '↑' : '↓' !!}
                            @endif
                        </a>
                    </th>
                    
                    <!-- Sortable Column: Value -->
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'value', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                            Nilai
                            @if(request('sort') === 'value')
                                {!! request('direction') === 'asc' ? '↑' : '↓' !!}
                            @endif
                        </a>
                    </th>
                    
                    <th>Status Device</th>
                    
                    <!-- Sortable Column: Created At -->
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                            Waktu Diterima
                            @if(!request('sort') || request('sort') === 'created_at')
                                {!! request('direction') === 'asc' ? '↑' : '↓' !!}
                            @endif
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>
                            @if($log->device)
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('device.edit', $log->device->id) }}" style="font-weight: 600;">
                                        {{ $log->device->nama_device }}
                                    </a>
                                @else
                                    <strong style="color: var(--text-primary);">{{ $log->device->nama_device }}</strong>
                                @endif
                                <br>
                                <small style="color: var(--text-muted);">{{ $log->device->serial_number }}</small>
                            @else
                                <span style="color: var(--text-muted);">Tidak Dikenal</span>
                            @endif
                        </td>
                        <td><code>{{ $log->topic }}</code></td>
                        <td>
                            <span class="badge" style="background-color: var(--bg-input); color: var(--text-primary); border: 1px solid var(--border-color)">
                                @if($log->type === 'suhu')
                                    🌡️ Suhu
                                @elseif($log->type === 'kelembapan')
                                    💧 Kelembapan
                                @elseif($log->type === 'servo')
                                    ⚙️ Servo
                                @elseif($log->type === 'lcd')
                                    📺 LCD
                                @elseif($log->type === 'status')
                                    📶 Status
                                @else
                                    🔄 {{ ucfirst($log->type) }}
                                @endif
                            </span>
                        </td>
                        <td>
                            <strong>{{ $log->value }}</strong>
                            @if($log->type === 'suhu')
                                °C
                            @elseif($log->type === 'kelembapan')
                                %
                            @elseif($log->type === 'servo')
                                °
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $log->status === 'online' ? 'badge-online' : 'badge-offline' }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($log->status) }}
                            </span>
                        </td>
                        <td>
                            {{ $log->created_at->format('d M Y H:i:s') }}
                            <br>
                            <small style="color: var(--text-muted);">{{ $log->created_at->diffForHumans() }}</small>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: var(--spacing-xl);">
                            Tidak ada data riwayat sensor yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- PAGINATION AREA -->
@if($logs->hasPages())
    <div class="pagination-area filter-bar">
        <div style="font-size: 0.875rem; color: var(--text-secondary);">
            Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} log data
        </div>
        <div>
            {{ $logs->links() }}
        </div>
    </div>
@endif

@endsection
