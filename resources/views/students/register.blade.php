@extends('layouts.public')

@section('title', 'Pendaftaran Santri Baru')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8 md:p-12">
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Formulir Pendaftaran</h1>
            <p class="text-gray-500 mt-2">Lengkapi data di bawah ini untuk menjadi bagian dari kami.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                <p class="font-bold">Pendaftaran Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Student Information -->
            <div class="mb-10">
                <h2 class="text-2xl font-semibold text-gray-700 mb-6 border-b-2 pb-2">Data Calon Santri</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="relative mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="name" name="name" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('name') }}" required>
                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative mb-4">
                        <label for="birth_date" class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
                         <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" id="birth_date" name="birth_date" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('birth_date') }}" required>
                        @error('birth_date') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2 relative mb-4">
                        <label for="address" class="block text-gray-700 font-medium mb-2">Alamat Lengkap</label>
                        <div class="absolute top-10 left-0 pl-3 flex items-center pointer-events-none">
                             <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <textarea id="address" name="address" rows="3" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>{{ old('address') }}</textarea>
                        @error('address') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2 relative mb-4">
                        <label for="photo" class="block text-gray-700 font-medium mb-2">Pas Foto (Opsional)</label>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-camera text-gray-400"></i>
                        </div>
                        <input type="file" id="photo" name="photo" class="w-full pl-10 pr-4 py-2 border rounded-lg file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
                        @error('photo') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Guardian Information -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-700 mb-6 border-b-2 pb-2">Data Wali Santri</h2>
                <div class="grid md:grid-cols-2 gap-6">
                     <div class="relative mb-4">
                        <label for="guardian_name" class="block text-gray-700 font-medium mb-2">Nama Wali</label>
                         <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user-shield text-gray-400"></i>
                        </div>
                        <input type="text" id="guardian_name" name="guardian_name" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('guardian_name') }}" required>
                        @error('guardian_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative mb-4">
                        <label for="guardian_phone_number" class="block text-gray-700 font-medium mb-2">Nomor Telepon Wali</label>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone-alt text-gray-400"></i>
                        </div>
                        <input type="tel" id="guardian_phone_number" name="guardian_phone_number" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('guardian_phone_number') }}" required>
                        @error('guardian_phone_number') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2 relative mb-4">
                        <label for="guardian_address" class="block text-gray-700 font-medium mb-2">Alamat Wali</label>
                         <div class="absolute top-10 left-0 pl-3 flex items-center pointer-events-none">
                             <i class="fas fa-map-marked-alt text-gray-400"></i>
                        </div>
                        <textarea id="guardian_address" name="guardian_address" rows="3" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>{{ old('guardian_address') }}</textarea>
                        @error('guardian_address') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center">
                <button type="submit" class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-opacity-50 transform hover:scale-105 transition duration-300 shadow-lg">
                    Daftar Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
