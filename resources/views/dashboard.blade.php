@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .chart-container {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>
@endpush

@section('content')
    <!-- Stats cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 flex items-center stat-card">
            <div class="flex-shrink-0 bg-indigo-100 rounded-full p-4">
                <i class="fas fa-users text-indigo-500 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Santri</p>
                <p class="text-3xl font-bold text-gray-900">{{ $studentCount }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 flex items-center stat-card">
            <div class="flex-shrink-0 bg-orange-100 rounded-full p-4">
                <i class="fas fa-user-friends text-orange-500 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Wali Santri</p>
                <p class="text-3xl font-bold text-gray-900">{{ $guardianCount }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 flex items-center stat-card">
            <div class="flex-shrink-0 bg-green-100 rounded-full p-4">
                <i class="fas fa-user-check text-green-500 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Santri Aktif</p>
                <p class="text-3xl font-bold text-gray-900">{{ $activeStudents }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 flex items-center stat-card">
            <div class="flex-shrink-0 bg-blue-100 rounded-full p-4">
                <i class="fas fa-user-graduate text-blue-500 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Santri Lulus</p>
                <p class="text-3xl font-bold text-gray-900">{{ $graduatedStudents }}</p>
            </div>
        </div>
    </div>

    <!-- Charts and recent students -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 chart-container">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Perbandingan Data</h2>
            <div class="relative h-80">
                <canvas id="dataComparisonChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 chart-container">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Santri Terbaru</h2>
            <ul class="divide-y divide-gray-200">
                @forelse ($latestStudents as $student)
                    <li class="py-4 flex items-center">
                        @if($student->photo_url)
                            <img class="w-10 h-10 rounded-full object-cover" src="{{ $student->photo_url }}" alt="{{ $student->name }}">
                        @else
                            <div class="w-10 h-10 rounded-full flex-shrink-0 bg-indigo-500 text-white flex items-center justify-center font-bold">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">{{ $student->name }}</p>
                            <p class="text-sm text-gray-500">{{ $student->nis }}</p>
                        </div>
                    </li>
                @empty
                    <li class="py-4 text-center text-gray-500">
                        Tidak ada santri baru.
                    </li>
                @endforelse
            </ul>
            <div class="mt-6">
                <a href="{{ route('students.index') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Lihat Semua Santri
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('dataComparisonChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Santri', 'Wali Santri'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [{{ $studentCount }}, {{ $guardianCount }}],
                        backgroundColor: [
                            'rgba(79, 70, 229, 0.8)', // Indigo
                            'rgba(249, 115, 22, 0.8)' // Orange
                        ],
                        borderColor: [
                            'rgba(79, 70, 229, 1)',
                            'rgba(249, 115, 22, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                            },
                            ticks: {
                                stepSize: 10
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Perbandingan Jumlah Santri dan Wali Santri',
                            font: {
                                size: 18,
                                family: 'Inter', 
                                weight: 'bold'
                            },
                            color: '#374151'
                        }
                    }
                }
            });
        });
    </script>
@endpush
