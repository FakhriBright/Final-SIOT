<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dashboard</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(
                135deg,
                #050816,
                #0f172a,
                #111827
            );
        }

        .login-container{
            width: 400px;
            background: rgba(17, 24, 39, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0,0,0,0.4);
            color: white;
        }

        .title{
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle{
            color: #9ca3af;
            margin-bottom: 30px;
        }

        .form-group{
            margin-bottom: 20px;
        }

        .form-group label{
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .form-input{
            width: 100%;
            padding: 14px;
            border: none;
            outline: none;
            border-radius: 10px;
            background: #1f2937;
            color: white;
        }

        .form-input:focus{
            border: 1px solid #4f46e5;
        }

        .btn-login{
            width: 100%;
            padding: 14px;
            background: #4f46e5;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover{
            background: #4338ca;
        }

        .error{
            background: #7f1d1d;
            color: #fecaca;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .demo{
            margin-top: 20px;
            font-size: 13px;
            color: #9ca3af;
            text-align: center;
        }

    </style>

</head>
<body>

    <div class="login-container">

        <div class="title">
            Login Dashboard
        </div>

        <div class="subtitle">
            IoT Monitoring System
        </div>

        @if(session('error'))

            <div class="error">
                {{ session('error') }}
            </div>

        @endif

        <form action="/login" method="POST">

            @csrf

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-input"
                    placeholder="Masukkan email"
                    required
                >

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    class="form-input"
                    placeholder="Masukkan password"
                    required
                >

            </div>

            <button type="submit" class="btn-login">
                Login
            </button>

        </form>

        <div class="demo">
            admin@gmail.com | 123456
        </div>

    </div>

</body>
</html>