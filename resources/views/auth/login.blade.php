<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FR-SIOT Platform</title>
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
            <h1 class="auth-title">Selamat Datang</h1>
            <p class="auth-subtitle">Masukkan email dan password Anda untuk masuk ke dashboard</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder="contoh: admin@iot.local" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="form-control"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="••••••••" 
                        required 
                        class="form-control"
                    >
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat Saya</label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}" class="auth-footer-link">Daftar sekarang</a>
            </div>
        </div>
    </div>
</body>
</html>