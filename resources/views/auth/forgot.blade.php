<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - FR-SIOT Platform</title>
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
            <h1 class="auth-title">Lupa Password?</h1>
            <p class="auth-subtitle">Masukkan alamat email Anda untuk menerima tautan pemulihan kata sandi</p>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('forgot.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder="contoh: user@iot.local" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="form-control"
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-block">Kirim Link Pemulihan</button>
            </form>

            <div class="auth-footer">
                Ingat password Anda? <a href="{{ route('login') }}" class="auth-footer-link">Kembali login</a>
            </div>
        </div>
    </div>
</body>
</html>
