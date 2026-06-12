@extends('layouts.app')

@section('title', 'Tambah Perangkat - FR-SIOT Platform')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-active">Tambah Perangkat</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <h1>Registrasi Perangkat Baru</h1>
        <p>Hubungkan perangkat keras Anda ke dalam sistem.</p>
    </div>
    <a href="{{ route('device.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="settings-card" style="max-width: 600px; margin: 0 auto;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('device.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama_device">Nama Perangkat</label>
            <input 
                type="text" 
                name="nama_device" 
                id="nama_device" 
                placeholder="contoh: Smart Home Controller" 
                value="{{ old('nama_device') }}" 
                required 
                class="form-control"
            >
        </div>

        <div class="form-group">
            <label for="serial_number">Serial Number / Unique ID</label>
            <input 
                type="text" 
                name="serial_number" 
                id="serial_number" 
                placeholder="contoh: ESP32_001" 
                value="{{ old('serial_number') }}" 
                required 
                class="form-control"
            >
        </div>

        <div class="form-group">
            <label for="mqtt_client_id">MQTT Client ID (Opsional)</label>
            <input 
                type="text" 
                name="mqtt_client_id" 
                id="mqtt_client_id" 
                placeholder="contoh: client_smart_home" 
                value="{{ old('mqtt_client_id') }}" 
                class="form-control"
            >
        </div>

        <div class="form-group">
            <label for="topic_prefix">Topic Prefix MQTT</label>
            <input 
                type="text" 
                name="topic_prefix" 
                id="topic_prefix" 
                placeholder="contoh: fakhri" 
                value="{{ old('topic_prefix', 'fakhri') }}" 
                required 
                class="form-control"
            >
            <small style="color: var(--text-muted); display: block; margin-top: 4px;">Perangkat ini akan mendengarkan dan mengirim topik dengan awalan ini (misal: <code>prefix/suhu</code>).</small>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Simpan Perangkat</button>
    </form>
</div>
@endsection