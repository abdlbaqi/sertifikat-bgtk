<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BGTK Lampung — Platform Sertifikat Guru & Tenaga Kependidikan')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            900: '#0f172a',
                            950: '#020617',
                        },
                        bgtk: {
                            500: '#0284c7',
                            600: '#0369a1',
                            700: '#075985',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: #0f172a;
        }

        /* Subtle grid background */
        .bg-grid-subtle {
            background-size: 32px 32px;
            background-image: 
                linear-gradient(to right, rgba(0, 0, 0, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
        }

        /* Subtle glow radial */
        .ambient-glow {
            background: radial-gradient(circle at 50% 30%, rgba(59, 130, 246, 0.08) 0%, rgba(243, 244, 246, 0) 65%);
        }

        /* Keyframe floating animations */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        @keyframes float-reverse {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(8px); }
        }
        .animate-float {
            animation: float-slow 5s ease-in-out infinite;
        }
        .animate-float-reverse {
            animation: float-reverse 6s ease-in-out infinite;
        }
    </style>
    @yield('extra-head')
</head>
<body class="bg-white text-slate-900 flex flex-col min-h-screen antialiased selection:bg-slate-900 selection:text-white">

    <!-- TOP FLOATING NAVBAR (Modern SaaS Pill Design) -->
    <div class="fixed top-0 inset-x-0 z-50 px-4 sm:px-6 lg:px-8 pt-4 pb-2 pointer-events-none">
        <header class="max-w-6xl mx-auto bg-white/80 backdrop-blur-md rounded-full border border-slate-200/80 shadow-xs shadow-slate-200/50 px-5 sm:px-6 h-14 flex items-center justify-between pointer-events-auto transition-all">
            
            <!-- Brand Logo (Minimalist Geometric Mark) -->
            <a href="{{ route('sertifikat.beranda') }}" class="flex items-center space-x-2.5 group">
                <div class="w-8 h-8 rounded-full bg-slate-950 text-white flex items-center justify-center font-bold text-xs group-hover:scale-105 transition-transform shadow-xs">
                    <span class="text-sm">❖</span>
                </div>
                <div class="flex items-baseline space-x-1.5">
                    <span class="font-black text-sm tracking-tight text-slate-950">bgtk</span>
                    <span class="text-xs font-semibold text-slate-400">lampung</span>
                </div>
            </a>

            <!-- Nav Links (Center Pill Menu) -->
            <nav class="hidden md:flex items-center space-x-1 text-xs font-semibold text-slate-600">
                <a href="{{ route('sertifikat.beranda') }}" class="px-3.5 py-1.5 rounded-full hover:text-slate-950 hover:bg-slate-100 transition {{ request()->routeIs('sertifikat.beranda') && !request()->has('q') ? 'text-slate-950 font-bold' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('sertifikat.beranda') }}#cari" class="px-3.5 py-1.5 rounded-full hover:text-slate-950 hover:bg-slate-100 transition">
                    Cek Sertifikat
                </a>
                <a href="{{ route('sertifikat.beranda') }}#fitur" class="px-3.5 py-1.5 rounded-full hover:text-slate-950 hover:bg-slate-100 transition">
                    Fitur Platform
                </a>
                <a href="{{ route('sertifikat.beranda') }}#kegiatan" class="px-3.5 py-1.5 rounded-full hover:text-slate-950 hover:bg-slate-100 transition">
                    Agenda Bimtek
                </a>
            </nav>

            <!-- Action Button (Sleek Dark Pill Button) -->
            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-4 py-1.5 rounded-full bg-slate-950 hover:bg-slate-800 text-white text-xs font-semibold shadow-xs transition gap-1.5">
                        <i class="fa-solid fa-gauge text-[10px]"></i>
                        <span>Admin Panel</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-1.5 rounded-full bg-slate-950 hover:bg-slate-800 text-white text-xs font-semibold shadow-xs transition gap-1.5">
                        <i class="fa-solid fa-lock text-[10px]"></i>
                        <span>Sign In</span>
                    </a>
                @endauth
            </div>
        </header>
    </div>

    <!-- MAIN CONTENT -->
    <main class="flex-grow pt-16">
        @yield('content')
    </main>

    <!-- MODERN MINIMALIST FOOTER -->
    <footer class="border-t border-slate-100 bg-white text-slate-600 text-xs py-14 mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-slate-100">
                <div class="md:col-span-5 space-y-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-7 h-7 rounded-full bg-slate-950 text-white flex items-center justify-center font-bold text-xs">
                            <span>❖</span>
                        </div>
                        <span class="font-extrabold text-sm tracking-tight text-slate-900">BGTK Provinsi Lampung</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed max-w-sm">
                        Balai Guru dan Tenaga Kependidikan Provinsi Lampung — Unit Pelaksana Teknis Kementerian Pendidikan Dasar dan Menengah RI dalam pengembangan kompetensi guru.
                    </p>
                    <div class="text-[11px] text-slate-400 pt-1">
                        Jl. Gatot Subroto No. 44, Pahoman, Kota Bandar Lampung 35222
                    </div>
                </div>

                <div class="md:col-span-2 space-y-2.5">
                    <div class="font-bold text-slate-900 text-xs uppercase tracking-wider">Layanan</div>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('sertifikat.beranda') }}#cari" class="hover:text-slate-950 transition">Cari Sertifikat</a></li>
                        <li><a href="{{ route('sertifikat.beranda') }}#kegiatan" class="hover:text-slate-950 transition">Jadwal Bimtek</a></li>
                        <li><a href="{{ route('sertifikat.beranda') }}#fitur" class="hover:text-slate-950 transition">Validasi QR</a></li>
                    </ul>
                </div>

                <div class="md:col-span-2 space-y-2.5">
                    <div class="font-bold text-slate-900 text-xs uppercase tracking-wider">Instansi</div>
                    <ul class="space-y-2 text-xs">
                        <li><a href="https://kemdikbud.go.id" target="_blank" class="hover:text-slate-950 transition">Kemendikdasmen</a></li>
                        <li><a href="https://gtk.kemdikbud.go.id" target="_blank" class="hover:text-slate-950 transition">Ditjen GTK</a></li>
                        <li><a href="https://gurupenggerak.kemdikbud.go.id" target="_blank" class="hover:text-slate-950 transition">Guru Penggerak</a></li>
                    </ul>
                </div>

                <div class="md:col-span-3 space-y-3">
                    <div class="font-bold text-slate-900 text-xs uppercase tracking-wider">Keamanan Digital</div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Dokumen sertifikat elektronik diterbitkan dengan hash kriptografis unik dan barcode QR dinamis yang dapat diverifikasi kapan saja.
                    </p>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-50 border border-slate-200 text-[11px] text-slate-700 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Sistem Aktif 24/7 Terverifikasi</span>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-[11px] text-slate-400 gap-4">
                <div>&copy; {{ date('Y') }} BGTK Provinsi Lampung. All rights reserved.</div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('login') }}" class="hover:text-slate-900 transition">Administrator</a>
                    <span>•</span>
                    <span>Provinsi Lampung</span>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
