<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Perpustakaan Digital</title>

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

        .register-box {
            width: 400px;
            background: #cfc7cd;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .register-box h3 {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 12px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #eee;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #7a1d57;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
        }

        .btn:hover {
            background: #5e1443;
        }

        .login-link {
            margin-top: 15px;
            font-size: 13px;
        }

        .login-link a {
            color: blue;
            text-decoration: none;
        }

        .footer {
            height: 80px;
            background: #b56a9a;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    PERPUSTAKAAN DIGITAL
</div>

<div class="container">
    <div class="register-box">
        <h3>REGISTRASI</h3>

        {{-- tampilkan error validasi --}}
        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="input-group">
                <input type="text" name="name" placeholder="Nama Lengkap" required>
            </div>

            <div class="input-group">
                <input type="text" name="alamat" placeholder="Alamat" required>
            </div>


            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <button type="submit" class="btn">SIMPAN</button>

            <div class="login-link">
                <a href="/login">Kembali ke halaman Login!</a>
            </div>
        </form>
    </div>
</div>

<div class="footer"></div>

</body>
</html>