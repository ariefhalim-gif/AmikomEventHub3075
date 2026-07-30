<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'AmikomEventHub - Platform Tiket Event Kampus')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom Tailwind Configuration & Styles -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        amikom: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                        accent: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        .toast-animate {
            animation: slideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 border-b border-slate-200/80 glass-nav transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- LOGO & BRANDING -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amikom-900 to-amikom-700 text-amber-400 flex items-center justify-center font-extrabold text-xl shadow-md shadow-amikom-900/20 group-hover:scale-105 transition-transform">
                        AH
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-extrabold text-lg tracking-tight text-slate-900">Amikom</span>
                            <span class="font-extrabold text-lg tracking-tight text-amikom-700">EventHub</span>
                        </div>
                        <p class="text-[10px] uppercase tracking-wider font-semibold text-slate-400 -mt-1">Official Student Events</p>
                    </div>
                </a>

                <!-- DESKTOP NAVIGATION -->
                <div class="hidden md:flex items-center gap-1 font-medium text-slate-600 text-sm">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg hover:text-amikom-700 hover:bg-amikom-50 transition">
                        Beranda
                    </a>
                    <a href="#events" class="px-4 py-2 rounded-lg hover:text-amikom-700 hover:bg-amikom-50 transition">
                        Eksplor Event
                    </a>
                    @auth
                        <a href="{{ route('tickets.mine') }}" class="px-4 py-2 rounded-lg hover:text-amikom-700 hover:bg-amikom-50 transition flex items-center gap-1.5">
                            <i data-lucide="ticket" class="w-4 h-4 text-amikom-600"></i>
                            <span>Tiket Saya</span>
                        </a>
                    @endauth
                </div>

                <!-- USER AUTH / ACTION BUTTONS -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-amikom-100 text-amikom-800 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <span class="font-semibold text-sm text-slate-700">{{ Auth::user()->name }}</span>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" title="Logout" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">
                            Masuk
                        </a>

                        <a href="{{ route('register') }}" class="px-5 py-2 rounded-xl text-sm font-semibold bg-amikom-700 hover:bg-amikom-800 text-white shadow-md shadow-amikom-700/20 hover:shadow-lg transition">
                            Daftar Akun
                        </a>
                    @endauth
                </div>

                <!-- MOBILE MENU BUTTON -->
                <div class="flex md:hidden items-center">
                    <button id="mobile-menu-btn" type="button" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- MOBILE MENU DROPDOWN -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200 bg-white/95 backdrop-blur-md px-4 pt-2 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-amikom-50 hover:text-amikom-700">Beranda</a>
            <a href="#events" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-amikom-50 hover:text-amikom-700">Eksplor Event</a>
            @auth
                <a href="{{ route('tickets.mine') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-amikom-50 hover:text-amikom-700">🎫 Tiket Saya</a>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="font-semibold text-slate-800">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-4 py-1.5 rounded-lg bg-red-50 text-red-600 font-semibold text-sm hover:bg-red-100">Logout</button>
                    </form>
                </div>
            @else
                <div class="pt-4 border-t border-slate-100 grid grid-cols-2 gap-2">
                    <a href="{{ route('login') }}" class="text-center px-4 py-2 rounded-lg border border-slate-300 font-semibold text-slate-700">Masuk</a>
                    <a href="{{ route('register') }}" class="text-center px-4 py-2 rounded-lg bg-amikom-700 font-semibold text-white">Daftar</a>
                </div>
            @endauth
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-grow relative">
        @yield('content')

        <!-- TOAST NOTIFICATIONS -->
        <div class="fixed top-20 right-4 sm:right-6 z-50 space-y-3 max-w-sm w-full">
            @if (session('success'))
                <div id="toast-success" class="toast-animate flex items-center gap-3 bg-emerald-600 text-white p-4 rounded-2xl shadow-xl shadow-emerald-600/20 border border-emerald-500">
                    <i data-lucide="check-circle-2" class="w-6 h-6 shrink-0"></i>
                    <p class="text-sm font-medium leading-tight flex-grow">{{ session('success') }}</p>
                    <button onclick="document.getElementById('toast-success').remove()" class="text-emerald-200 hover:text-white">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div id="toast-error" class="toast-animate flex items-center gap-3 bg-rose-600 text-white p-4 rounded-2xl shadow-xl shadow-rose-600/20 border border-rose-500">
                    <i data-lucide="alert-circle" class="w-6 h-6 shrink-0"></i>
                    <p class="text-sm font-medium leading-tight flex-grow">{{ session('error') }}</p>
                    <button onclick="document.getElementById('toast-error').remove()" class="text-rose-200 hover:text-white">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16 grid grid-cols-1 md:grid-cols-4 gap-12">

            <!-- BRAND INFO -->
            <div class="md:col-span-2 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amikom-900 to-amikom-700 text-amber-400 flex items-center justify-center font-extrabold text-lg">
                        AH
                    </div>
                    <span class="text-2xl font-extrabold text-white">Amikom<span class="text-amikom-600">EventHub</span></span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    Pusat informasi dan pemesanan tiket resmi untuk semua seminar, workshop, kompetisi, dan acara kemahasiswaan Universitas AMIKOM Yogyakarta.
                </p>
            </div>

            <!-- QUICK LINKS -->
            <div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Navigasi Cepat</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-amber-400 transition">Beranda Utama</a></li>
                    <li><a href="#events" class="hover:text-amber-400 transition">Semua Event</a></li>
                    @auth
                        <li><a href="{{ route('tickets.mine') }}" class="hover:text-amber-400 transition">Tiket Saya</a></li>
                    @endauth
                </ul>
            </div>

            <!-- CONTACT INFO -->
            <div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Hubungi Kami</h4>
                <ul class="space-y-2.5 text-sm">
                    <li class="flex items-center gap-2"><i data-lucide="mail" class="w-4 h-4 text-amikom-600"></i> support@amikomeventhub.com</li>
                    <li class="flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4 text-amikom-600"></i> +62 812-3456-7890</li>
                    <li class="flex items-start gap-2"><i data-lucide="map-pin" class="w-4 h-4 text-amikom-600 mt-1 shrink-0"></i> Universitas AMIKOM Yogyakarta, Indonesia</li>
                </ul>
            </div>

        </div>

        <div class="border-t border-slate-800 py-6 text-center text-xs text-slate-500">
            © {{ date('Y') }} <span class="text-slate-300 font-semibold">AmikomEventHub</span>. Crafted for Amikom Students.
        </div>
    </footer>

    <!-- LUCIDE ICONS INIT & SCRIPT -->
    <script>
        // Init Icons
        lucide.createIcons();

        // Mobile Menu Toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')

</body>

</html>