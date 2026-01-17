@extends('layouts.public')

@section('title', 'Selamat Datang di Pondok Pesantren Assyaidiah')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .hero-gradient {
        background: linear-gradient(to right, #10B981, #059669);
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .gallery-image {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .gallery-image:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@section('content')
    <header class="hero-gradient text-white text-center py-20">
        <div class="container mx-auto px-6">
            <img src="https://ik.imagekit.io/zco6tu2vm/assa.jpg" alt="Logo Pondok Pesantren Assyaidiah" class="h-24 w-24 mx-auto mb-6 rounded-full shadow-lg border-4 border-white">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-2 tracking-tight">Selamat Datang di Pondok Pesantren Assyaidiah</h1>
            <p class="text-xl mb-8 font-light">Membentuk Generasi Qur'ani, Berakhlak Mulia, dan Berprestasi</p>
            <a href="{{ route('register') }}" class="bg-white text-green-700 font-bold py-3 px-8 rounded-full hover:bg-gray-200 transition duration-300 transform hover:scale-105 shadow-lg">Daftar Sekarang</a>
        </div>
    </header>

    <main class="container mx-auto px-6 py-16">
        <section id="about" class="text-center mb-20">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Tentang Kami</h2>
            <p class="text-gray-600 max-w-3xl mx-auto text-lg">Pondok Pesantren Assyaidiah adalah lembaga pendidikan Islam yang berdedikasi untuk mencetak generasi penerus yang tidak hanya hafal Al-Qur'an, tetapi juga memiliki pemahaman yang mendalam tentang ajaran Islam dan berakhlak mulia. Kami mengintegrasikan kurikulum pendidikan agama dan umum untuk membekali santri dengan ilmu pengetahuan yang seimbang.</p>
        </section>

        <section id="programs" class="mb-20">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">Program Unggulan</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-8 bg-white rounded-xl shadow-md transition duration-300 feature-card">
                    <div class="flex items-center justify-center h-20 w-20 bg-green-100 text-green-600 rounded-full mx-auto mb-6 text-3xl">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-2">Tahfidz Al-Qur'an</h3>
                    <p class="text-gray-600">Program intensif menghafal Al-Qur'an dengan bimbingan dari para hafidz dan hafidzah yang berpengalaman.</p>
                </div>
                <div class="text-center p-8 bg-white rounded-xl shadow-md transition duration-300 feature-card">
                    <div class="flex items-center justify-center h-20 w-20 bg-green-100 text-green-600 rounded-full mx-auto mb-6 text-3xl">
                        <i class="fas fa-scroll"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-2">Kajian Kitab Kuning</h3>
                    <p class="text-gray-600">Pendalaman khazanah keilmuan Islam melalui kajian kitab-kitab klasik karya ulama terdahulu.</p>
                </div>
                <div class="text-center p-8 bg-white rounded-xl shadow-md transition duration-300 feature-card">
                    <div class="flex items-center justify-center h-20 w-20 bg-green-100 text-green-600 rounded-full mx-auto mb-6 text-3xl">
                        <i class="fas fa-school"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-2">Pendidikan Formal</h3>
                    <p class="text-gray-600">Menyediakan pendidikan formal setingkat SMP/MTs dan SMA/MA dengan kurikulum terakreditasi.</p>
                </div>
            </div>
        </section>

        <section id="gallery">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">Galeri Kegiatan</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img class="w-full h-full object-cover gallery-image" src="https://ik.imagekit.io/zco6tu2vm/kegiatan1.jpeg" alt="Kegiatan Santri 1">
                </div>
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img class="w-full h-full object-cover gallery-image" src="https://ik.imagekit.io/zco6tu2vm/kegiatan2.jpeg" alt="Kegiatan Santri 2">
                </div>
                <div class="overflow-hidden rounded-lg shadow-md">
                    <img class="w-full h-full object-cover gallery-image" src="https://ik.imagekit.io/zco6tu2vm/kegiatan3.jpeg" alt="Kegiatan Santri 3">
                </div>
                 <div class="overflow-hidden rounded-lg shadow-md">
                    <img class="w-full h-full object-cover gallery-image" src="https://ik.imagekit.io/zco6tu2vm/kegiatan4.jpeg" alt="Kegiatan Santri 4">
                </div>
                 <div class="overflow-hidden rounded-lg shadow-md">
                    <img class="w-full h-full object-cover gallery-image" src="https://ik.imagekit.io/zco6tu2vm/kegiatan5.jpeg" alt="Kegiatan Santri 5">
                </div>
                 <div class="overflow-hidden rounded-lg shadow-md">
                    <img class="w-full h-full object-cover gallery-image" src="https://ik.imagekit.io/zco6tu2vm/kegiatan6.jpeg" alt="Kegiatan Santri 6">
                </div>
            </div>
        </section>
    </main>
@endsection
