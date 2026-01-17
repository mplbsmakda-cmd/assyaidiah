@extends('layouts.app')

@section('title', 'Detail Santri')

@section('header', 'Detail Santri')

@section('content')
<div class="bg-white shadow-sm rounded-lg p-6">
    <div class="flex justify-end mb-4">
        <a href="{{ route('students.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Kembali</a>
        <a href="{{ route('students.edit', $student->id) }}" class="text-sm text-indigo-600 hover:text-indigo-900">Edit</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Foto Santri -->
        <div class="md:col-span-1 flex flex-col items-center">
            @if ($student->photo_url)
                <img src="{{ $student->photo_url }}" alt="Foto {{ $student->name }}" class="h-48 w-48 rounded-full object-cover mb-4">
            @else
                <div class="h-48 w-48 rounded-full bg-gray-200 flex items-center justify-center mb-4">
                    <svg class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            @endif
        </div>

        <!-- Data Santri -->
        <div class="md:col-span-2">
            <div class="border-b border-gray-200 pb-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Data Santri</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NIS</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->nis }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($student->birth_date)->isoFormat('D MMMM Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @switch($student->status)
                                    @case('aktif') bg-green-100 text-green-800 @break
                                    @case('tidak aktif') bg-yellow-100 text-yellow-800 @break
                                    @case('lulus') bg-blue-100 text-blue-800 @break
                                @endswitch">
                                {{ ucfirst($student->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $student->address }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Data Wali -->
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Data Wali</h2>
                @if ($student->guardian)
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Wali</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student->guardian->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No. HP Wali</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student->guardian->phone_number }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Alamat Wali</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student->guardian->address }}</dd>
                        </div>
                    </dl>
                @else
                    <p class="text-sm text-gray-500">Data wali tidak ditemukan.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
