<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking | Berlian Laundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #F5A83B 0%, #F5C16B 50%, #FFE8C5 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            padding-top: 80px;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255, 154, 86, 0.2) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(250, 208, 146, 0.95);
            padding: 3px 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            backdrop-filter: blur(15px);
            animation: slideDown 0.8s ease-out;
            box-shadow: 0 8px 32px rgba(255, 107, 53, 0.15);
            z-index: 9999;
            border-bottom: 3px solid rgba(255, 154, 86, 0.3);
        }

        .header img {
            height: 100px;
            padding: 5px 10px;
            width: auto;
            animation: pulse 2s infinite alternate;
            filter: drop-shadow(0 4px 8px rgba(255, 107, 53, 0.3));
        }

        nav {
            display: flex;
            gap: 25px;
            margin-right: 20px;
        }

        nav a {
            color: #ff9a35ff;
            text-decoration: none;
            font-weight: 600;
            font-size: 17px;
            transition: all 0.3s;
            position: relative;
            padding: 8px 1px;
            border-radius: 25px;
        }

        nav a:hover {
            color: #ff8400ff;
            background: rgba(255, 154, 86, 0.1);
            transform: translateY(-2px);
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px 140px;
            position: relative;
            z-index: 1;
        }

        .title {
            font-size: 30px;
            font-weight: 700;
            color: #000000ff;
            margin-bottom: 20px;
            text-align: center;
            animation: fadeInUp 0.8s ease-out 0.2s both;
            letter-spacing: -0.5px;
        }

        .logo-circle-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .circle-bg {
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f7b100ff 0%, #fcd395ff 0%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 20px 60px rgba(255, 107, 53, 0.3),
                0 0 0 15px rgba(255, 255, 255, 0.1),
                inset 0 -20px 40px rgba(255, 154, 86, 0.1);
            transition: all 0.4s ease;
        }

        .logomain {
            width: 190px;
            height: auto;
            position: relative;
            z-index: 5;
            animation: pulseSoft 3s infinite alternate;
            filter: drop-shadow(0 8px 16px rgba(255, 107, 53, 0.2));
        }

        .tracking-info {
            text-align: center;
            margin-bottom: 5px;
            animation: fadeInUp 0.8s ease-out 0.6s both;
            padding: 10px 4px;
            backdrop-filter: blur(1px);
        }

        .tracking-info h3 {
            font-size: 22px;
            font-weight: 700;
            color: #000000ff;
            margin-bottom: 5px;
            text-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
        }

        .tracking-info p {
            font-size: 14px;
            color: rgba(255, 27, 27, 0.95);
            line-height: 1.7;
            font-weight: 400;
        }

        .input-resi {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 35px;
            animation: fadeInUp 0.8s ease-out 0.8s both;
        }

        .input-resi input {
            width: 65px;
            height: 65px;
            text-align: center;
            border: 3px solid rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            font-size: 28px;
            font-weight: 700;
            color: #ffab35ff;
            background: rgba(255, 255, 255, 0.95);
            outline: none;
            transition: all 0.3s;
            animation: popIn 0.5s ease-out both;
            box-shadow: 0 8px 24px rgba(255, 107, 53, 0.15);
        }

        .input-resi input:focus {
            border-color: #ffcd35ff;
            background: white;
            box-shadow: 
                0 0 0 4px rgba(255, 107, 53, 0.2),
                0 12px 32px rgba(255, 107, 53, 0.25);
            transform: scale(1.08);
        }

        .input-resi input.error {
            border-color: #ff4757;
            background: rgba(255, 71, 87, 0.1);
            animation: shake 0.5s ease-in-out;
        }

        .btn-masuk {
            background: linear-gradient(135deg, #F5A83B 0%, #ffcf56ff 100%);
            color: white;
            border: none;
            padding: 16px 90px;
            border-radius: 35px;
            font-size: 19px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 
                0 10px 30px rgba(255, 107, 53, 0.4),
                0 0 0 4px rgba(255, 255, 255, 0.2);
            animation: fadeInUp 0.8s ease-out 1s both;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-masuk:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 
                0 15px 40px rgba(255, 107, 53, 0.5),
                0 0 0 6px rgba(255, 255, 255, 0.25);
        }

        .btn-masuk:disabled {
            background: linear-gradient(135deg, #cccccc 0%, #999999 100%);
            cursor: not-allowed;
            transform: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .error-message {
            color: #ff4757;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
            text-align: center;
            animation: fadeIn 0.3s ease;
            display: none;
            background: rgba(255, 71, 87, 0.1);
            padding: 10px 20px;
            border-radius: 10px;
            border: 2px solid #ff4757;
        }

        .error-message.show {
            display: block;
        }

        .success-message {
            color: #ff4757;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
            text-align: center;
            animation: fadeIn 0.3s ease;
            background: rgba(255, 71, 87, 0.1);
            padding: 10px 20px;
            border-radius: 10px;
            border: 2px solid #ff4757;
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


        footer {
            background: linear-gradient(135deg, #2C2C2C 0%, #1A1A1A 100%);
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            line-height: 1.9;
            z-index: 1;
            border-top: 3px solid rgba(255, 154, 86, 0.3);
            box-shadow: 0 -5px 30px rgba(0, 0, 0, 0.2);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.05); }
        }

        @keyframes pulseSoft {
            0% { transform: scale(1); }
            100% { transform: scale(1.03); }
        }

        @keyframes popIn {
            0% { opacity: 0; transform: scale(0.5); }
            70% { transform: scale(1.1); }
            100% { opacity: 1; transform: scale(1); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .title { font-size: 24px; }
            .circle-bg { width: 200px; height: 200px; }
            .input-resi input { width: 50px; height: 50px; font-size: 22px; }
            .btn-masuk { padding: 12px 60px; font-size: 16px; }
        }
    </style>
</head>

<body>
    <header class="header">
        <img src="{{ asset('images/logo-berlian.png') }}" alt="Berlian Laundry Logo">
        <nav>
            <a href="{{ url('/') }}">Tracking</a>
            <a href="{{ url('/lokasi') }}">Lokasi</a>
            <a href="{{ url('/login') }}">Admin</a>
        </nav>
    </header>

    <div class="container">
        <h1 class="title">Tracking Pesanan Anda</h1>
        
        <div class="logo-circle-wrapper">
            <div class="circle-bg">
                <img src="{{ asset('images/logo-berlian.png') }}" alt="Berlian Laundry Logo" class="logomain">
            </div>
        </div>

        <div class="tracking-info">
            <h3>Masukkan Nomor Resi</h3>
            <p>Kami Sudah Memberi Nomor Resi Di Summary WhatsApp<br>Yang sudah kami kirim</p>
        </div>

        <!-- Error dari Server -->
        @if(session('error'))
        <div class="success-message">
            {{ session('error') }}
        </div>
        @endif

        <!-- Error Client Side -->
        <div class="error-message" id="errorMessage">
            Harap isi semua digit nomor resi!
        </div>

        <div class="input-resi">
            <input type="text" maxlength="1" id="digit1" inputmode="numeric" pattern="[0-9]">
            <input type="text" maxlength="1" id="digit2" inputmode="numeric" pattern="[0-9]">
            <input type="text" maxlength="1" id="digit3" inputmode="numeric" pattern="[0-9]">
            <input type="text" maxlength="1" id="digit4" inputmode="numeric" pattern="[0-9]">
        </div>

        <button class="btn-masuk" id="trackingBtn" disabled>Masuk</button>
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

    <footer>
        © 2025 Berlian Laundry. Semua hak dilindungi.
    </footer>

    <script>
        const inputs = document.querySelectorAll('.input-resi input');
        const trackingBtn = document.getElementById('trackingBtn');
        const errorMessage = document.getElementById('errorMessage');

        function validateInputs() {
            let allFilled = true;
            let resi = '';
            
            inputs.forEach(input => {
                if (input.value.length === 0) {
                    allFilled = false;
                }
                resi += input.value;
            });

            const isNumeric = /^\d+$/.test(resi);
            trackingBtn.disabled = !(allFilled && isNumeric);

            if (allFilled && isNumeric) {
                hideError();
            }

            return allFilled && isNumeric;
        }

        function showError() {
            errorMessage.classList.add('show');
            inputs.forEach(input => {
                if (input.value.length === 0) {
                    input.classList.add('error');
                }
            });
        }

        function hideError() {
            errorMessage.classList.remove('show');
            inputs.forEach(input => {
                input.classList.remove('error');
            });
        }

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                validateInputs();

                if (e.target.value.length > 0) {
                    input.classList.add('filled');
                    input.classList.remove('error');
                } else {
                    input.classList.remove('filled');
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
                
                if (e.key === 'Enter' && index === inputs.length - 1) {
                    trackResi();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');

                if (pasteData.length === 4) {
                    inputs.forEach((input, idx) => {
                        if (idx < pasteData.length) {
                            input.value = pasteData[idx];
                            input.classList.add('filled');
                            input.classList.remove('error');
                        }
                    });
                    validateInputs();
                }
            });
        });

        function trackResi() {
            if (!validateInputs()) {
                showError();
                return;
            }

            let resi = '';
            inputs.forEach(input => resi += input.value);

            if (resi.length === 4 && /^\d+$/.test(resi)) {
                // FIXED: Gunakan route Laravel yang benar
                window.location.href = "{{ url('/tracking') }}/" + resi;
            } else {
                showError();
            }
        }

        trackingBtn.addEventListener('click', trackResi);

        window.addEventListener('load', () => {
            inputs[0].focus();
        });

        inputs.forEach(input => {
            input.addEventListener('blur', validateInputs);
        });
    </script>
</body>
</html>