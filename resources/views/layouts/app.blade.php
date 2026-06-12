<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FR-SIOT Platform')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Assets -->
    @vite(['resources/css/app.css'])
    @yield('styles')
</head>
<body>
    <div class="app-wrapper">
        
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <h3>FR-SIOT</h3>
                    <span>PRO</span>
                </div>
            </div>
            
            <nav class="sidebar-menu">
                <div class="sidebar-label">Utama</div>
                
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ Route::is('dashboard') ? 'active' : '' }}">
                    <!-- Dashboard Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('sensor.history') }}" class="sidebar-item {{ Route::is('sensor.history') ? 'active' : '' }}">
                    <!-- History Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Data
                </a>

                <a href="{{ route('sensor.index') }}" class="sidebar-item {{ Route::is('sensor.index*') ? 'active' : '' }}">
                    <!-- Sensor CRUD Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Master Sensor
                </a>

                @if(Auth::check() && Auth::user()->isAdmin())
                    <div class="sidebar-label">Administrasi</div>
                    
                    <a href="{{ route('device.index') }}" class="sidebar-item {{ Route::is('device.index*') ? 'active' : '' }}">
                        <!-- Device Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3V7.5a3 3 0 013-3h13.5a3 3 0 013 3v3.75a3 3 0 01-3 3zm-.75 3h1.5m1.5 0h1.5m-4.5 0H3m18 0h-3.75M16.5 21h.008v.008h-.008V21zm.008-.008h-.008V21h.008v-.008zm-3 0h.008v.008h-.008V21zm.008-.008h-.008V21h.008v-.008z" />
                        </svg>
                        Kelola Perangkat
                    </a>
                    
                    <a href="{{ route('users.index') }}" class="sidebar-item {{ Route::is('users.index*') ? 'active' : '' }}">
                        <!-- Users Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        Kelola Pengguna
                    </a>

                @endif
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-profile-widget">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->name ?? 'User Guest' }}</span>
                        <span class="user-role">{{ Auth::user()->role ?? 'user' }}</span>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- MAIN CONTENT AREA -->
        <main class="main-layout">
            
            <!-- TOPBAR / HEADER -->
            <header class="topbar">
                <div class="breadcrumb-area">
                    <span class="breadcrumb-root">FR-SIOT</span>
                    <span class="breadcrumb-separator">/</span>
                    @yield('breadcrumb')
                </div>
                
                <div class="topbar-actions">
                    <!-- Theme Toggle -->
                    <button class="theme-toggle-btn" id="theme-toggle" title="Ubah Tema">
                        <!-- Sun Icon (shows in dark mode to switch to light) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="theme-icon-sun" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M4.22 4.22l1.62 1.62m12.32 12.32l1.62 1.62M3 12h2.25m13.5 0H21M5.84 18.16l1.62-1.62M16.5 5.84l1.62-1.62M8.25 12a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0z" />
                        </svg>
                        <!-- Moon Icon (shows in light mode to switch to dark) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="theme-icon-moon" style="width: 20px; height: 20px; display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>
                    </button>
                    
                    <!-- Logout - GET route to avoid 419 CSRF issue -->
                    <a href="{{ route('logout.get') }}" class="btn btn-logout" id="logout-btn" 
                       onclick="return confirm('Yakin ingin keluar?')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:17px;height:17px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Keluar
                    </a>
                </div>
            </header>
            
            <!-- MAIN CONTENT -->
            <div class="content-container">
                @yield('content')
            </div>
            
        </main>
        
    </div>
    
    <!-- TOAST NOTIFICATION CONTAINER -->
    <div class="toast-container" id="toast-container"></div>
    
    <!-- SYSTEM SCRIPTS -->
    <script>
        // --- Theme Manager ---
        const themeToggleBtn = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('theme-icon-sun');
        const moonIcon = document.getElementById('theme-icon-moon');
        
        // Get preferred or saved theme
        function getSavedTheme() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) return savedTheme;
            return 'light';
        }
        
        // Apply theme
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            
            if (theme === 'dark') {
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            } else {
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            }
        }
        
        // Toggle theme on click
        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            applyTheme(newTheme);
            showToast('Tema Diubah', `Berhasil mengganti ke mode ${newTheme === 'dark' ? 'Gelap' : 'Terang'}.`, 'success');
        });
        
        // Initial theme load
        applyTheme(getSavedTheme());
        
        // --- Global Toast Notification Helper ---
        function showToast(title, body, type = 'primary') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            
            toast.innerHTML = `
                <div>
                    <div class="toast-title">${title}</div>
                    <div class="toast-body">${body}</div>
                </div>
            `;
            
            container.appendChild(toast);
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                toast.style.animation = 'fadeIn 0.3s reverse ease-in';
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 4000);
        }

        // Show flash messages if set
        @if (session('success'))
            showToast('Berhasil', "{{ session('success') }}", 'success');
        @endif
        @if (session('error'))
            showToast('Kesalahan', "{{ session('error') }}", 'danger');
        @endif
    </script>
    @yield('scripts')
</body>
</html>