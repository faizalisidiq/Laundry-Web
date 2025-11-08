<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Dashboard | Berlian Laundry</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">

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

        .logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 25px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
            z-index: 9999;
            text-decoration: none;
            display: inline-block;
        }

        .logout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(255, 107, 107, 0.4);
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 80px 20px 40px;
            position: relative;
            z-index: 1;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            padding: 35px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(255, 107, 53, 0.25);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.5);
            animation: slideUp 0.6s ease-out;
        }

        .header-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid rgba(245, 168, 59, 0.2);
        }

        .header-logo img {
            height: 60px;
            width: auto;
            filter: drop-shadow(0 4px 8px rgba(255, 107, 53, 0.2));
        }

        .header-logo h1 {
            font-size: 22px;
            font-weight: 800;
            color: #2C2C2C;
            letter-spacing: 0.5px;
        }

        .order-info {
            background: rgba(245, 168, 59, 0.08);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 14px;
            font-weight: 600;
            color: #2C2C2C;
        }

        .info-value {
            font-size: 14px;
            font-weight: 700;
            color: #F5A83B;
            text-align: right;
        }

        .status-section {
            margin-bottom: 30px;
        }

        .status-title {
            font-size: 18px;
            font-weight: 800;
            color: #2C2C2C;
            margin-bottom: 25px;
            text-align: center;
        }

        .status-timeline {
            position: relative;
            padding-left: 50px;
        }

        .status-item {
            position: relative;
            margin-bottom: 35px;
            animation: fadeInLeft 0.6s ease-out both;
        }

        .status-item:nth-child(1) { animation-delay: 0.2s; }
        .status-item:nth-child(2) { animation-delay: 0.4s; }
        .status-item:nth-child(3) { animation-delay: 0.6s; }
        .status-item:nth-child(4) { animation-delay: 0.8s; }

        .status-item:last-child {
            margin-bottom: 0;
        }

        .status-item::before {
            content: '';
            position: absolute;
            left: -35px;
            top: 35px;
            width: 2px;
            height: calc(100% + 10px);
            background: linear-gradient(180deg, rgba(245, 168, 59, 0.3) 0%, transparent 100%);
        }

        .status-item:last-child::before {
            display: none;
        }

        .status-icon {
            position: absolute;
            left: -50px;
            top: 0;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s;
        }

        .status-icon.completed {
            background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 100%);
            color: white;
        }

        .status-icon.in-progress {
            background: linear-gradient(135deg, #F5A83B 0%, #FFB74D 100%);
            color: white;
            animation: pulse 2s infinite;
        }

        .status-icon.pending {
            background: #E0E0E0;
            color: #9E9E9E;
        }

        .status-content {
            background: white;
            padding: 18px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
        }

        .status-content:hover {
            transform: translateX(5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .status-name {
            font-size: 16px;
            font-weight: 700;
            color: #2C2C2C;
            margin-bottom: 5px;
        }

        .status-desc {
            font-size: 13px;
            color: #666;
            margin-bottom: 4px;
            line-height: 1.5;
        }

        .status-time {
            font-size: 12px;
            color: #999;
            font-weight: 600;
        }

        .contact-section {
            text-align: center;
            padding: 20px;
            background: rgba(245, 168, 59, 0.08);
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .contact-label {
            font-size: 14px;
            font-weight: 600;
            color: #2C2C2C;
            margin-bottom: 8px;
        }

        .contact-value {
            font-size: 16px;
            font-weight: 700;
            color: #F5A83B;
        }

        .location-btn {
            width: 100%;
            background: linear-gradient(135deg, #F5A83B 0%, #FFB74D 100%);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(245, 168, 59, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .location-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(245, 168, 59, 0.4);
        }

        .location-btn i {
            font-size: 20px;
        }

        footer {
            background: linear-gradient(135deg, #2C2C2C 0%, #1A1A1A 100%);
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            line-height: 1.7;
            z-index: 1;
            border-top: 3px solid rgba(255, 154, 86, 0.3);
        }

        footer a {
            color: #FF9A56;
            text-decoration: none;
            font-weight: 600;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 6px 20px rgba(245, 168, 59, 0.4);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 60px 15px 30px;
            }

            .dashboard-card {
                padding: 25px;
            }

            .header-logo img {
                height: 50px;
            }

            .header-logo h1 {
                font-size: 18px;
            }

            .logout-btn {
                top: 15px;
                right: 15px;
                padding: 10px 22px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-card {
                padding: 20px;
            }

            .order-info {
                padding: 18px;
            }

            .info-label, .info-value {
                font-size: 13px;
            }

            .status-timeline {
                padding-left: 45px;
            }

            .status-icon {
                width: 40px;
                height: 40px;
                left: -45px;
                font-size: 18px;
            }

            .status-name {
                font-size: 15px;
            }

            .status-desc {
                font-size: 12px;
            }
        }
    </style>
    
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <a href="{{ route('user.tracking') }}" class="logout-btn">Logout</a>

    <div class="container">
        <div class="dashboard-card">
            <div class="header-logo">
                <img src="{{ asset('images/logo-berlian.png') }}" alt="Berlian Laundry">
                <h1>Berlian Laundry</h1>
            </div>

            <div class="order-info">
                <div class="info-row">
                    <span class="info-label">No. Resi</span>
                    <span class="info-value">{{ $resi }}</span> <!-- INI AKAN MENAMPILKAN RESI DYNAMIC -->
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Masuk</span>
                    <span class="info-value">23 Oktober 2025</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis Layanan</span>
                    <span class="info-value">Reguler</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Berat</span>
                    <span class="info-value">5 Kg</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Biaya</span>
                    <span class="info-value">Rp 35.000</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Estimasi Selesai</span>
                    <span class="info-value">25 Oktober 2025</span>
                </div>
            </div>

            <div class="status-section">
                <h2 class="status-title">Status Pesanan</h2>
                
                <div class="status-timeline">
                    <div class="status-item">
                        <div class="status-icon completed">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="status-content">
                            <div class="status-name">Menunggu</div>
                            <div class="status-desc">Pesanan telah kami terima</div>
                            <div class="status-time">23 Okt 2025, 09:30 WIT</div>
                        </div>
                    </div>

                    <div class="status-item">
                        <div class="status-icon in-progress">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="status-content">
                            <div class="status-name">Diproses Pencucian</div>
                            <div class="status-desc">Pakaian Sedang Di Proses</div>
                            <div class="status-time">23 Okt 2025, 14:30 WIT</div>
                        </div>
                    </div>

                    <div class="status-item">
                        <div class="status-icon pending">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="status-content">
                            <div class="status-name">Selesai</div>
                            <div class="status-desc">Menunggu proses sebelumnya</div>
                            <div class="status-time">-</div>
                        </div>
                    </div>

                    <div class="status-item">
                        <div class="status-icon pending">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="status-content">
                            <div class="status-name">Diambil</div>
                            <div class="status-desc">Pesanan siap diambil/diantar</div>
                            <div class="status-time">-</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-section">
                <div class="contact-label">Contact Kami</div>
                <div class="contact-value">+62 81343 047741</div>
            </div>
        </div>
    </div>

    <footer>
        © 2025 Berlian Laundry. Semua hak dilindungi.<br>
        Hubungi kami: +62 xxx-xxxx-xxxx | <a href="mailto:berlian@laundry.com">BerlianLaundry.com</a>
    </footer>

    <script>
        // Auto-scroll ke status yang sedang berlangsung
        document.addEventListener('DOMContentLoaded', function() {
            const activeStatus = document.querySelector('.status-icon.in-progress');
            if (activeStatus) {
                setTimeout(() => {
                    activeStatus.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 500);
            }
        });
    </script>
</body>
</html>