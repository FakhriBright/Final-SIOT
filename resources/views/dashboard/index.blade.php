@extends('layouts.app')

@section('title', 'Dashboard - FR-SIOT Platform')

@section('breadcrumb')
    <span class="breadcrumb-active">Dashboard</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <h1>Monitoring & Kontrol</h1>
        <p>Aktivitas real-time dan kendali jarak jauh perangkat IoT Anda.</p>
    </div>
    <div class="badge" id="mqtt-connection-status" class="badge badge-offline">
        <span class="badge-dot pulse"></span>
        <span id="mqtt-status-text">MQTT Terputus</span>
    </div>
</div>

<!-- STATS SUMMARY -->
<div class="dashboard-grid">
    
    <!-- Perangkat Terdaftar -->
    <div class="stat-card">
        <div class="stat-card-glow"></div>
        <div class="stat-header">
            <span class="stat-title">Total Perangkat</span>
            <div class="stat-icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3V7.5a3 3 0 013-3h13.5a3 3 0 013 3v3.75a3 3 0 01-3 3zm-.75 3h1.5m1.5 0h1.5m-4.5 0H3m18 0h-3.75" />
                </svg>
            </div>
        </div>
        <div class="stat-value" id="stat-devices">{{ $deviceCount }}</div>
        <div class="stat-meta">Perangkat IoT Aktif</div>
    </div>

    <!-- Total Data Log -->
    <div class="stat-card">
        <div class="stat-card-glow" style="background: radial-gradient(circle, var(--success-glow) 0%, transparent 70%);"></div>
        <div class="stat-header">
            <span class="stat-title">Data Diterima</span>
            <div class="stat-icon-wrapper" style="color: var(--success)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                </svg>
            </div>
        </div>
        <div class="stat-value" id="stat-logs">{{ $logsCount }}</div>
        <div class="stat-meta">Entri Log Telemetri</div>
    </div>

    <!-- Total Pengguna -->
    <div class="stat-card">
        <div class="stat-card-glow" style="background: radial-gradient(circle, rgba(6, 182, 212, 0.15) 0%, transparent 70%);"></div>
        <div class="stat-header">
            <span class="stat-title">Total Pengguna</span>
            <div class="stat-icon-wrapper" style="color: var(--accent)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $userCount }}</div>
        <div class="stat-meta">Anggota Tim Terdaftar</div>
    </div>

</div>

<!-- SENSOR DATA & CONTROLS -->
<div class="dashboard-grid">
    
    <!-- Suhu Card -->
    <div class="stat-card" id="temp-card">
        <div class="stat-header">
            <span class="stat-title">Sensor Suhu</span>
            <div class="stat-icon-wrapper" style="color: #f97316; background-color: rgba(249, 115, 22, 0.1)">
                <!-- Thermometer Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.03V21m0-12.03a3 3 0 110-6 3 3 0 010 6z" />
                </svg>
            </div>
        </div>
        <div class="stat-value" id="suhu-val">-- °C</div>
        <div class="telemetry-progress">
            <div class="telemetry-progress-fill temp-fill" id="suhu-progress" style="width: 0%;"></div>
        </div>
        <div class="stat-meta" id="suhu-meta">Menerima telemetri...</div>
    </div>

    <!-- Kelembapan Card -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Kelembapan udara</span>
            <div class="stat-icon-wrapper" style="color: #3b82f6; background-color: rgba(59, 130, 246, 0.1)">
                <!-- Droplet Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
            </div>
        </div>
        <div class="stat-value" id="kelembapan-val">-- %</div>
        <div class="telemetry-progress">
            <div class="telemetry-progress-fill humidity-fill" id="kelembapan-progress" style="width: 0%;"></div>
        </div>
        <div class="stat-meta" id="kelembapan-meta">Menerima telemetri...</div>
    </div>

    <!-- Servo Control Widget -->
    <div class="stat-card widget-card">
        <div class="stat-header">
            <span class="stat-title">Aktuator Servo</span>
            <div class="stat-icon-wrapper" style="color: var(--primary); background-color: var(--primary-glow)">
                <!-- Adjustments Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0015 0m-15 0a7.5 7.5 0 1115 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077l1.41-.513m14.095-5.13l1.41-.513M5.106 17.785l1.15-.827m11.379-8.158l1.15-.827M8.14 21.27l.707-1.03m7.607-11.12l.707-1.03M12 3v1.5m0 15V21m-3.077-8.457l-.513-1.41m5.13 14.095l-.513-1.41M17.785 5.106l-.827 1.15m-8.158 11.379l-.827 1.15M21.27 8.14l-1.03.707m-11.12 7.607l-1.03.707" />
                </svg>
            </div>
        </div>
        <div class="widget-card-body">
            <!-- Servo Semicircular Gauge Visualization -->
            <div class="servo-gauge-wrapper">
                <svg viewBox="0 0 200 120" class="servo-gauge-svg">
                    <path d="M 20 100 A 80 80 0 0 1 180 100" fill="none" stroke="var(--bg-input)" stroke-width="8" stroke-linecap="round"/>
                    <path id="servo-gauge-track" d="M 20 100 A 80 80 0 0 1 180 100" fill="none" stroke="url(#servo-grad)" stroke-width="8" stroke-linecap="round" stroke-dasharray="251" stroke-dashoffset="125"/>
                    <g id="servo-pointer-group" transform="translate(100, 100) rotate(0)">
                        <line x1="0" y1="0" x2="0" y2="-75" stroke="var(--primary)" stroke-width="4" stroke-linecap="round" />
                        <circle cx="0" cy="0" r="10" fill="var(--bg-card)" stroke="var(--primary)" stroke-width="4"/>
                        <circle cx="0" cy="0" r="4" fill="var(--primary)" />
                    </g>
                    <defs>
                        <linearGradient id="servo-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="var(--accent)" />
                            <stop offset="100%" stop-color="var(--primary)" />
                        </linearGradient>
                    </defs>
                </svg>
                <div class="servo-gauge-value" id="servo-text">90°</div>
            </div>
            
            <div class="slider-container" style="padding: 0;">
                <input type="range" min="0" max="180" value="90" id="servo-slider" class="range-input">
            </div>
            <div style="font-size: 0.8rem; color: var(--text-muted); text-align: center;">Nilai dipublish saat slider dilepas.</div>
        </div>
    </div>

    <!-- LCD Control Widget -->
    <div class="stat-card widget-card">
        <div class="stat-header">
            <span class="stat-title">Layar LCD</span>
            <div class="stat-icon-wrapper" style="color: var(--accent); background-color: rgba(6, 182, 212, 0.1)">
                <!-- Monitor Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12v10.5a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15.25V5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25z" />
                </svg>
            </div>
        </div>
        <div class="widget-card-body">
            <!-- Physical Dot-Matrix Style Preview Screen -->
            <div class="lcd-preview-screen">
                <div class="lcd-preview-text" id="lcd-preview-screen-text">> <span id="lcd-preview-val">Ketik pesan...</span><span class="lcd-blink-cursor"></span></div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <div class="input-send-group">
                    <input type="text" id="lcd-input" placeholder="Ketik pesan..." class="form-control" maxlength="32">
                    <button id="lcd-btn" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- DETAILED PANELS: DEVICE STATUS & TIMELINE FEED -->
<div class="panel-row">
    
    <!-- Perangkat List -->
    <div class="panel-card">
        <div class="panel-header">
            <h3 class="panel-title">Status Perangkat</h3>
        </div>
        <div class="panel-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Serial Number</th>
                            <th>Prefix Topic</th>
                            <th>Status</th>
                            <th>Aktif Terakhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devices as $device)
                            <tr id="device-row-{{ $device->serial_number }}">
                                <td><strong>{{ $device->nama_device }}</strong></td>
                                <td><code>{{ $device->serial_number }}</code></td>
                                <td><code>{{ $device->topic_prefix }}</code></td>
                                <td>
                                    <span id="badge-{{ $device->serial_number }}" class="badge {{ $device->status === 'online' ? 'badge-online' : 'badge-offline' }}">
                                        <span class="badge-dot {{ $device->status === 'online' ? 'pulse' : '' }}"></span>
                                        <span class="status-text">{{ ucfirst($device->status) }}</span>
                                    </span>
                                </td>
                                <td class="last-seen-cell">
                                    {{ $device->last_seen ? $device->last_seen->diffForHumans() : 'Belum pernah terhubung' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: var(--spacing-xl);">
                                    Belum ada perangkat terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Live Activity Feed -->
    <div class="panel-card">
        <div class="panel-header">
            <h3 class="panel-title">Aktivitas Real-Time</h3>
            <span class="badge badge-online" style="font-size: 0.65rem;">Live</span>
        </div>
        <div class="panel-body">
            <div class="timeline-feed" id="timeline-feed">
                @forelse($recentLogs as $log)
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            @if($log->type === 'suhu')
                                🌡️
                            @elseif($log->type === 'kelembapan')
                                💧
                            @elseif($log->type === 'servo')
                                ⚙️
                            @elseif($log->type === 'lcd')
                                📺
                            @else
                                🔄
                            @endif
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-header-row">
                                <span class="timeline-type">{{ $log->type }}</span>
                                <span class="timeline-time">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="timeline-text">
                                Topic: <code>{{ $log->topic }}</code> | Nilai: <strong>{{ $log->value }}</strong>
                            </div>
                        </div>
                    </div>
                @empty
                    <div id="timeline-empty" style="text-align: center; color: var(--text-muted); padding: var(--spacing-lg);">
                        Belum ada aktivitas terekam.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // MQTT configuration
        const clientId = 'web_' + Math.random().toString(16).substr(2, 8);
        const host = 'wss://fakhrisensor.cloud.shiftr.io';
        
        const options = {
            clientId: clientId,
            username: 'fakhrisensor',
            password: 'fakhriganteng123',
            clean: true,
            connectTimeout: 4000,
            reconnectPeriod: 2000,
        };

        const client = mqtt.connect(host, options);

        const connectionStatusBadge = document.getElementById('mqtt-connection-status');
        const connectionStatusText = document.getElementById('mqtt-status-text');

        // Handle connection events
        client.on('connect', function () {
            console.log('MQTT Connected');
            
            // Update UI status
            connectionStatusBadge.className = 'badge badge-online';
            connectionStatusText.innerHTML = 'MQTT Terhubung';
            showToast('Koneksi MQTT', 'Koneksi ke broker Shiftr.io berhasil didirikan.', 'success');

            // Subscribe to fakhri topics
            client.subscribe('fakhri/#');
        });

        client.on('close', function() {
            console.log('MQTT Connection closed');
            connectionStatusBadge.className = 'badge badge-offline';
            connectionStatusText.innerHTML = 'MQTT Terputus';
        });

        client.on('error', function(err) {
            console.error('MQTT Connection error: ', err);
            showToast('Koneksi Gagal', 'Gagal terhubung ke broker MQTT.', 'danger');
        });

        // Handle incoming messages
        client.on('message', function (topic, payload) {
            const message = payload.toString();
            console.log('MQTT Msg Received:', topic, message);

            // 1. Update Real-time Cards UI
            updateRealtimeCard(topic, message);

            // 2. Save payload to Laravel database via secure AJAX bridge
            saveTelemetryToDatabase(topic, message);

            // 3. Update Device List rows in real-time
            updateDeviceListStatus(topic, message);

            // 4. Prepend to Live Activity Feed
            prependToActivityFeed(topic, message);
        });

        // Function to update real-time widget UI
        function updateRealtimeCard(topic, message) {
            // Temperature
            if (topic === 'fakhri/suhu') {
                const suhuVal = document.getElementById('suhu-val');
                if (suhuVal) {
                    suhuVal.innerHTML = message + ' °C';
                    
                    // Update progress bar
                    const suhuProgress = document.getElementById('suhu-progress');
                    if (suhuProgress) {
                        const tempNum = parseFloat(message) || 0;
                        const pct = Math.min(100, Math.max(0, (tempNum / 50) * 100));
                        suhuProgress.style.width = pct + '%';
                    }

                    // Alert color logic for high temperature (> 30)
                    const tempCard = document.getElementById('temp-card');
                    if (parseFloat(message) > 30) {
                        tempCard.style.borderColor = 'rgba(244, 63, 94, 0.4)';
                        tempCard.style.background = 'radial-gradient(circle at top right, rgba(244, 63, 94, 0.08), transparent), var(--bg-card)';
                    } else {
                        tempCard.style.borderColor = '';
                        tempCard.style.background = '';
                    }
                }
            }
            
            // Humidity
            if (topic === 'fakhri/kelembapan') {
                const humVal = document.getElementById('kelembapan-val');
                if (humVal) {
                    humVal.innerHTML = message + ' %';
                    
                    // Update progress bar
                    const humProgress = document.getElementById('kelembapan-progress');
                    if (humProgress) {
                        const humNum = parseFloat(message) || 0;
                        humProgress.style.width = Math.min(100, Math.max(0, humNum)) + '%';
                    }
                }
            }

            // LCD Text Input update
            if (topic === 'fakhri/lcd') {
                const lcdInput = document.getElementById('lcd-input');
                const lcdPreview = document.getElementById('lcd-preview-val');
                if (lcdInput && document.activeElement !== lcdInput) {
                    lcdInput.value = message;
                }
                if (lcdPreview) {
                    lcdPreview.textContent = message || 'Ketik pesan...';
                }
            }

            // Servo Slider position update
            if (topic === 'fakhri/servo') {
                const slider = document.getElementById('servo-slider');
                const text = document.getElementById('servo-text');
                const pointer = document.getElementById('servo-pointer-group');
                const track = document.getElementById('servo-gauge-track');
                
                const val = parseInt(message) || 0;
                if (slider) slider.value = val;
                if (text) text.innerHTML = val + '°';
                if (pointer) pointer.setAttribute('transform', `translate(100, 100) rotate(${val - 90})`);
                if (track) {
                    const dashoffset = 251 - (val / 180) * 251;
                    track.setAttribute('stroke-dashoffset', dashoffset);
                }
            }
        }

        // Function to update device listing online/offline
        function updateDeviceListStatus(topic, message) {
            // Pattern: fakhri/{serial_number}/status
            if (topic.endsWith('/status')) {
                const parts = topic.split('/');
                if (parts.length >= 3) {
                    const serial = parts[parts.length - 2];
                    const badge = document.getElementById(`badge-${serial}`);
                    const statusRow = document.getElementById(`device-row-${serial}`);
                    
                    if (badge) {
                        const dot = badge.querySelector('.badge-dot');
                        const text = badge.querySelector('.status-text');
                        
                        const isOnline = message.toLowerCase() === 'online';
                        
                        badge.className = `badge ${isOnline ? 'badge-online' : 'badge-offline'}`;
                        if (dot) dot.className = `badge-dot ${isOnline ? 'pulse' : ''}`;
                        if (text) text.innerHTML = isOnline ? 'Online' : 'Offline';
                        
                        // Update last seen text dynamically
                        if (statusRow) {
                            const lastSeenCell = statusRow.querySelector('.last-seen-cell');
                            if (lastSeenCell) {
                                lastSeenCell.innerHTML = 'Barusan saja';
                            }
                        }

                        // Trigger visual alert
                        showToast(`Status Perangkat`, `Perangkat ${serial} sekarang ${isOnline ? 'ONLINE' : 'OFFLINE'}`, isOnline ? 'success' : 'danger');
                    }
                }
            }
        }

        // Function to send telemetry log via AJAX to Laravel backend
        function saveTelemetryToDatabase(topic, value) {
            fetch('/api/sensor-logs', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    topic: topic,
                    value: value
                })
            })
            .then(res => {
                if (!res.ok) throw new Error('API return non-200');
                return res.json();
            })
            .then(data => {
                console.log('AJAX Telemetry Bridge Saved:', data);
                
                // Increment counters in UI
                const logsCounter = document.getElementById('stat-logs');
                if (logsCounter) {
                    const currentCount = parseInt(logsCounter.innerHTML) || 0;
                    logsCounter.innerHTML = currentCount + 1;
                }
            })
            .catch(err => {
                console.error('AJAX Telemetry Bridge Error:', err);
            });
        }

        // Function to prepend live events into activity timeline
        function prependToActivityFeed(topic, message) {
            const feed = document.getElementById('timeline-feed');
            const emptyPlaceholder = document.getElementById('timeline-empty');
            
            if (emptyPlaceholder) {
                emptyPlaceholder.remove();
            }

            // Determine icon and clean type name
            let type = 'unknown';
            let icon = '🔄';

            if (topic.endsWith('/suhu')) {
                type = 'suhu';
                icon = '🌡️';
            } else if (topic.endsWith('/kelembapan')) {
                type = 'kelembapan';
                icon = '💧';
            } else if (topic.endsWith('/servo')) {
                type = 'servo';
                icon = '⚙️';
            } else if (topic.endsWith('/lcd')) {
                type = 'lcd';
                icon = '📺';
            } else if (topic.endsWith('/status')) {
                type = 'status';
                icon = '📶';
            }

            const item = document.createElement('div');
            item.className = 'timeline-item';
            item.style.animation = 'fadeIn 0.3s ease-out';
            item.innerHTML = `
                <div class="timeline-icon">${icon}</div>
                <div class="timeline-content">
                    <div class="timeline-header-row">
                        <span class="timeline-type">${type}</span>
                        <span class="timeline-time">Barusan</span>
                    </div>
                    <div class="timeline-text">
                        Topic: <code>${topic}</code> | Nilai: <strong>${message}</strong>
                    </div>
                </div>
            `;

            // Insert at top of feed list
            feed.insertBefore(item, feed.firstChild);

            // Limit timeline to 15 items in UI to prevent bloating memory
            if (feed.children.length > 15) {
                feed.lastChild.remove();
            }
        }

        // --- Frontend Publish Actions ---

        // LCD Publish Action
        const lcdBtn = document.getElementById('lcd-btn');
        const lcdInput = document.getElementById('lcd-input');

        lcdBtn.addEventListener('click', function() {
            const val = lcdInput.value;
            if (val.trim() === '') {
                showToast('Kesalahan Input', 'Harap isi pesan LCD terlebih dahulu.', 'warning');
                return;
            }
            
            client.publish('fakhri/lcd', val, { qos: 1 });
            showToast('Mempublikasi LCD', `Pesan "${val}" terkirim ke MQTT.`, 'primary');
        });

        lcdInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                lcdBtn.click();
            }
        });

        // Update LCD preview locally when typing
        lcdInput.addEventListener('input', function() {
            const preview = document.getElementById('lcd-preview-val');
            if (preview) {
                preview.textContent = lcdInput.value || 'Ketik pesan...';
            }
        });

        // Servo Slider events
        const slider = document.getElementById('servo-slider');
        const sliderText = document.getElementById('servo-text');

        // Realtime text update and local gauge rotation
        slider.addEventListener('input', function() {
            const val = slider.value;
            sliderText.innerHTML = val + '°';
            
            const pointer = document.getElementById('servo-pointer-group');
            const track = document.getElementById('servo-gauge-track');
            if (pointer) pointer.setAttribute('transform', `translate(100, 100) rotate(${val - 90})`);
            if (track) {
                const dashoffset = 251 - (val / 180) * 251;
                track.setAttribute('stroke-dashoffset', dashoffset);
            }
        });

        // Publish to MQTT only when mouseup / sliding finished
        slider.addEventListener('change', function() {
            const val = slider.value;
            client.publish('fakhri/servo', val, { qos: 1, retain: true });
            showToast('Mempublikasi Servo', `Memutar servo ke sudut ${val}°.`, 'primary');
        });
        
    });
</script>
@endsection