@extends('layouts.app')

@section('title', 'Pengaturan - FR-SIOT Platform')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-active">Pengaturan</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <h1>Pengaturan Sistem</h1>
        <p>Konfigurasi parameter global dan konektivitas MQTT Broker platform FR-SIOT.</p>
    </div>
</div>

<div class="settings-card" style="max-width: 800px; margin: 0 auto;">
    
    <!-- MQTT SECTION -->
    <div class="settings-section">
        <h3 class="settings-section-title">Konfigurasi MQTT Broker</h3>
        <p class="settings-section-desc">Koneksi broker utama untuk komunikasi telemetri data dua arah.</p>
        
        <div class="form-group">
            <label for="mqtt_host">MQTT Broker WebSocket Host</label>
            <input type="text" id="mqtt_host" value="wss://fakhrisensor.cloud.shiftr.io" disabled class="form-control" style="cursor: not-allowed; opacity: 0.8;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md);">
            <div class="form-group">
                <label for="mqtt_user">Username</label>
                <input type="text" id="mqtt_user" value="fakhrisensor" disabled class="form-control" style="cursor: not-allowed; opacity: 0.8;">
            </div>
            <div class="form-group">
                <label for="mqtt_pass">Password / Token</label>
                <input type="password" id="mqtt_pass" value="•••••••••••••••••" disabled class="form-control" style="cursor: not-allowed; opacity: 0.8;">
            </div>
        </div>
        <small style="color: var(--text-muted);">* Pengaturan broker MQTT dikonfigurasi melalui berkas kode utama dan variabel lingkungan demi keamanan sistem.</small>
    </div>

    <!-- GENERAL CONFIG -->
    <div class="settings-section">
        <h3 class="settings-section-title">Preferensi Dashboard</h3>
        <p class="settings-section-desc">Kelola opsi penampilan antarmuka web.</p>
        
        <div class="form-group checkbox-group">
            <input type="checkbox" id="pref_realtime" checked>
            <label for="pref_realtime">Aktifkan Update Live Real-Time</label>
        </div>
        
        <div class="form-group checkbox-group">
            <input type="checkbox" id="pref_notifications" checked>
            <label for="pref_notifications">Tampilkan Toast Notifikasi Saat Perangkat Online/Offline</label>
        </div>
    </div>

    <button type="button" class="btn btn-primary" onclick="showToast('Pengaturan Disimpan', 'Konfigurasi preferensi lokal berhasil diperbarui.', 'success')">Simpan Preferensi</button>

</div>
@endsection
