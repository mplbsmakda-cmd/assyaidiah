<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem Informasi Santri')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full font-sans antialiased text-gray-900">
    <div x-data="{ sidebarOpen: false }">
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <div x-show="sidebarOpen" class="relative z-40 md:hidden" role="dialog" aria-modal="true">
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition-opacity ease-linear duration-300" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

            <div class="fixed inset-0 z-40 flex">
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition ease-in-out duration-300 transform" 
                     x-transition:enter-start="-translate-x-full" 
                     x-transition:enter-end="translate-x-0" 
                     x-transition:leave="transition ease-in-out duration-300 transform" 
                     x-transition:leave-start="translate-x-0" 
                     x-transition:leave-end="-translate-x-full" 
                     @click.away="sidebarOpen = false" 
                     class="relative flex w-full max-w-xs flex-1 flex-col bg-indigo-700 pt-5 pb-4">
                    
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" @click="sidebarOpen = false" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex flex-shrink-0 items-center px-4">
                         <img class="h-10 w-auto" src="https://ik.imagekit.io/zco6tu2vm/assa.jpg" alt="Pondok Pesantren Assyaidiah">
                         <span class="ml-3 text-xl font-bold text-white">SISantri</span>
                    </div>
                    <div class="mt-5 h-0 flex-1 overflow-y-auto">
                        <nav class="space-y-1 px-2">
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600' }} group flex items-center rounded-md px-2 py-2 text-base font-medium">
                                <svg class="mr-4 h-6 w-6 flex-shrink-0 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600' }} group flex items-center rounded-md px-2 py-2 text-base font-medium">
                                <svg class="mr-4 h-6 w-6 flex-shrink-0 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-1.588 9.337 9.337 0 004.121-1.588c.39-1.002.39-2.003 0-3.005a9.337 9.337 0 00-4.121-1.588 9.337 9.337 0 00-4.121-1.588 9.38 9.38 0 00-2.625.372M15 19.128v-3.857M15 19.128l-2.147-2.147m2.147 2.147l-2.147 2.147M3 4.5h12M3 9h12m-6 4.5h6m-6 4.5h6" />
                                </svg>
                                Daftar Santri
                            </a>
                            <a href="{{ route('guardians.index') }}" class="{{ request()->routeIs('guardians.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600' }} group flex items-center rounded-md px-2 py-2 text-base font-medium">
                                <svg class="mr-4 h-6 w-6 flex-shrink-0 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4.125 4.125 0 00-6.354 0 4.125 4.125 0 00-1.29 4.953l.313.626a.5.5 0 01-.313.626l-1.488.744a.5.5 0 01-.626-.313 4.125 4.125 0 00-4.953-1.29 4.125 4.125 0 000 6.354 4.125 4.125 0 004.953 1.29l1.488-.744a.5.5 0 01.626.313l.313.626a4.125 4.125 0 006.354 0 4.125 4.125 0 001.29-4.953l-.313-.626a.5.5 0 01.313-.626l1.488-.744a.5.5 0 01.626.313 4.125 4.125 0 004.953 1.29 4.125 4.125 0 000-6.354 4.125 4.125 0 00-4.953-1.29l-1.488.744a.5.5 0 01-.626-.313l-.313-.626z" />
                                </svg>
                                Wali Santri
                            </a>
                        </nav>
                    </div>
                </div>
                <div class="w-14 flex-shrink-0" aria-hidden="true"></div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
            <div class="flex flex-grow flex-col overflow-y-auto bg-indigo-700 pt-5">
                <div class="flex flex-shrink-0 items-center px-4">
                     <img class="h-10 w-auto" src="https://ik.imagekit.io/zco6tu2vm/assa.jpg" alt="Pondok Pesantren Assyaidiah">
                     <span class="ml-3 text-xl font-bold text-white">SISantri</span>
                </div>
                <div class="mt-5 flex flex-1 flex-col">
                    <nav class="flex-1 space-y-1 px-2 pb-4">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                            <svg class="mr-3 h-6 w-6 flex-shrink-0 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                            <svg class="mr-3 h-6 w-6 flex-shrink-0 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-1.588 9.337 9.337 0 004.121-1.588c.39-1.002.39-2.003 0-3.005a9.337 9.337 0 00-4.121-1.588 9.337 9.337 0 00-4.121-1.588 9.38 9.38 0 00-2.625.372M15 19.128v-3.857M15 19.128l-2.147-2.147m2.147 2.147l-2.147 2.147M3 4.5h12M3 9h12m-6 4.5h6m-6 4.5h6" />
                            </svg>
                            Daftar Santri
                        </a>
                        <a href="{{ route('guardians.index') }}" class="{{ request()->routeIs('guardians.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                            <svg class="mr-3 h-6 w-6 flex-shrink-0 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4.125 4.125 0 00-6.354 0 4.125 4.125 0 00-1.29 4.953l.313.626a.5.5 0 01-.313.626l-1.488.744a.5.5 0 01-.626-.313 4.125 4.125 0 00-4.953-1.29 4.125 4.125 0 000 6.354 4.125 4.125 0 004.953 1.29l1.488-.744a.5.5 0 01.626.313l.313.626a4.125 4.125 0 006.354 0 4.125 4.125 0 001.29-4.953l-.313-.626a.5.5 0 01.313-.626l1.488-.744a.5.5 0 01.626.313 4.125 4.125 0 004.953 1.29 4.125 4.125 0 000-6.354 4.125 4.125 0 00-4.953-1.29l-1.488.744a.5.5 0 01-.626-.313l-.313-.626z" />
                            </svg>
                            Wali Santri
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="flex flex-1 flex-col md:pl-64">
            <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-white shadow">
                <button type="button" @click="sidebarOpen = true" class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <div class="flex flex-1 justify-between px-4">
                    <div class="flex flex-1 items-center">
                         <h1 class="text-xl font-bold text-gray-800">@yield('header')</h1>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <main class="flex-1">
                <div class="py-8 px-4 sm:px-6 md:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
