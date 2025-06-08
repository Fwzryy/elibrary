<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elibrary - Paket Langganan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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

        /* Custom colors based on the design - KEEP THESE */
        .bg-purple-primary { background-color: #5b21b6; }
        .text-purple-accent { color: #8b5cf6; }
        .bg-purple-light { background-color: #a78bfa; }
        .bg-pink-light { background-color: #fce7f3; }
        .bg-cream { background-color: #fffbeb; }
/
        .hero-shape-1 {
            background-color: #8b5cf6; width: 150px; height: 150px; border-radius: 50%; opacity: 0.1;
        }
        .hero-shape-2 {
            background-color: #c084fc; width: 100px; height: 100px; border-radius: 50%; opacity: 0.15; transform: rotate(45deg);
        }
        .hero-shape-3 {
            background-color: #a78bfa; width: 200px; height: 200px; border-radius: 50% 0 50% 0; opacity: 0.1; transform: rotate(-30deg);
        }

        .price-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #8b5cf6; 
            color: white;
            padding: 8px 16px;
            font-weight: bold;
            font-size: 0.875rem;
            border-bottom-left-radius: 1rem; 
            transform: translateY(-10%) translateX(6%) rotate(0deg);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        

        .price-badge.highlight {
            background: linear-gradient(90deg,rgba(42, 123, 155, 1) 0%, rgba(87, 199, 133, 1) 50%, rgba(237, 221, 83, 1) 100%);
            transform: translateY(-10%) translateX(3%) rotate(0deg) scale(1.1);
            font-size: 0.875rem;
            transition: 1s;
            margin-bottom: 10px;
            color:#161616;
            box-shadow: rgba(255, 237, 166, 0.4) 0px 10px 50px;
        }

        .price-card:hover .price-badge.highlight {
            transform: translateY(-10%) translateX(3%) rotate(2deg) scale(1.2);
            transition: 1s;
            background: linear-gradient(90deg,rgba(42, 123, 155, 1) 0%, rgba(87, 199, 133, 1) 0%, rgba(237, 221, 83, 1) 100%);

        }

        /* Hover effects for cards */
        .price-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .price-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
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
                Perluas Cakrawalamu, <br class="hidden sm:inline"> Raih Pengetahuan Tanpa Batas
            </h1>
            <p class="text-lg md:text-xl text-purple-200 mb-8 max-w-2xl mx-auto">
                — Selami samudra pengetahuan, bangkitkan ide, dan ciptakan masa depan, lembar demi lembar.
            </p>
            <div class="flex justify-center">
                <a href="{{ route('listbuku.page') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold flex items-center justify-center" >
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
        <div class="container mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-12 pricing-title">Pilih Paket Langgananmu! ✨</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                @foreach ($packages as $package)
                    <div class=" p-8 rounded-2xl shadow-lg relative overflow-hidden price-card" style="background-color: rgb(22, 1, 40); ">
                        @if ($package['highlight'])
                            <div class="price-badge highlight">Pilihan Terbaik! 🥳</div>
                        @else
                            <div class="price-badge">{{ $package['label'] }}</div>
                        @endif
                        &nbsp;
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $package['name'] }}</h3>
                        <p class="text-purple-accent text-4xl font-extrabold mb-6">{{ $package['price'] }}</p>
                        <ul class="text-white mb-8 space-y-3 text-left mx-auto">
                            @foreach ($package['features'] as $feature)
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <div class="svg-wave-container">
       <svg id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 260" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(221, 214, 254, 1)" offset="0%"></stop><stop stop-color="rgba(81.083, 11, 255, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,208L17.1,182C34.3,156,69,104,103,73.7C137.1,43,171,35,206,65C240,95,274,165,309,164.7C342.9,165,377,95,411,73.7C445.7,52,480,78,514,112.7C548.6,147,583,191,617,199.3C651.4,208,686,182,720,143C754.3,104,789,52,823,47.7C857.1,43,891,87,926,86.7C960,87,994,43,1029,47.7C1062.9,52,1097,104,1131,138.7C1165.7,173,1200,191,1234,177.7C1268.6,165,1303,121,1337,99.7C1371.4,78,1406,78,1440,95.3C1474.3,113,1509,147,1543,160.3C1577.1,173,1611,165,1646,164.7C1680,165,1714,173,1749,182C1782.9,191,1817,199,1851,186.3C1885.7,173,1920,139,1954,121.3C1988.6,104,2023,104,2057,95.3C2091.4,87,2126,69,2160,52C2194.3,35,2229,17,2263,21.7C2297.1,26,2331,52,2366,56.3C2400,61,2434,43,2451,34.7L2468.6,26L2468.6,260L2451.4,260C2434.3,260,2400,260,2366,260C2331.4,260,2297,260,2263,260C2228.6,260,2194,260,2160,260C2125.7,260,2091,260,2057,260C2022.9,260,1989,260,1954,260C1920,260,1886,260,1851,260C1817.1,260,1783,260,1749,260C1714.3,260,1680,260,1646,260C1611.4,260,1577,260,1543,260C1508.6,260,1474,260,1440,260C1405.7,260,1371,260,1337,260C1302.9,260,1269,260,1234,260C1200,260,1166,260,1131,260C1097.1,260,1063,260,1029,260C994.3,260,960,260,926,260C891.4,260,857,260,823,260C788.6,260,754,260,720,260C685.7,260,651,260,617,260C582.9,260,549,260,514,260C480,260,446,260,411,260C377.1,260,343,260,309,260C274.3,260,240,260,206,260C171.4,260,137,260,103,260C68.6,260,34,260,17,260L0,260Z"></path></svg>
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
                    <li class="mb-2"><a href="{{ route('listbuku.page') }}" class="hover:text-purple-accent">Koleksi</a></li>
                    <li class="mb-2"><a href="{{ route('paket.langganan') }}" class="hover:text-purple-accent">Paket Langganan</a></li>
                    <li class="mb-2"><a href="{{ route('tentang.kami') }}" class="hover:text-purple-accent">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 mb-4">Resources</h3>
                <ul>
                    <li class="mb-2"><a href="#" class="hover:text-purple-accent">Blog</a></li>
                    <li class="mb-2"><a href="#" class="hover:text-purple-accent">FAQ</a></li>
                    <li class="mb-2"><a href="#" class="hover:text-purple-accent">Support</a></li>
                    <li class="mb-2"><a href="#" class="hover:text-purple-accent">Terms</a></li>
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
                      <div class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.772 1.666 4.972 4.918.06.848.081 1.096.081 3.226c0 2.13-.021 2.379-.081 3.227-.2 3.252-1.72 4.771-4.972 4.918-1.266.058-1.647.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.148-4.771-1.667-4.972-4.919-.06-.848-.08-1.096-.08-3.226 0-2.13.02-2.378.08-3.226.2-3.252 1.72-4.771 4.972-4.919 1.266-.058 1.647-.07 4.85-.07zM0 12c0 3.252 1.667 4.771 4.919 4.972.848.06 1.096.08 3.227.08 2.13 0 2.379-.02 3.227-.08 3.252-.2 4.771-1.72 4.918-4.972.06-.848.08-1.096.08-3.227 0-2.13-.02-2.379-.08-3.226-.2-3.252-1.72-4.771-4.972-4.919-1.266-.058-1.647-.07-4.85-.07s-3.584.012-4.85.07C3.42 2.378 0 5.753 0 12z"></path></div>
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

        // Animasi Paket Langganan
        ScrollReveal().reveal('.pricing-title', {
            origin: 'top', distance: '30px', duration: 900, delay: 100, viewFactor: 0.5
        });
        ScrollReveal().reveal('.price-card', {
            origin: 'left', distance: '50px', duration: 1000, interval: 150, delay: 200
        });

        // Animasi Footer
        ScrollReveal().reveal('footer .grid > div', {
            origin: 'bottom', distance: '30px', duration: 800, interval: 100, delay: 100
        });
    </script>
</body>
</html>