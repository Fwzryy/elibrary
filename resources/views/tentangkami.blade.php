<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elibrary - Tentang Kami</title> <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f8f8;
            color: #333;
        }
        html {
            scroll-behavior: smooth;
        }
        .bg-purple-primary { background-color: #5b21b6; }
        .text-purple-accent { color: #8b5cf6; }
        .bg-purple-light { background-color: #a78bfa; }
        .bg-pink-light { background-color: #fce7f3; }
        .bg-cream { background-color: #fffbeb; }

        .hero-shape-1 {
            background-color: #8b5cf6; width: 150px; height: 150px; border-radius: 50%; opacity: 0.1;
        }
        .hero-shape-2 {
            background-color: #c084fc; width: 100px; height: 100px; border-radius: 50%; opacity: 0.15; transform: rotate(45deg);
        }
        .hero-shape-3 {
            background-color: #a78bfa; width: 200px; height: 200px; border-radius: 50% 0 50% 0; opacity: 0.1; transform: rotate(-30deg);
        }

        .about-title,
        .about-text,
        .about-image,
        .about-value-item {
            opacity: 1;
        }
    </style>
</head>
<body class="overflow-x-hidden">

    <header class="relative bg-purple-primary text-white py-16 md:py-24 lg:py-12 lg:pb-64 overflow-hidden" style="border-bottom-right-radius:3.5rem; border-bottom-left-radius:3.5rem;">
        <nav class="container mx-auto px-4 mb-8 flex justify-between items-center">
            <div class="font-bold text-xl">Elibrary.</div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('welcome') }}" class="hover:text-gray-300">Beranda</a> 
                <a href="{{ route('listbuku.page') }}" class="hover:text-gray-300">Koleksi</a> 
                <a href="{{ route('paket.langganan') }}" class="hover:text-gray-300">Paket Langganan</a>
                <a href="{{ route('tentang.kami') }}" class="hover:text-gray-300">Tentang Kami</a> 
                <a href="{{ route('filament.admin.auth.login') }}" class="bg-purple-300 text-gray-700 px-4 py-2 rounded-full font-semibold hover:bg-gray-800 hover:text-purple-200 transition duration-300">!</a>
            </div>
        </nav>

        <div class="container mx-auto text-center px-4 relative z-10">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Tentang Kami <br class="hidden sm:inline"> Membangun Masa Depan Literasi
            </h1>
            <p class="text-lg md:text-xl text-purple-200 mb-8 max-w-2xl mx-auto">
                — Memperkenalkan Elibrary, platform yang berkomitmen untuk menyebarkan ilmu dan pengetahuan.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 w-full h-40 md:h-60 lg:h-80 flex justify-center items-end z-0">
            <img src="{{ asset('images/open-book.png') }}" class="w-96 max-w-4xl h-auto object-contain -mb-16 md:-mb-24 lg:-mb-32">
            <img src="{{ asset('images/pencil.png') }}" alt="Pencil" class="absolute bottom-20 left-10 transform -rotate-45 w-28 h-28 object-contain">
            <img src="{{ asset('images/stabilo.png') }}" alt="Bookmark" class="absolute bottom-16 right-3/4 transform rotate-6 w-28 h-28 object-contain">
            <img src="{{ asset('images/ereader.png') }}" alt="E-reader" class="absolute top-0- right-10 -translate-x-1/2 -translate-y-1/2 w-64 h-64 object-contain ">
            <img src="{{ asset('images/search.png')}}" alt="Search icon" class="absolute bottom-12 right-1/4 transform translate-x-1/2 w-44 h-44 object-contain ">
        </div>

        <div class="absolute top-1/4 left-10 hero-shape-1"></div>
        <div class="absolute top-1/3 right-20 hero-shape-2"></div>
        <div class="absolute bottom-1/4 left-1/3 hero-shape-3"></div>
        <div class="absolute bottom-1/2 right-1/4 w-12 h-12 bg-purple-300 rounded-full opacity-20"></div>
    </header>
    <section class="bg-cream py-16 md:py-24 px-4">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 text-center md:text-left mb-12 md:mb-0">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Tentang Elibrary<br> Solusi Praktis untuk Akses Ilmu Tanpa Batas</h2>
                <p class="text-gray-600 text-lg max-w-lg mx-auto md:mx-0 text-justify leading-relaxed">
                  E-Library adalah platform perpustakaan digital yang dirancang untuk memberikan akses mudah ke ribuan buku elektronik dari berbagai kategori. Melalui sistem ini, pengguna dapat membaca buku kapan saja dan di mana saja, hanya dengan koneksi internet dan akun aktif. Latar belakang dari terbentuknya E-Library ini berangkat dari kebutuhan akan sarana belajar yang fleksibel, efisien, dan ramah digital—khususnya di era pembelajaran modern yang mengandalkan teknologi. Dengan adanya sistem berlangganan dan koleksi buku premium, E-Library juga mendorong ekosistem literasi digital yang berkelanjutan. 
                </p>
            </div>
            <div class="md:w-1/2 relative bg-pink-light p-8 rounded-2xl shadow-lg flex items-center justify-center min-h-[250px]">
                <img src="{{ asset('images/book.png')}}" alt="Stack of Books" class="absolute -left-10 -top-10 w-40 h-auto object-contain z-10">
                <div class="text-purple-primary text-3xl font-bold text-center">Seputar Elibrary 😀</div>
                <img src="{{ asset('images/pen.png') }}" alt="Small Icon" class="absolute bottom-4 right-4 w-16 h-16 object-contain">
            </div>
        </div>
    </section>
    <section class="bg-white py-16 md:py-24 px-4">
        <div class="container mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12 about-title">Misi & Visi Kami</h2>
            <div class="flex flex-col md:flex-row items-center justify-between gap-12 mb-20">
                <div class="md:w-1/2 text-center md:text-left about-text">
                    <h3 class="text-2xl font-semibold text-purple-accent mb-4">Misi</h3>
                    <p class="text-gray-600 text-lg leading-relaxed text-justify ">
                        Misi Elibrary adalah untuk mendemokratisasi akses terhadap pengetahuan. Kami percaya setiap individu berhak mendapatkan akses mudah ke sumber daya bacaan berkualitas tinggi, tanpa terhalang batasan geografis atau ekonomi. Kami bertekad untuk menjadi jembatan antara pembaca dan dunia pengetahuan.
                    </p>
                </div>
                <div class="md:w-1/2 text-center md:text-right about-text">
                    <h3 class="text-2xl font-semibold text-purple-accent mb-4">Visi</h3>
                    <p class="text-gray-600 text-lg leading-relaxed text-justify">
                        Visi kami adalah menciptakan masyarakat yang literat dan haus akan ilmu. Kami ingin menjadi platform digital terdepan yang menginspirasi jutaan orang untuk terus belajar, berinovasi, dan berkontribusi positif bagi dunia melalui kekuatan membaca.
                    </p>
                </div>
            </div>

            <div class="text-center mb-12 about-title">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Nilai-Nilai Kami</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm text-center about-value-item">
                    <img src="{{ asset('images/innovation.png') }}" alt="Inovasi" class="w-24 h-24 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Inovasi</h3>
                    <p class="text-gray-600 text-sm">Kami terus berinovasi untuk memberikan pengalaman membaca dan belajar terbaik.</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm text-center about-value-item">
                    <img src="{{ asset('images/accessibility.png') }}" alt="Aksesibilitas" class="w-24 h-24 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Aksesibilitas</h3>
                    <p class="text-gray-600 text-sm">Pengetahuan harus dapat diakses oleh semua orang, di mana pun mereka berada.</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm text-center about-value-item">
                    <img src="{{ asset('images/community.png') }}" alt="Komunitas" class="w-24 h-24 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Komunitas</h3>
                    <p class="text-gray-600 text-sm">Kami percaya pada kekuatan berbagi dan belajar bersama.</p>
                </div>
            </div>

            <div class="flex justify-center mt-8">
               <div class="text-center about-title p-10 rounded-xl" style="background-color: #DDD6FE; margin-right: 20px; border:2px dashed;">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">🧑‍💻 Tim Kami</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto mt-4 about-text">
                  Di balik setiap buku digital yang Anda nikmati, ada tim yang penuh semangat dan komitmen. Kami terdiri dari pengembang, desainer, dan pengelola konten yang bekerja sama untuk memastikan setiap aspek E-Library berjalan mulus—dari tampilan yang nyaman hingga fitur yang memudahkan. Kami percaya bahwa teknologi dapat menjadi jembatan menuju literasi yang lebih luas, dan itulah yang mendorong kami untuk terus berkembang.
                </p>
            </div>
                <img src="{{ asset('images/team.jpg') }}" alt="Tim Elibrary" class="w-full max-w-2xl rounded-lg shadow-lg about-image" style="box-shadow: rgba(124, 46, 240, 0.4) 5px 5px, rgba(101, 46, 240, 0.3) 10px 10px, rgba(111, 46, 240, 0.2) 15px 15px, rgba(124, 46, 240, 0.1) 20px 20px, rgba(95, 46, 240, 0.05) 25px 25px;">
            </div>
        </div>
    </section>
     <footer class="bg-purple-200 py-16 md:py-24 text-gray-600">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div>
                <div class="font-bold text-2xl text-gray-800 mb-4">Elibrary.</div>
                <p class="text-sm">A comprehensive platform for all your reading and learning needs.</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 mb-4">Quick Links</h3>
                <ul>
                    <li class="mb-2"><a href="{{ route('welcome') }}" class="hover:text-purple-accent">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('listbuku.page') }}" class="hover:text-purple-accent">Koleksi Buku</a></li>
                    <li class="mb-2"><a href="{{ route('paket.langganan') }}" class="hover:text-purple-accent">Paket Langganan</a></li>
                    <li class="mb-2"><a href="{{ route('tentang.kami') }}" class="hover:text-purple-accent">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 mb-4">Resources</h3>
                <ul>
                    <li class="mb-2"><a href="#" class="hover:text-purple-accent">FAQ</a></li>
                    <li class="mb-2"><a href="#" class="hover:text-purple-accent">Kontak Kami</a></li>
                    <li class="mb-2"><a href="#" class="hover:text-purple-accent">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 mb-4">Contact Us</h3>
                <ul>
                    <li class="mb-2">Email: info@elibrary.com</li>
                    <li class="mb-2">Phone: +123 456 7890</li>
                    <li class="mb-2">Address: 123 Library St, Book Town</li>
                </ul>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-500 hover:text-purple-accent">
                      <div class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.772 1.666 4.972 4.918.06.848.081 1.096.081 3.226c0 2.13-.021 2.379-.081 3.227-.2 3.252-1.72 4.771-4.972 4.918-1.266.058-1.647.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.148-4.771-1.667-4.972-4.919-.06-.848-.08-1.096-.08-3.226 0-2.13.02-2.378.08-3.226.2-3.252 1.72-4.771 4.972-4.919 1.266-.058 1.647-.07 4.85-.07zm0-2.163C8.653 0 8.35.011 7.185.069 3.42 2.378 0 5.753 0 12s3.42 9.622 7.185 9.931c1.165.058 1.468.07 4.815.07s3.65-.012 4.815-.07c3.765-.309 7.185-3.684 7.185-9.931s-3.42-9.622-7.185-9.931c-1.165-.058-1.468-.07-4.815-.07z"/></div>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://unpkg.com/scrollreveal"></script>

    <script>
        ScrollReveal({
            distance: '60px', duration: 1000, easing: 'cubic-bezier(.215,.61,.355,1)', interval: 0, origin: 'bottom', reset: false, viewFactor: 0.2
        });

        // Animasi Header (Navbar & Hero)
        ScrollReveal().reveal('header .container > *', {
            origin: 'top', distance: '20px', duration: 800, interval: 100, delay: 200, reset: false
        });
        ScrollReveal().reveal('header .absolute img, header .absolute div', {
            origin: 'bottom', distance: '50px', duration: 1000, interval: 100, delay: 500, reset: false
        });

        // Animasi Konten Tentang Kami
        ScrollReveal().reveal('.about-title', {
            origin: 'left', distance: '30px', duration: 900, delay: 100, viewFactor: 0.5
        });
        ScrollReveal().reveal('.about-text', {
            origin: 'bottom', distance: '50px', duration: 1000, interval: 100, delay: 200
        });
        ScrollReveal().reveal('.about-value-item', {
            origin: 'bottom', distance: '50px', duration: 1000, interval: 150, delay: 300
        });
        ScrollReveal().reveal('.about-image', {
            origin: 'right', distance: '50px', duration: 1000, delay: 400
        });

        // Animasi Footer
        ScrollReveal().reveal('footer .grid > div', {
            origin: 'bottom', distance: '30px', duration: 800, interval: 100, delay: 100
        });
    </script>
</body>
</html>