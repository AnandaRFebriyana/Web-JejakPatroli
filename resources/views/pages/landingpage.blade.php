<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jejak Patroli - Sistem Pemantauan Keamanan Modern</title>
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary: #27a9e1;
            --secondary: #2d4654;
            --light: #f8f9fa;
            --dark: #212529;
            --transition: all 0.3s ease;
        }

        body {
            background-color: #ffffff;
            color: var(--secondary);
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header styles */
        header {
            background-color: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        header.scrolled {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo img {
            height: 40px;
            transition: var(--transition);
        }

        .logo span {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
            transition: var(--transition);
        }

        nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            color: var(--secondary);
            transition: var(--transition);
            position: relative;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
        }

        nav a:hover::after {
            width: 100%;
        }

        .cta-button {
            background-color: var(--primary);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cta-button i {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39,169,225,0.3);
        }

        .cta-button:hover i {
            transform: translateX(5px);
        }

        .cta-button.outline {
            background: transparent;
            color: var(--secondary);
            border: 2px solid var(--primary);
        }

        .cta-button.outline:hover {
            background: var(--primary);
            color: white;
        }

        .hamburger {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0.5rem;
        }

        .hamburger span {
            display: block;
            width: 25px;
            height: 3px;
            background: var(--secondary);
            margin: 5px 0;
            transition: var(--transition);
        }

        /* Hero Section */
        .hero {
            padding: 8rem 0 5rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9f8ff 100%);
        }

        .hero-content {
            flex: 1;
            padding-right: 3rem;
            padding: 0 4rem;
            max-width: 650px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, var(--secondary), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #666;
            margin-bottom: 2rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
        }

        .hero-image {
            flex: 1;
            position: relative;
        }

        .hero-image img {
            max-width: 100%;
            animation: float 6s ease-in-out infinite;
        }

        /* Features Section */
        .features {
            padding: 5rem 0;
            background: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .section-title p {
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            border-radius: 10px;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        /* Stats Section */
        .stats {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        /* Testimonials Section */
        .testimonials {
            padding: 5rem 0;
            background: #f8f9fa;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .testimonial-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .testimonial-content {
            font-style: italic;
            margin-bottom: 1rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .testimonial-author img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Footer */
        footer {
            background: var(--secondary);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .footer-column h4 {
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 0.8rem;
        }

        .footer-column ul li a {
            color: #ddd;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-column ul li a:hover {
            color: var(--primary);
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            color: white;
            font-size: 1.5rem;
            transition: var(--transition);
        }

        .social-links a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 6rem;
            }

            .hero-content {
                padding-right: 0;
                margin-bottom: 3rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }

            nav {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 80px);
                background: white;
                flex-direction: column;
                align-items: center;
                padding: 2rem;
                transition: var(--transition);
            }

            nav.active {
                left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* About Us Section */
        .about-us {
            padding: 7rem 0;
            background-color: var(--light);
            position: relative;
            overflow: hidden;
        }

        .about-grid {
            max-width: 800px;
            margin: 0 auto;
        }

        .about-content {
            text-align: center;
        }

        .about-content h2 {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        .about-content h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        .company-info {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 3rem;
            transition: transform 0.3s ease;
        }

        .company-info:hover {
            transform: translateY(-5px);
        }

        .company-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .company-logo img {
            height: 100px;
            width: auto;
            object-fit: contain;
        }

        .company-logo h3 {
            color: var(--secondary);
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .company-details {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            text-align: left;
        }

        .contact-item i {
            color: var(--primary);
            font-size: 1.4rem;
            margin-top: 0.2rem;
            flex-shrink: 0;
        }

        .contact-item p {
            margin: 0;
            color: #666;
            line-height: 1.6;
            font-size: 1.1rem;
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }

        .about-feature-item {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            text-align: center;
        }

        .about-feature-item:hover {
            transform: translateY(-5px);
        }

        .about-feature-item i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
            padding: 1rem;
            background: rgba(39,169,225,0.1);
            border-radius: 50%;
            display: inline-block;
        }

        .about-feature-item h4 {
            color: var(--secondary);
            margin-bottom: 0.8rem;
            font-size: 1.2rem;
        }

        .about-feature-item p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
        }

        @media (max-width: 992px) {
            .about-features {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .about-features {
                grid-template-columns: 1fr;
            }

            .company-info {
                padding: 2rem;
            }

            .company-logo img {
                height: 80px;
            }

            .company-logo h3 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="/" class="logo">
                <img src="{{ asset('assets/img/logo-jejakpatroli.png') }}" alt="Jejak Patroli Logo">
                <span>Jejak Patroli</span>
            </a>

            <button class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav id="nav-menu">
                <a href="/">Beranda</a>
                <a href="#features">Fitur</a>
                <a href="#about">Tentang Kami</a>
                <a href="#testimonials">Testimoni</a>
                <a href="/login" class="cta-button">Masuk</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content" data-aos="fade-right">
                <h1 class="hero-title">Sistem Pemantauan Patroli Keamanan Modern</h1>
                <p class="hero-description">
                    Tingkatkan efektivitas dan akuntabilitas tim keamanan Anda dengan sistem pemantauan real-time yang 
                    mudah digunakan. Dilengkapi GPS tracking, pelaporan digital, dan analisis data yang komprehensif.
                </p>
                <div class="hero-buttons">
                    <a href="/register" class="cta-button">
                        Mulai Sekarang
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#features" class="cta-button outline">
                        Pelajari Lebih Lanjut
                        <i class="fas fa-info-circle"></i>
                    </a>
                </div>
            </div>
            <div class="hero-image" data-aos="fade-left">
                <img src="{{ asset('assets/img/ip.png') }}" alt="Jejak Patroli Mobile App Interface">
            </div>
        </section>

        <section class="features" id="features">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Fitur Unggulan</h2>
                    <p>Solusi lengkap untuk pemantauan dan manajemen keamanan yang efektif</p>
                </div>
                <div class="features-grid">
                    <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-map-marker-alt feature-icon"></i>
                        <h3>GPS Tracking</h3>
                        <p>Pantau lokasi petugas secara real-time dengan akurasi tinggi</p>
                    </div>
                    <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-clipboard-check feature-icon"></i>
                        <h3>Laporan Digital</h3>
                        <p>Dokumentasi patroli digital yang terstruktur dan mudah diakses</p>
                    </div>
                    <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h3>Analisis Data</h3>
                        <p>Visualisasi data dan laporan analitis untuk pengambilan keputusan</p>
                    </div>
                    <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                        <i class="fas fa-bell feature-icon"></i>
                        <h3>Notifikasi Real-time</h3>
                        <p>Dapatkan alert instan untuk setiap kejadian penting</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="testimonials" id="testimonials">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Testimoni Pengguna</h2>
                    <p>Apa kata pengguna tentang Jejak Patroli</p>
                </div>
                <div class="testimonials-grid">
                    <div class="testimonial-card" data-aos="fade-up">
                        <div class="testimonial-content">
                            "Jejak Patroli sangat membantu kami dalam memantau kinerja tim keamanan. Sistem yang user-friendly dan fitur yang lengkap."
                        </div>
                        <div class="testimonial-author">
                            <img src="https://ui-avatars.com/api/?name=Budi+Santoso" alt="Budi Santoso">
                            <div>
                                <h4>Budi Santoso</h4>
                                <p>Security Manager</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="testimonial-content">
                            "Dengan Jejak Patroli, pengawasan menjadi lebih efektif dan pelaporan lebih terstruktur."
                        </div>
                        <div class="testimonial-author">
                            <img src="https://ui-avatars.com/api/?name=Dewi+Putri" alt="Dewi Putri">
                            <div>
                                <h4>Dewi Putri</h4>
                                <p>Building Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-us" id="about">
            <div class="container">
                <div class="about-grid">
                    <div class="about-content" data-aos="fade-up">
                        <h2>Tentang Kami</h2>
                        <div class="company-info" data-aos="fade-up" data-aos-delay="100">
                            <div class="company-logo">
                                <img src="{{ asset('assets/img/aetheris.png') }}" alt="Aetheris Technology">
                                <h3>AETHERIS TECHNOLOGY</h3>
                            </div>
                            <div class="company-details">
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p>Jl. Mastrip, Krajan Timur, Sumbersari, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121</p>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <p>(+62) 83115391209</p>
                                </div>
                            </div>
                        </div>
                        <div class="about-features">
                            <div class="about-feature-item" data-aos="fade-up" data-aos-delay="200">
                                <i class="fas fa-shield-alt"></i>
                                <div>
                                    <h4>Keamanan Terpercaya</h4>
                                    <p>Sistem pemantauan keamanan yang handal dan terpercaya</p>
                                </div>
                            </div>
                            <div class="about-feature-item" data-aos="fade-up" data-aos-delay="300">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <h4>Pemantauan Real-time</h4>
                                    <p>Monitoring aktivitas keamanan secara real-time</p>
                                </div>
                            </div>
                            <div class="about-feature-item" data-aos="fade-up" data-aos-delay="400">
                                <i class="fas fa-chart-line"></i>
                                <div>
                                    <h4>Analisis Mendalam</h4>
                                    <p>Analisis data keamanan yang komprehensif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h4>Jejak Patroli</h4>
                    <p>Sistem pemantauan keamanan modern untuk efektivitas dan akuntabilitas yang lebih baik.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h4>Tautan</h4>
                    <ul>
                        <li><a href="/">Beranda</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#testimonials">Testimoni</a></li>
                        <li><a href="/aboutus">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Kontak</h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> +62 123 4567 890</li>
                        <li><i class="fas fa-envelope"></i> info@jejakpatroli.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Jejak Patroli. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Mobile menu toggle
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('nav-menu');

        hamburger.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            hamburger.classList.toggle('active');
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
