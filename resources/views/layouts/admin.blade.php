<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - BGTK Provinsi Lampung')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bgtk: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            600: '#0369a1',
                            700: '#075985',
                            800: '#0c4a6e',
                            900: '#082f49',
                        },
                        emas: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        montserrat: ['Montserrat', 'sans-serif'],
                        cinzel: ['Cinzel', 'serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @yield('extra-head')
</head>
<body class="bg-slate-100 text-slate-800 flex h-screen overflow-hidden">

    <!-- SIDEBAR NAVIGATION -->
    <aside id="sidebar" class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shrink-0 transition-all duration-300 z-40 fixed inset-y-0 left-0 lg:static -translate-x-full lg:translate-x-0">
        <div>
            <!-- Sidebar Header Brand -->
            <div class="h-20 bg-slate-950 px-6 flex items-center justify-between border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-bgtk-700 to-bgtk-500 flex items-center justify-center text-emas-400 text-xl font-bold shadow-sm">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-bgtk-400">Panel Kelola</div>
                        <div class="text-sm font-black text-white leading-tight">BGTK LAMPUNG</div>
                    </div>
                </a>
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Menu Navigasi -->
            <div class="p-4 space-y-6">
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500 px-3 mb-2">Menu Utama</div>
                    <nav class="space-y-1">
                        <a 
                            href="{{ route('admin.dashboard') }}" 
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-bgtk-700 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }} transition"
                        >
                            <i class="fa-solid fa-chart-pie w-5 text-center text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                            <span>Dashboard Utama</span>
                        </a>

                        <a 
                            href="{{ route('admin.sertifikat.generator') }}" 
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.sertifikat.generator') ? 'bg-amber-500 text-slate-950 shadow-sm' : 'bg-slate-800/80 text-amber-300 hover:bg-slate-800 hover:text-amber-200' }} transition"
                        >
                            <i class="fa-solid fa-bolt w-5 text-center text-sm text-amber-400"></i>
                            <div class="flex-grow flex items-center justify-between">
                                <span>Generator Masal</span>
                                <span class="px-1.5 py-0.2 rounded text-[9px] bg-amber-400/20 text-amber-300 font-extrabold uppercase">Fast</span>
                            </div>
                        </a>

                        <a 
                            href="{{ route('admin.template.index') }}" 
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.template.*') ? 'bg-bgtk-700 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }} transition"
                        >
                            <i class="fa-solid fa-palette w-5 text-center text-sm {{ request()->routeIs('admin.template.*') ? 'text-emas-400' : 'text-slate-400' }}"></i>
                            <div class="flex-grow flex items-center justify-between">
                                <span>CMS Template Desain</span>
                                <span class="px-1.5 py-0.5 rounded text-[9px] bg-amber-500/20 text-amber-300 font-bold uppercase">CMS</span>
                            </div>
                        </a>

                        <a 
                            href="{{ route('admin.kegiatan.index') }}" 
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.kegiatan.*') ? 'bg-bgtk-700 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }} transition"
                        >
                            <i class="fa-solid fa-graduation-cap w-5 text-center text-sm {{ request()->routeIs('admin.kegiatan.*') ? 'text-white' : 'text-slate-400' }}"></i>
                            <span>Kelola Kegiatan Diklat</span>
                        </a>

                        <a 
                            href="{{ route('admin.sertifikat.index') }}" 
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.sertifikat.*') ? 'bg-bgtk-700 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }} transition"
                        >
                            <i class="fa-solid fa-file-shield w-5 text-center text-sm {{ request()->routeIs('admin.sertifikat.*') ? 'text-white' : 'text-slate-400' }}"></i>
                            <span>Data Sertifikat Peserta</span>
                        </a>
                    </nav>
                </div>

                <div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500 px-3 mb-2">Tautan Luar</div>
                    <nav class="space-y-1">
                        <a 
                            href="{{ route('sertifikat.beranda') }}" 
                            target="_blank"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-medium hover:bg-slate-800 hover:text-white transition"
                        >
                            <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center text-xs text-slate-400"></i>
                            <span>Buka Portal Publik</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Sidebar Footer Profil & Logout -->
        <div class="p-4 bg-slate-950 border-t border-slate-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 truncate">
                    <div class="w-9 h-9 rounded-full bg-bgtk-800 border border-bgtk-600 flex items-center justify-center text-white font-bold text-xs uppercase">
                        {{ substr(Auth::user()->name ?? 'Admin', 0, 2) }}
                    </div>
                    <div class="truncate">
                        <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
                        <div class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email ?? 'admin@bgtklampung.go.id' }}</div>
                    </div>
                </div>

                <!-- Form Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Keluar / Logout" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-rose-900/60 text-slate-400 hover:text-rose-300 flex items-center justify-center transition">
                        <i class="fa-solid fa-power-off text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="flex-grow flex flex-col min-w-0 overflow-hidden">
        
        <!-- TOPBAR -->
        <header class="h-20 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between shrink-0 z-30">
            <div class="flex items-center space-x-3">
                <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700">
                    <i class="fa-solid fa-bars text-base"></i>
                </button>
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 leading-tight">@yield('page-title', 'Dashboard Panel')</h2>
                    <div class="text-xs text-slate-500 font-medium">Balai Guru dan Tenaga Kependidikan Provinsi Lampung</div>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Status Keamanan -->
                <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold">
                    <i class="fa-solid fa-shield-halved text-xs"></i> Admin Terautentikasi
                </span>

                <!-- Quick Logout Button -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-700 hover:text-rose-700 text-xs font-bold transition">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- FLASH NOTIFIKASI -->
        @if(session('sukses'))
        <div class="px-4 sm:px-8 pt-4">
            <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-xs">
                <div class="flex items-center space-x-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span class="font-medium">{{ session('sukses') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="px-4 sm:px-8 pt-4">
            <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center justify-between shadow-xs">
                <div class="flex items-center space-x-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
        @endif

        <!-- MAIN SCROLLABLE CONTENT -->
        <main class="flex-grow overflow-y-auto p-4 sm:p-8">
            @yield('content')
        </main>

    </div>

    <!-- Backdrop Mobile -->
    <div id="backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-950/50 backdrop-blur-xs z-30 hidden lg:hidden"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
    @yield('scripts')
</body>
</html>

