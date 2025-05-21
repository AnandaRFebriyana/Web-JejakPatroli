<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pemantauan Patroli Keamanan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background: linear-gradient(to bottom, #ffffff, #e6f7ff);
            color: #2d4654;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo img {
            height: 40px;
        }

        .logo span {
            font-size: 1.7rem;
            font-weight: 700;
            color: #2d4654;
            letter-spacing: 1px;
        }

        nav {
            display: flex;
            gap: 30px;
        }

        nav a {
            text-decoration: none;
            font-weight: 500;
            font-size: 18px;
            transition: color 0.3s;
        }

        nav a:first-child {
            color: #27a9e1;
        }

        nav a:not(:first-child) {
            color: #2d4654;
        }

        nav a:hover {
            color: #27a9e1;
        }

        .download-btn {
            background-color: #000;
            color: white;
            text-decoration: none;
            padding: 15px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .download-btn:hover {
            background-color: #333;
        }

        /* Hero section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px 0;
            min-height: 80vh;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 30px;
            background: linear-gradient(45deg, #2d4654, #27a9e1, #4169e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #5e6e7d;
            margin-bottom: 30px;
        }

        .get-started-btn {
            display: inline-flex;
            align-items: center;
            background-color: #0f0f0f;
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .get-started-btn svg {
            margin-left: 10px;
        }

        .get-started-btn:hover {
            background-color: #333;
            transform: translateY(-2px);
        }

        /* Hero image */
        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            position: relative;
        }

        .phone-mockup {
            max-width: 100%;
            height: auto;
            position: relative;
            z-index: 2;
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }

            .hero-content {
                margin-bottom: 50px;
            }

            .hero-title {
                font-size: 4rem;
            }
        }

        @media (max-width: 768px) {
            nav {
                display: none;
            }

            .hero-title {
                font-size: 4rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="{{ asset('assets/img/logo-jejakpatroli.png') }}" alt="Jejak Patroli Logo" style="height: 40px;">
                <span style="font-size: 1.7rem; font-weight: 700; color: #2d4654; letter-spacing: 1px;">Jejak Patroli</span>
            </div>

            <nav>
                <a href="/">Home</a>
                <a href="/aboutus">About Us</a>
            </nav>

            <a href="/login" class="download-btn">Masuk</a>
        </header>

        <main class="hero">
            <div class="hero-content">
                <h1 class="hero-title">Sistem Pemantauan Patroli Keamanan</h1>
                <p class="hero-description">
                    Sistem Inovatif Untuk Memantau Dan Merekam Pergerakan Petugas Keamanan Secara Real-Time. Dengan Fitur GPS Tracking, Aplikasi Ini Memungkinkan Pemilik Atau Pengelola Keamanan Untuk Mengetahui Rute Patroli, Area Yang Telah Dilalui, Serta Laporan Kondisi Di Lapangan Dengan Lebih Mudah Dan Akurat.
                </p>
                <a href="#" class="get-started-btn">
                    Get Started
                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 1L19 8L12 15M1 8H19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>

            <div class="hero-image">
                <img src="{{ asset('assets/img/ip.png') }}" alt="Jejak Patroli Mobile App Interface" class="phone-mockup">
            </div>
        </main>
    </div>
</body>
</html>
