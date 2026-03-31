<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Perpustakaan Digital</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #d7b8c8;
        }

        .header {
            background: #b56a9a;
            color: white;
            padding: 20px;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        .login-box {
            width: 350px;
            background: #cfc7cd;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .login-box h3 {
            margin-bottom: 20px;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            background: #eee;
            border-radius: 5px;
            padding: 10px;
        }

        .input-group input {
            border: none;
            outline: none;
            background: none;
            width: 100%;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #7a1d57;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }

        .btn:hover {
            background: #5e1443;
        }

        .register {
            margin-top: 10px;
            font-size: 12px;
        }

        .register a {
            color: blue;
            text-decoration: none;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .footer {
            height: 80px;
            background: #b56a9a;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="header">
    PERPUSTAKAAN DIGITAL
</div>

<div class="container">
    <div class="login-box">
        <h3>LOGIN</h3>

        {{-- tampilkan error --}}
        @if(session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="input-group">
                👤
                <input type="text" name="username" placeholder="username" required>
            </div>

            <div class="input-group">
                🔒
                <input type="password" name="password" placeholder="password" required>
            </div>

            <button type="submit" class="btn">LOGIN</button>

            <div class="register">
                Belum memiliki akun?<br>
                <a href="/register">DAFTAR SEKARANG</a>
            </div>
        </form>
    </div>
</div>

<div class="footer"></div>

</body>
</html>