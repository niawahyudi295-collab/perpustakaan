<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Perpustakaan Digital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #F5F2EE, #E8DFD5);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: #2A2520;
            color: #F5F2EE;
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
            background: #F5F2EE;
            padding: 35px 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(42, 37, 32, 0.15);
            border-top: 4px solid #C8A850;
        }

        .register-box h3 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2A2520;
            letter-spacing: 1px;
        }

        .error {
            color: #967830;
            background: #f5e6cc;
            font-size: 13px;
            margin-bottom: 12px;
            text-align: left;
            padding: 10px;
            border-radius: 6px;
            border-left: 4px solid #967830;
        }

        .input-group {
            margin-bottom: 12px;
            text-align: left;
        }

        .input-group input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #C8A850;
            border-radius: 6px;
            background: #F5F2EE;
            outline: none;
            font-size: 14px;
            color: #2A2520;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-group input::placeholder {
            color: #504840;
        }

        .input-group input:focus {
            border-color: #967830;
            background: #FFF;
            box-shadow: 0 0 0 3px rgba(200, 168, 80, 0.1);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #C8A850, #967830);
            color: #F5F2EE;
            border: none;
            border-radius: 6px;
            margin-top: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .btn:hover { 
            background: linear-gradient(135deg, #967830, #7a5f26);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(180, 136, 80, 0.3);
        }

        .login-link {
            margin-top: 15px;
            font-size: 13px;
            color: #504840;
        }

        .login-link a { 
            color: #C8A850; 
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .login-link a:hover { 
            color: #967830;
            text-decoration: underline;
        }

        .footer {
            background: #504840;
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
