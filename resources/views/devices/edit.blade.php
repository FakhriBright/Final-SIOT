@extends('layouts.app')

@section('title', 'Edit Perangkat - FR-SIOT Platform')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    <span class="breadcrumb-separator">/</span>
    <a href="{{ route('device.index') }}" class="breadcrumb-link">Perangkat</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-active">Edit Perangkat</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <h1>Edit Perangkat: {{ $device->nama_device }}</h1>
        <p>Perbarui informasi atau konfigurasi MQTT untuk perangkat ini.</p>
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

    <form action="{{ route('device.update', $device->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_device">Nama Perangkat</label>
            <input 
                type="text" 
                name="nama_device" 
                id="nama_device" 
                placeholder="contoh: Smart Home Controller" 
                value="{{ old('nama_device', $device->nama_device) }}" 
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
                value="{{ old('serial_number', $device->serial_number) }}" 
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
                value="{{ old('mqtt_client_id', $device->mqtt_client_id) }}" 
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
                value="{{ old('topic_prefix', $device->topic_prefix) }}" 
                required 
                class="form-control"
            >
            <small style="color: var(--text-muted); display: block; margin-top: 4px;">Perangkat ini mendengarkan dan mengirim topik dengan awalan ini (misal: <code>prefix/suhu</code>).</small>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
    </form>
</div>
@endsection