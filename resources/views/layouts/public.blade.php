<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pondok Pesantren Assyaidiah')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23e5e7eb" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
        }
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #10B981; /* green-500 */
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img class="h-12 w-auto" src="https://ik.imagekit.io/zco6tu2vm/assa.jpg" alt="Pondok Pesantren Assyaidiah">
                    <a href="/" class="ml-3 text-xl font-bold text-gray-800">Assyaidiah</a>
                </div>
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="nav-link px-4 py-2 text-gray-700 font-semibold">Beranda</a>
                    <a href="{{ route('home') }}#gallery" class="nav-link px-4 py-2 text-gray-700 font-semibold">Galeri</a>
                    <a href="{{ route('home') }}#contact" class="nav-link px-4 py-2 text-gray-700 font-semibold">Kontak</a>
                    <a href="{{ route('register') }}" class="ml-4 px-6 py-2 bg-green-600 text-white font-semibold rounded-full hover:bg-green-700 transition duration-300 shadow-md hover:shadow-lg focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Pendaftaran</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer id="contact" class="bg-gray-800 text-white mt-12 py-10">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold mb-4">Hubungi Kami</h2>
            <p class="mb-2">Pondok Pesantren Assyaidiah</p>
            <p class="mb-2">Jl. Raya Kopo No.1, Kopo, Cisarua, Bogor, Jawa Barat 16750</p>
            <p class="mb-2">Telepon: (0251) 8295888</p>
            <p class="mb-6">Email: <a href="mailto:info@assyaidiah.sch.id" class="text-green-400 hover:text-green-300 transition">info@assyaidiah.sch.id</a></p>
            <p class="text-gray-400">&copy; {{ date('Y') }} Pondok Pesantren Assyaidiah. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
