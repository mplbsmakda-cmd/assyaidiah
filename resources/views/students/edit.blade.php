@extends('layouts.app')

@section('title', 'Edit Data Santri')

@section('header', 'Edit Data Santri')

@section('content')
<div class="bg-white shadow-sm rounded-lg p-6">
    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Data Santri -->
        <div class="border-b border-gray-200 pb-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Data Santri</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
                    <input type="text" name="nis" id="nis" value="{{ old('nis', $student->nis) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nis') border-red-500 @enderror" required>
                    @error('nis')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $student->birth_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('birth_date') border-red-500 @enderror" required>
                    @error('birth_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('status') border-red-500 @enderror" required>
                        <option value="aktif" {{ old('status', $student->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ old('status', $student->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="lulus" {{ old('status', $student->status) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('address') border-red-500 @enderror" required>{{ old('address', $student->address) }}</textarea>
                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label for="photo" class="block text-sm font-medium text-gray-700">Foto Santri</label>
                    <input type="file" name="photo" id="photo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('photo') border-red-500 @enderror">
                    @if ($student->photo_url)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Foto saat ini:</p>
                            <img src="{{ $student->photo_url }}" alt="Foto {{ $student->name }}" class="mt-2 h-40 w-40 object-cover rounded-md">
                        </div>
                    @endif
                    @error('photo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Data Wali -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">Data Wali</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="guardian_name" class="block text-sm font-medium text-gray-700">Nama Wali</label>
                    <input type="text" name="guardian_name" id="guardian_name" value="{{ old('guardian_name', $student->guardian->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('guardian_name') border-red-500 @enderror" required>
                    @error('guardian_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="guardian_phone_number" class="block text-sm font-medium text-gray-700">No. HP Wali</label>
                    <input type="text" name="guardian_phone_number" id="guardian_phone_number" value="{{ old('guardian_phone_number', $student->guardian->phone_number ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('guardian_phone_number') border-red-500 @enderror" required>
                    @error('guardian_phone_number')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label for="guardian_address" class="block text-sm font-medium text-gray-700">Alamat Wali</label>
                    <textarea name="guardian_address" id="guardian_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('guardian_address') border-red-500 @enderror" required>{{ old('guardian_address', $student->guardian->address ?? '') }}</textarea>
                    @error('guardian_address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('students.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
