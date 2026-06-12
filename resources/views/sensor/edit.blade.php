@extends('layouts.app')

@section('title', 'Edit Sensor - FR-SIOT Platform')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    <span class="breadcrumb-separator">/</span>
    <a href="{{ route('sensor.index') }}" class="breadcrumb-link">Sensor</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-active">Edit Sensor</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <h1>Edit Sensor: {{ $sensor->nama_sensor }}</h1>
        <p>Perbarui informasi atau nilai parameter untuk sensor ini.</p>
    </div>
    <a href="{{ route('sensor.index') }}" class="btn btn-secondary">Kembali</a>
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

    <form action="{{ route('sensor.update', $sensor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_sensor">Nama Sensor</label>
            <input 
                type="text" 
                name="nama_sensor" 
                id="nama_sensor" 
                placeholder="contoh: Sensor Suhu, Sensor Kelembapan" 
                value="{{ old('nama_sensor', $sensor->nama_sensor) }}" 
                required 
                class="form-control"
            >
        </div>

        <div class="form-group">
            <label for="lokasi">Lokasi Sensor</label>
            <input 
                type="text" 
                name="lokasi" 
                id="lokasi" 
                placeholder="contoh: Living Room, Server Room" 
                value="{{ old('lokasi', $sensor->lokasi) }}" 
                required 
                class="form-control"
            >
        </div>

        <div class="form-group">
            <label for="nilai">Nilai Sensor</label>
            <input 
                type="number" 
                name="nilai" 
                id="nilai" 
                placeholder="contoh: 0, 25" 
                value="{{ old('nilai', $sensor->nilai) }}" 
                required 
                class="form-control"
            >
        </div>

        <div class="form-group checkbox-group">
            <input type="hidden" name="status" value="0">
            <input 
                type="checkbox" 
                name="status" 
                id="status" 
                value="1" 
                {{ old('status', $sensor->status) ? 'checked' : '' }}
            >
            <label for="status">Sensor Aktif</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
    </form>
</div>
@endsection