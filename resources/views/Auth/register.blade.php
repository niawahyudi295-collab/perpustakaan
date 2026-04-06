<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Perpustakaan Digital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #d7b8c8;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: #b57ba6;
            color: white;
            padding: 22px;
            font-size: 26px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 2px;
        }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 0;
        }

        .register-box {
            width: 420px;
            background: #cfc7cd;
            padding: 35px 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .register-box h3 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #222;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 12px;
            text-align: left;
        }

        .input-group {
            margin-bottom: 12px;
            text-align: left;
        }

        .input-group input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #bbb;
            border-radius: 6px;
            background: #f5f0f3;
            outline: none;
            font-size: 14px;
            color: #333;
        }

        .input-group input:focus {
            border-color: #b57ba6;
            background: #fff;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #7a1d57;
            color: white;
            border: none;
            border-radius: 6px;
            margin-top: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .btn:hover { background: #5e1443; }

        .login-link {
            margin-top: 15px;
            font-size: 13px;
        }

        .login-link a { color: #3a3af5; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }

        .footer {
            background: #b57ba6;
            height: 60px;
        }
    </style>
</head>
<body>

<div class="header">PERPUSTAKAAN DIGITAL</div>

<div class="container">
    <div class="register-box">
        <h3>REGISTRASI</h3>

        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-group">
                <input type="text" name="username" placeholder="Username"
                       value="{{ old('username') }}" required>
            </div>

            <div class="input-group">
                <input type="text" name="name" placeholder="Nama Lengkap"
                       value="{{ old('name') }}" required>
            </div>

            <div class="input-group">
                <input type="email" name="email" placeholder="Email"
                       value="{{ old('email') }}" required>
            </div>

            <div class="input-group">
                <input type="text" name="phone_number" placeholder="No. Telepon"
                       value="{{ old('phone_number') }}" required>
            </div>

            <div class="input-group">
                <input type="text" name="alamat" placeholder="Alamat"
                       value="{{ old('alamat') }}" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="input-group">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
            </div>

            <button type="submit" class="btn">DAFTAR</button>

            <div class="login-link">
                <a href="{{ route('login') }}">Sudah punya akun? Login di sini</a>
            </div>
        </form>
    </div>
</div>

<div class="footer"></div>

</body>
</html>
