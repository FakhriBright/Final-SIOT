<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - FR-SIOT Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="auth-body">
    <div class="auth-glow"></div>
    <div class="auth-container">
        <div class="auth-logo">
            <h2>FR-SIOT</h2>
            <span>IoT Monitoring & Control</span>
        </div>

        <div class="auth-card">
            <h1 class="auth-title">Buat Akun Baru</h1>
            <p class="auth-subtitle">Daftarkan diri Anda untuk mulai memonitor perangkat IoT Anda</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        placeholder="contoh: Fakhri Ganteng" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus
                        class="form-control"
                    >
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder="contoh: user@iot.local" 
                        value="{{ old('email') }}" 
                        required 
                        class="form-control"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password (Minimal 6 Karakter)</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="••••••••" 
                        required 
                        class="form-control"
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        placeholder="••••••••" 
                        required 
                        class="form-control"
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-block">Daftar Akun</button>
            </form>

            <div class="auth-footer">
                Sudah memiliki akun? <a href="{{ route('login') }}" class="auth-footer-link">Masuk disini</a>
            </div>
        </div>
    </div>
</body>
</html>
