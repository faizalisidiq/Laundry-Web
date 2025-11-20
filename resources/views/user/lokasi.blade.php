<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi | Berlian Laundry</title>

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

        nav a::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 16px;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #ffb535ff, #F89B29);
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        nav a:hover::after {
            width: calc(100% - 32px);
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px 140px;
            position: relative;
            z-index: 1;
        }

        .title {
            font-size: 30px;
            font-weight: 700;
            color: #000000ff;
            margin-bottom: 30px;
            text-align: center;
            animation: fadeInUp 0.8s ease-out 0.2s both;
            letter-spacing: -0.5px;
        }

        .map-container {
            width: 90%;
            max-width: 800px;
            height: 400px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.2);
            animation: fadeInUp 0.8s ease-out 0.4s both;
            margin-bottom: 30px;
        }

        .location-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .location-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(245, 168, 59, 0.2);
        }

        .location-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #F5A83B 0%, #ffcf56ff 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
        }

        .location-icon i {
            color: white;
            font-size: 24px;
        }

        .location-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #000000ff;
        }

        .location-address {
            font-size: 18px;
            line-height: 1.8;
            color: #333;
            margin-bottom: 25px;
            padding: 20px;
            background: rgba(245, 168, 59, 0.05);
            border-radius: 12px;
            border-left: 4px solid #F5A83B;
        }

        .opening-hours {
            background: linear-gradient(135deg, rgba(245, 168, 59, 0.15), rgba(255, 207, 86, 0.15));
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.1);
        }

        .opening-hours p {
            font-size: 18px;
            font-weight: 700;
            color: #000000ff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .opening-hours i {
            color: #F5A83B;
            font-size: 20px;
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
            padding: 25px;
            font-size: 13px;
            line-height: 1.9;
            z-index: 1;
            border-top: 3px solid rgba(255, 154, 86, 0.3);
            box-shadow: 0 -5px 30px rgba(0, 0, 0, 0.2);
        }

        footer a {
            color: #FF9A56;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 600;
        }

        footer a:hover {
            color: #FF6B35;
            text-decoration: underline;
        }

        
        @keyframes floatBubble {
    0% {
        transform: translateY(0) translateX(0) rotate(0deg) scale(1);
        opacity: 0;
    }
    5% {
        opacity: 0.7;
    }
    25% {
        transform: translateY(-25vh) translateX(30px) rotate(90deg) scale(1.1);
    }
    50% {
        transform: translateY(-50vh) translateX(-30px) rotate(180deg) scale(1);
    }
    75% {
        transform: translateY(-75vh) translateX(20px) rotate(270deg) scale(1.1);
    }
    95% {
        opacity: 0.5;
    }
    100% {
        transform: translateY(-110vh) translateX(-10px) rotate(360deg) scale(0.9);
        opacity: 0;
    }
}

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.05);
            }
        }

 

        @media (max-width: 768px) {
            header {
                padding: 15px 25px;
            }

            .header img {
                height: 55px;
            }

            nav {
                gap: 25px;
            }

            nav a {
                font-size: 15px;
            }

            .title {
                font-size: 28px;
                margin-bottom: 20px;
            }

            .map-container {
                height: 300px;
            }

            .location-card {
                padding: 25px;
            }

            .location-header h2 {
                font-size: 22px;
            }

            .location-address {
                font-size: 16px;
            }

            .opening-hours p {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .title {
                font-size: 24px;
            }

            .map-container {
                height: 250px;
            }

            .location-card {
                padding: 20px;
            }

            .location-header h2 {
                font-size: 20px;
            }

            .location-address {
                font-size: 15px;
            }

            .opening-hours p {
                font-size: 15px;
            }
        }
    </style>
    
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        <h1 class="title">Lokasi Toko</h1>
        
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3989.0649123456789!2d135.51195!3d-3.350644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zM8KwMjEnMDIuMyJTIDEzNcKwMzAnNTAuOSJF!5e0!3m2!1sid!2sid!4v1234567890" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        
        <div class="location-card">
            <div class="location-header">
                <div class="location-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h2>Berlian Laundry</h2>
            </div>
            
            <div class="location-address">
                <strong>JGX7+QM4</strong>, Jl. R.E. Martadinata, Nabarua,<br>
                Distrik Nabire, Kabupaten Nabire,<br>
                Papua Tengah 98817
            </div>
            
            <div class="opening-hours">
                <p><i class="fas fa-clock"></i> Buka setiap hari: 09.00 - 19.00 WIT</p>
            </div>
        </div>
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
</body>
</html>