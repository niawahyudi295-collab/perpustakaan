<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">>Login - System Perpustakaan</title>

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #F5F2EE, #E8DFD5);
        }

        .header {
            background: #2A2520;
            color: #F5F2EE;
            padding: 20px;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 2px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        .login-box {
            width: 350px;
            background: #F5F2EE;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(42, 37, 32, 0.15);
            border-top: 4px solid #C8A850;
        }

        .login-box h3 {
            margin-bottom: 20px;
            color: #2A2520;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            background: #E8DFD5;
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #C8A850;
        }

        .input-group input {
            border: none;
            outline: none;
            background: none;
            width: 100%;
            padding-left: 8px;
            color: #2A2520;
        }

        .input-group input::placeholder {
            color: #504840;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #C8A850, #967830);
            color: #F5F2EE;
            border: none;
            border-radius: 8px;
            margin-top: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
            font-size: 15px;
            letter-spacing: 1px;
        }

        .btn:hover {
            transform: scale(1.02);
            background: linear-gradient(135deg, #967830, #7a5f26);
            box-shadow: 0 5px 15px rgba(180, 136, 80, 0.3);
        }

        .register {
            margin-top: 15px;
            font-size: 13px;
            color: #504840;
        }

        .register a {
            color: #C8A850;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .register a:hover {
            color: #967830;
            text-decoration: underline;
        }

        .error {
            color: #967830;
            background: #f5e6cc;
            font-size: 13px;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 6px;
            border-left: 4px solid #967830;
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

        @if(session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="input-group">
                👤
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                🔒
                <input type="password" name="password" placeholder="Password" required>
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