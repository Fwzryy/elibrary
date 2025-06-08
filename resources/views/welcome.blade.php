<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Elibrary</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="antialiased">

    <div class="min-h-screen flex flex-col">
        <nav class="navbar">
            <a href="#" class="navbar-brand">Elibrary.</a>
            <div class="navbar-links">
                <a href="{{ route('welcome') }}">Beranda</a>
                <a href="{{ route('listbuku.page') }}">Koleksi Buku</a>
                <a href="{{ route('paket.langganan') }}">Paket Langganan</a>
                <a href="{{ route('tentang.kami') }}">Tentang Kami</a>
                <a href="{{ route('filament.admin.auth.login') }}" class="hero-button-secondary">Masuk / Daftar</a>
            </div>
        </nav>

        <main class="hero-section">
            <div class="container">
                <div class="hero-content-grid">
                    <div class="hero-text-left">
                        <h1 class="hero-title">
                            Baca di Mana Saja, Kapan Saja — Mulai Petualanganmu Sekarang
                        </h1>
                        <p class="hero-description">
                            Temukan dan baca buku-buku terbaik dari penulis favoritmu. Dengan langganan aktif, kamu dapat menikmati akses penuh ke semua koleksi premium kapan saja kamu mau!
                        </p>
                        <div class="hero-buttons">
                            <a href="#" class="hero-button-secondary">
                                Baca Sekarang?
                            </a>
                            <a href="#" class="hero-button-primary">
                                Ayo Mulai Membaca
                                <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="book-covers">
                      <div class="book-cover-container">
                        <img src="{{ asset('images/cover-buku-3.jpeg')}}" alt="Simple & Minimalist Book Cover" class="book-cover book-cover-1">
                      </div>
                      <div class="book-cover-container">
                        <img src="{{ asset('images/cover-buku6.jpeg')}}" alt="Designed For Work Book Cover" class="book-cover book-cover-2">
                      </div>
                      <div class="book-cover-container">
                        <img src="{{ asset('images/cover-buku5.jpeg')}}" alt="Customize Your Autumn Clothes Book Cover" class="book-cover book-cover-3">
                      </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
        <div class="svg-wave-container">
            <svg class="svg-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#FFFFFF" fill-opacity="1" d="M0,224L18.5,192C36.9,160,74,96,111,85.3C147.7,75,185,117,222,154.7C258.5,192,295,224,332,245.3C369.2,267,406,277,443,245.3C480,213,517,139,554,122.7C590.8,107,628,149,665,154.7C701.5,160,738,128,775,138.7C812.3,149,849,203,886,202.7C923.1,203,960,149,997,154.7C1033.8,160,1071,224,1108,250.7C1144.6,277,1182,267,1218,224C1255.4,181,1292,107,1329,101.3C1366.2,96,1403,160,1422,192L1440,224L1440,320L1421.5,320C1403.1,320,1366,320,1329,320C1292.3,320,1255,320,1218,320C1181.5,320,1145,320,1108,320C1070.8,320,1034,320,997,320C960,320,923,320,886,320C849.2,320,812,320,775,320C738.5,320,702,320,665,320C627.7,320,591,320,554,320C516.9,320,480,320,443,320C406.2,320,369,320,332,320C295.4,320,258,320,222,320C184.6,320,148,320,111,320C73.8,320,37,320,18,320L0,320Z"></path>
            </svg>
        </div>
        <section class="features-section">
            <div class="container">
                <h2 class="section-title">🤔Mengapa Memilih Elibrary? </h2>
                <div class="features-grid">
                    <div class="feature-item">
                        <img src="{{ asset('images/stackbook.png') }}" alt="Icon" class="feature-icon">
                        <h3>Koleksi Luas</h3>
                        <p>Akses ribuan buku dari berbagai genre dan penulis terkemuka.</p>
                    </div>
                    <div class="feature-item">
                        <img src="{{ asset('images/hp.png') }}" alt="Icon" class="feature-icon">
                        <h3>Baca Kapan Saja</h3>
                        <p>Nikmati buku favoritmu di smartphone, tablet, atau desktop.</p>
                    </div>
                    <div class="feature-item">
                        <img src="{{ asset('images/lightbulb.png') }}" alt="Icon" class="feature-icon">
                        <h3>Rekomendasi Cerdas</h3>
                        <p>Temukan bacaan baru yang sesuai dengan minatmu.</p>
                    </div>
                    <div class="feature-item">
                        <img src="{{ asset('images/cursor.png') }}" alt="Icon" class="feature-icon">
                        <h3>Antarmuka Intuitif</h3>
                        <p>Desain yang bersih dan mudah digunakan untuk pengalaman membaca terbaik.</p>
                    </div>
                </div>
            </div>
        </section>
        <div class="svg-wave-container">
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,256L360,192L720,320L1080,128L1440,64L1440,0L1080,0L720,0L360,0L0,0Z"></path></svg>
        </div>
        <section class="categories-section">
            <div class="container">
                <h2 class="section-title">Jelajahi Berbagai Kategori 🔖</h2>
                <div class="categories-grid">
                    <div class="category-item">
                        <img src="{{ asset('images/kesehatan.png') }}" alt="kesehatan" class="category-icon">
                        <span>Kesehatan</span>
                    </div>
                    <div class="category-item">
                        <img src="{{ asset('images/self-development.png') }}" alt="Self-dev" class="category-icon">
                        <span>Self Development</span>
                    </div>
                    <div class="category-item">
                        <img src="{{ asset('images/rose.png') }}" alt="Romance" class="category-icon">
                        <span>Romantis</span>
                    </div>
                    <div class="category-item">
                        <img src="{{ asset('images/fantasi.png') }}" alt="Fantasi" class="category-icon">
                        <span>Fantasi</span>
                    </div>
                    <div class="category-item">
                        <img src="{{ asset('images/technology.png') }}" alt="Sains" class="category-icon">
                        <span>Teknologi</span>
                    </div>
                </div>
            </div>
        </section>
        <section class="cta-subscribe-section">
            <div class="container cta-subscribe-content">
                <div class="cta-subscribe-left">
                    <h2 class="cta-title">Jangan Lewatkan Kisah Terbaik! Mulai Langganan & Nikmati Seluruh Koleksi Buku ✨</h2>
                    <p class="cta-description">
                        Berlangganan sekarang dan buka akses tak terbatas ke ribuan buku premium dari berbagai penulis.
                        Mulai petualangan membacamu hari ini!
                    </p>
                    <a href="#" class="cta-button">Lihat Paket Langganan</a>
                </div>
                <div class="cta-subscribe-right">
                    <img src="{{ asset('images/cover-buku-1.jpeg')}}" alt="Book 1" class="cta-book-img cta-book-1">
                    <img src="{{ asset('images/cover-buku-2.jpeg')}}" alt="Book 2" class="cta-book-img cta-book-2">
                </div>
            </div>
        </section>


        <footer class="main-footer">
            <div class="container footer-content">
                <div class="footer-brand">
                    <a href="#" class="navbar-brand">Elibrary</a>
                    <p>&copy; 2023 Elibrary. All rights reserved.</p>
                </div>
                <div class="footer-links">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="{{ route('welcome') }}">Beranda</a></li>
                        <li><a href="{{ route('listbuku.page') }}">Koleksi Buku</a></li>
                        <li><a href="{{ route('paket.langganan') }}">Paket Langganan</a></li>
                        <li><a href="{{ route('tentang.kami') }}">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Bantuan</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Kontak Kami</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="footer-social">
                    <h4>Ikuti Kami</h4>
                    <div class="social-icons">
                        <a href="#"><img src="{{ asset('images/facebook.png') }}" alt="Facebook"></a>
                        <a href="#"><img src="{{ asset('images/instagram.png') }}"></a>
                        <a href="#"><img src="{{ asset('images/twitter.png') }}" alt="Twitter"></a>
                    </div>
                </div>
            </div>
        </footer>
  <script src="https://unpkg.com/scrollreveal"></script>
 <script>

            
            ScrollReveal({
                distance: '80px',   
                duration: 1200,    
                easing: 'cubic-bezier(.215,.61,.355,1)', 
                interval: 0,       
                origin: 'bottom',  
                reset: false,       
                viewFactor: 0.2     
            });

          
            ScrollReveal().reveal('.navbar', {
                origin: 'top',
                distance: '20px',
                duration: 800,
                delay: 100, // Sedikit delay setelah load
                reset: false // Hanya sekali saat load
            });
            ScrollReveal().reveal('.navbar-brand, .navbar-links a, .hero-button-primary[style="color: #fff"]', {
                origin: 'top',
                distance: '10px',
                duration: 800,
                interval: 50, 
                delay: 300, 
                reset: false
            });

            ScrollReveal().reveal('.hero-text-left .hero-title', {
                origin: 'left',
                distance: '50px',
                duration: 1000,
                delay: 400,
                reset: false
            });
            ScrollReveal().reveal('.hero-text-left .hero-description', {
                origin: 'left',
                distance: '50px',
                duration: 1000,
                delay: 600,
                reset: false
            });
            ScrollReveal().reveal('.hero-text-left .hero-buttons', {
                origin: 'left',
                distance: '50px',
                duration: 1000,
                delay: 800,
                reset: false
            });

             ScrollReveal().reveal('.book-cover-container:nth-child(1)', {
                origin: 'right', 
                distance: '200px', 
                duration: 1500,
                scale: 0.8,
                rotate: { x: 0, y: 0, z: -10 },
                delay: 1000, 
                reset: false
            });
            ScrollReveal().reveal('.book-cover-container:nth-child(2)', {
                origin: 'right', 
                distance: '150px', 
                duration: 1500,
                scale: 0.8,
                rotate: { x: 0, y: 0, z: 5 },
                delay: 1300, 
                reset: false
            });
            ScrollReveal().reveal('.book-cover-container:nth-child(3)', {
                origin: 'right', 
                distance: '100px', 
                duration: 1500,
                scale: 0.8,
                rotate: { x: 0, y: 0, z: -5 },
                delay: 1600, 
                reset: false
            });

            // Animasi Section Title umum
            ScrollReveal().reveal('.section-title', {
                origin: 'top',
                distance: '30px',
                duration: 900,
                delay: 100,
                viewFactor: 0.5 // Muncul lebih awal
            });

            // Features Section
            ScrollReveal().reveal('.feature-item', {
                origin: 'bottom',
                distance: '50px',
                duration: 1000,
                interval: 150, // Muncul berurutan
                delay: 200
            });

            // Categories Section
            ScrollReveal().reveal('.category-item', {
                origin: 'bottom',
                distance: '50px',
                duration: 1000,
                interval: 100, // Muncul berurutan
                delay: 200
            });

            // CTA Subscribe Section
            ScrollReveal().reveal('.cta-title, .cta-description, .cta-button', {
                origin: 'bottom',
                distance: '50px',
                duration: 1000,
                interval: 100,
                delay: 200
            });
            ScrollReveal().reveal('.cta-book-1', {
                origin: 'left',
                distance: '80px',
                duration: 1200,
                scale: 0.9,
                delay: 300
            });
            ScrollReveal().reveal('.cta-book-2', {
                origin: 'right',
                distance: '80px',
                duration: 1200,
                scale: 0.9,
                delay: 500
            });

            // Footer
            ScrollReveal().reveal('.main-footer .footer-brand, .main-footer .footer-links, .main-footer .footer-social', {
                origin: 'bottom',
                distance: '30px',
                duration: 800,
                interval: 100,
                delay: 100
            });
        </script>
</body>
</html>



   
