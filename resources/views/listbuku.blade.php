<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elibrary - Expand Your Mind</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f8f8; 
            color: #333;
        }
        .bg-purple-primary { background-color: #5b21b6; } 
        .text-purple-accent { color: #8b5cf6; } 
        .bg-purple-light { background-color: #a78bfa; }
        .bg-pink-light { background-color: #fce7f3; } 
        .bg-cream { background-color: #fffbeb; } 

        .hero-shape-1 {
            background-color: #8b5cf6; 
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 0.1;
        }
        .hero-shape-2 {
            background-color: #c084fc; 
            width: 100px;
            height: 100px;
            border-radius: 50%;
            opacity: 0.15;
            transform: rotate(45deg);
        }
        .hero-shape-3 {
            background-color: #a78bfa; /* Example color for third shape */
            width: 200px;
            height: 200px;
            border-radius: 50% 0 50% 0; /* Irregular shape */
            opacity: 0.1;
            transform: rotate(-30deg);
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
            <a href="#" class="bg-purple-300 text-gray-700 px-4 py-2 rounded-full font-semibold hover:bg-gray-800 hover:text-purple-200 transition duration-300" disabled>📖</a>
        </div>
    </nav>

    <div class="container mx-auto text-center px-4 relative z-10"> <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
            Perluas Cakrawalamu, <br class="hidden sm:inline"> Raih Pengetahuan Tanpa Batas
        </h1>
        <p class="text-lg md:text-xl text-purple-200 mb-8 max-w-2xl mx-auto">
            — Selami samudra pengetahuan, bangkitkan ide, dan ciptakan masa depan, lembar demi lembar.
        </p>
        <div class="flex justify-center">
            <a href="#" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold flex items-center justify-center" >
                Mari Jelajahi Beragam Buku Menarik!
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>

            <a href="{{ route('filament.admin.auth.login') }}" class="bg-white ml-4 text-purple-700 px-8 py-4 rounded-full font-semibold shadow-lg hover:bg-black hover:text-white transition duration-300 flex items-center justify-center text-center">
                Masuk Terlebih Dahulu untuk Menjelajahi Setiap Buku 👆
            </a>
        </div>
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

    <section class="bg-gray-100 py-16 md:py-24 px-4">
        <div class="container mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12">Koleksi Buku-Buku Terbaru! 🆕</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              @forelse ($latestBooks as $book)
                <div class="bg-white p-6 rounded-2xl shadow-md flex flex-col items-center text-center hover:shadow-xl transition duration-300">
                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                    alt="{{ $book->title }}"
                    class="w-64 h-64 object-contain mb-4 rounded-2xl">

                <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ $book->title }}</h3>
                <p class="text-gray-400 text-sm">{{ $book->author }}</p>

                <div class="mt-2">
            @if ($book->is_free)
                <span class="bg-green-500 text-white text-xs font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Gratis
                </span>
            @else
                <span class="bg-yellow-500 text-gray-900 text-xs font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Premium
                </span>
            @endif
        </div>
        
                </div>
              @empty
                  {{-- Teks ini akan ditampilkan jika tidak ada buku di database --}}
              <p class="text-gray-300 text-center col-span-full">Belum ada buku terbaru yang tersedia.</p>
              @endforelse
            </div>
        </div>
    </section>

<section class="bg-gray-100 py-16 md:py-24 px-4">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between">
        <div class="md:w-1/2 text-center md:text-left mb-12 md:mb-0">
            <h2 class="text-3xl md:text-6xl font-bold text-gray-800 mb-8">Apa yang Akan Kamu Temukan <br> di <span class="text-purple-accent">Elibrary</span>?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Item 1 --}}
                <div class="flex items-start text-left">
                    <svg class="w-8 h-8 text-purple-accent mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800">Ilmu Luas Tanpa Batas</h2>
                        <p class="text-gray-600 text-md">Akses ke jutaan topik dari berbagai disiplin ilmu.</p>
                    </div>
                </div>
                {{-- Item 2 --}}
                <div class="flex items-start text-left">
                    <svg class="w-8 h-8 text-purple-accent mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"></path></svg>
                    <div>
                        <h3 class="font-semibold text-xl  text-gray-800">Aneka Genre Pilihan</h3>
                        <p class="text-gray-600 text-md">Dari fiksi yang memukau hingga non-fiksi yang mencerahkan</p>
                    </div>
                </div>
                {{-- Item 3 --}}
                <div class="flex items-start text-left">
                    <svg class="w-8 h-8 text-purple-accent mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2-3 .895-3 2 1.343 2 3 2m0-8V4m0 12v4"></path></svg>
                    <div>
                        <h3 class="font-semibold text-xl  text-gray-800">Penulis Terkemuka</h3>
                        <p class="text-gray-600 text-md">Belajar langsung dari para ahli dan pemikir terbaik</p>
                    </div>
                </div>
                {{-- Item 4 --}}
                <div class="flex items-start text-left">
                    <svg class="w-8 h-8 text-purple-accent mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <div>
                        <h3 class="font-semibold text-xl  text-gray-800">Konten Interaktif</h3>
                        <p class="text-gray-600 text-md">Pengalaman membaca yang lebih menarik dan dinamis.</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Gambar di kanan --}}
        <div class="md:w-1/2 relative flex justify-center items-center mt-12 md:mt-0 min-h-[300px]">
            <img src="{{ asset('images/stackbook.png') }}" alt="Book Stack" class="w-full max-w-md h-auto object-contain left-44">
        </div>
    </div>
</section>
 <div class="svg-wave-container">
      <svg id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 300" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(221, 214, 254, 1)" offset="0%"></stop><stop stop-color="rgba(81.083, 11, 255, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,60L80,150L160,30L240,210L320,210L400,150L480,270L560,60L640,180L720,90L800,120L880,180L960,210L1040,30L1120,150L1200,240L1280,60L1360,30L1440,30L1520,30L1600,210L1680,90L1760,60L1840,90L1920,90L1920,300L1840,300L1760,300L1680,300L1600,300L1520,300L1440,300L1360,300L1280,300L1200,300L1120,300L1040,300L960,300L880,300L800,300L720,300L640,300L560,300L480,300L400,300L320,300L240,300L160,300L80,300L0,300Z"></path></svg>
        </div>
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
            distance: '60px',
            duration: 1000,
            easing: 'cubic-bezier(.215,.61,.355,1)',
            interval: 0,
            origin: 'bottom',
            reset: false,
            viewFactor: 0.2 
        });

    
        ScrollReveal().reveal('header .container > *', {
            origin: 'top',
            distance: '20px',
            duration: 800,
            interval: 100,
            delay: 200,
            reset: false
        });
        ScrollReveal().reveal('header .absolute img, header .absolute div', {
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            interval: 100,
            delay: 500,
            reset: false
        });


        // Animasi Section "Tentang Elibrary"
        ScrollReveal().reveal('section:nth-of-type(1) .md\\:w-1\\/2:nth-child(1) > *', {
            origin: 'left',
            distance: '50px',
            duration: 1000,
            interval: 100,
            delay: 200
        });
        ScrollReveal().reveal('section:nth-of-type(1) .md\\:w-1\\/2:nth-child(2)', {
            origin: 'right',
            distance: '50px',
            duration: 1000,
            delay: 400
        });


        // Animasi Section "Buku-Buku Terbaru!"
        ScrollReveal().reveal('section:nth-of-type(2) .text-center.mb-12', {
            origin: 'top',
            distance: '30px',
            duration: 900,
            delay: 100,
            viewFactor: 0.5
        });
        ScrollReveal().reveal('.grid-cols-1.md\\:grid-cols-3 .bg-white', { 
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            interval: 150, 
            delay: 200
        });


        // Animasi Section "Apa Kata Mereka"
        ScrollReveal().reveal('section:nth-of-type(3) .text-center.relative', {
            origin: 'top',
            distance: '30px',
            duration: 900,
            delay: 100,
            viewFactor: 0.5
        });
        ScrollReveal().reveal('section:nth-of-type(3) .md\\:w-1\\/2:nth-child(1) > *', {
            origin: 'left',
            distance: '50px',
            duration: 1000,
            interval: 100,
            delay: 200
        });
        ScrollReveal().reveal('section:nth-of-type(3) .md\\:w-1\\/2:nth-child(2) img', {
            origin: 'right',
            distance: '50px',
            duration: 1000,
            interval: 100,
            delay: 300
        });

        // Animasi Section "Apa yang Akan Kamu Temukan"
        ScrollReveal().reveal('section:nth-of-type(4) .md\\:w-1\\/2:nth-child(1) > *', {
            origin: 'left',
            distance: '50px',
            duration: 1000,
            interval: 100,
            delay: 200
        });
        ScrollReveal().reveal('section:nth-of-type(4) .md\\:w-1\\/2:nth-child(2) img', {
            origin: 'right',
            distance: '50px',
            duration: 1000,
            interval: 100,
            delay: 300
        });


        // Animasi CTA Section terakhir
        ScrollReveal().reveal('section:nth-of-type(5) h2, section:nth-of-type(5) button', {
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            interval: 100,
            delay: 200
        });
        ScrollReveal().reveal('section:nth-of-type(5) img', {
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            interval: 150,
            delay: 300
        });


        // Animasi Footer
        ScrollReveal().reveal('footer .grid > div', {
            origin: 'bottom',
            distance: '30px',
            duration: 800,
            interval: 100,
            delay: 100
        });
    </script>
</body>
</html>