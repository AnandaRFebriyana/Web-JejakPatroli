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
            color: #2d4654;
        }

        nav a.active {
            color: #27a9e1;
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
                <span>Jejak Patroli</span>
            </div>

            <nav>
                <a href="/" class="">Home</a>
                <a href="/aboutus" class="active">About Us</a>
            </nav>

            <a href="/login" class="download-btn">Masuk</a>
        </header>

        <main class="hero">
            <div class="hero-content">
                <div class="logo">
                    <img src="{{ asset('assets/img/aetheris.png') }}" alt="Aetheris Technology" style="height: 80px;">
                    <h1>AETHERIS TECHNOLOGY</h1>
                </div>
                <br>
                <p class="hero-description">
                    Jl. Mastrip, Krajan Timur, Sumbersari, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121.
                </p>
                <p class="hero-description">
                    Nara hubung: (+62) 83115391209
                </p>
            </div>
        </main>
    </div>
</body>
</html>
