<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Berlian Laundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #F5A83B 0%, #F5C16B 50%, #FFE8C5 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(255, 154, 86, 0.2) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .login-card {
            background: rgba(255,255,255,0.9);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(255, 154, 86, 0.25);
            width: 90%;
            max-width: 400px;
            padding: 2.5rem;
            text-align: center;
            position: relative;
            z-index: 2;
            animation: fadeInUp 0.8s ease-out;
        }

        .login-header img {
            width: 120px;
            margin-bottom: 10px;
            animation: pulseSoft 3s infinite alternate;
        }
        .login-header h3 {
            font-weight: 700;
            color: #ff9a35ff;
            font-size: 26px;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #555;
            font-size: 14px;
            margin-bottom: 25px;
        }
        .form-label {
            display: block;
            text-align: left;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 2px solid rgba(255,154,86,0.3);
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-control:focus {
            border-color: #ffab35ff;
            box-shadow: 0 0 0 4px rgba(255, 154, 86, 0.2);
        }

        .btn-login {
            background: linear-gradient(135deg, #F5A83B 0%, #ffcf56ff 100%);
            border: none;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            border-radius: 30px;
            padding: 14px;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 10px 25px rgba(255, 154, 86, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 154, 86, 0.4);
        }

        .alert {
            background: rgba(255, 71, 87, 0.1);
            border: 2px solid #ff4757;
            color: #ff4757;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .form-check {
            display: flex;
            align-items: center;
            justify-content: start;
            gap: 6px;
            margin-top: 10px;
            font-size: 14px;
        }

        .form-check input {
            accent-color: #ff9a35ff;
            transform: scale(1.1);
        }

        footer {
            margin-top: 40px;
            font-size: 12px;
            color: #444;
            text-align: center;
            z-index: 1;
        }

        .bubbles {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle at 40% 40%, 
                rgba(24, 186, 255, 0.5), 
                rgba(255, 189, 145, 0.3));
            opacity: 0.7;
            animation: floatBubble linear infinite;
            box-shadow: 
                inset 0 10px 20px rgba(255, 255, 255, 0.3),
                0 4px 15px rgba(52, 152, 219, 0.2);
        }

        .bubble::before {
            content: '';
            position: absolute;
            top: 10%;
            left: 15%;
            width: 40%;
            height: 40%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.6), transparent);
            border-radius: 50%;
        }

        .bubble:nth-child(1) {
            width: 90px;
            height: 90px;
            left: 8%;
            bottom: -100px;
            animation-duration: 12s;
            animation-delay: 0s;
            background: radial-gradient(circle at 30% 30%, rgba(52, 152, 219, 0.6), rgba(255, 154, 86, 0.4));
        }

        .bubble:nth-child(2) {
            width: 60px;
            height: 60px;
            left: 22%;
            bottom: -80px;
            animation-duration: 14s;
            animation-delay: 2s;
            background: radial-gradient(circle at 30% 30%, rgba(100, 181, 246, 0.5), rgba(255, 167, 38, 0.3));
        }

        .bubble:nth-child(3) {
            width: 45px;
            height: 45px;
            left: 42%;
            bottom: -60px;
            animation-duration: 10s;
            animation-delay: 4s;
        }

        .bubble:nth-child(4) {
            width: 75px;
            height: 75px;
            left: 58%;
            bottom: -90px;
            animation-duration: 13s;
            animation-delay: 1s;
            background: radial-gradient(circle at 30% 30%, rgba(66, 165, 245, 0.55), rgba(255, 183, 77, 0.35));
        }

        .bubble:nth-child(5) {
            width: 50px;
            height: 50px;
            left: 73%;
            bottom: -70px;
            animation-duration: 11s;
            animation-delay: 3s;
        }

        .bubble:nth-child(6) {
            width: 85px;
            height: 85px;
            left: 88%;
            bottom: -95px;
            animation-duration: 15s;
            animation-delay: 0.5s;
            background: radial-gradient(circle at 30% 30%, rgba(41, 128, 185, 0.6), rgba(255, 193, 7, 0.4));
        }

        .bubble:nth-child(7) {
            width: 55px;
            height: 55px;
            left: 12%;
            bottom: -75px;
            animation-duration: 12.5s;
            animation-delay: 2.5s;
        }

        .bubble:nth-child(8) {
            width: 65px;
            height: 65px;
            left: 35%;
            bottom: -85px;
            animation-duration: 13.5s;
            animation-delay: 1.8s;
            background: radial-gradient(circle at 30% 30%, rgba(30, 136, 229, 0.5), rgba(255, 160, 0, 0.35));
        }

        .bubble:nth-child(9) {
            width: 70px;
            height: 70px;
            left: 65%;
            bottom: -80px;
            animation-duration: 11.5s;
            animation-delay: 3.5s;
        }

        .bubble:nth-child(10) {
            width: 40px;
            height: 40px;
            left: 80%;
            bottom: -60px;
            animation-duration: 10.5s;
            animation-delay: 4.5s;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseSoft {
            0% { transform: scale(1); }
            100% { transform: scale(1.05); }
        }

        @keyframes floatBubble {
            0% { transform: translateY(0); opacity: 0; }
            10% { opacity: 0.7; }
            90% { opacity: 0.5; }
            100% { transform: translateY(-100vh); opacity: 0; }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('images/logo-berlian.png') }}" alt="Logo Berlian Laundry">
            <h3>Login Admin</h3>
            <p>Silakan login untuk melanjutkan</p>
        </div>

        @if(session('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif

        <form action="{{ route('authenticate') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Masukkan email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="alert mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Masukkan password" required>
                @error('password')
                    <div class="alert mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>

        <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <footer>© 2025 Berlian Laundry. Semua hak dilindungi.</footer>

</body>
</html>
