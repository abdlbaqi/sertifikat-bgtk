<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - BGTK Provinsi Lampung</title>

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
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-tr from-slate-900 via-bgtk-900 to-slate-900 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Ornamen Latar Belakang -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-bgtk-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-emas-500/10 blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">

        <!-- Tombol Kembali ke Beranda -->
        <div class="mb-4 text-center">
            <a href="{{ route('sertifikat.beranda') }}" class="inline-flex items-center text-xs font-semibold text-slate-300 hover:text-white transition gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Portal Pencarian Publik
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden">
            <!-- Header Brand -->
            <div class="bg-gradient-to-r from-bgtk-900 to-bgtk-800 text-white p-6 sm:p-8 text-center relative">
                <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-emas-400 text-2xl border border-white/20 shadow-inner">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="text-[10px] uppercase font-bold tracking-widest text-slate-300">
                    Panel Admin Kedinasan
                </div>
                <h1 class="text-xl sm:text-2xl font-black mt-1">
                    BGTK PROVINSI LAMPUNG
                </h1>
                <p class="text-xs text-slate-300 mt-1">
                    Sistem Manajemen & CMS Template E-Sertifikat
                </p>
            </div>

            <!-- Form Body -->
            <div class="p-6 sm:p-8">

                <!-- Alert Error -->
                @if($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                @if(session('sukses'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('sukses') }}</span>
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Alamat Email Admin
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input 
                                type="email" 
                                id="emailInput"
                                name="email" 
                                value="{{ old('email', 'admin@bgtklampung.go.id') }}" 
                                placeholder="nama@bgtklampung.go.id" 
                                class="w-full pl-9 pr-4 py-3 rounded-xl border border-slate-200 text-xs font-medium focus:border-bgtk-600 focus:ring-4 focus:ring-bgtk-500/10 outline-none transition"
                                required
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                                <i class="fa-solid fa-key"></i>
                            </span>
                            <input 
                                type="password" 
                                id="passwordInput"
                                name="password" 
                                value="password123"
                                placeholder="Masukkan kata sandi..." 
                                class="w-full pl-9 pr-10 py-3 rounded-xl border border-slate-200 text-xs font-medium focus:border-bgtk-600 focus:ring-4 focus:ring-bgtk-500/10 outline-none transition"
                                required
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility()" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 text-xs"
                            >
                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center space-x-2 cursor-pointer text-slate-600">
                            <input type="checkbox" name="remember" checked class="w-4 h-4 text-bgtk-600 rounded">
                            <span>Ingat sesi saya</span>
                        </label>
                        <span class="text-slate-400 font-mono text-[11px]">BGTK-AUTH v1</span>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3.5 rounded-xl bg-gradient-to-r from-bgtk-700 to-bgtk-900 hover:from-bgtk-800 hover:to-slate-900 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-bgtk-900/30 transition flex items-center justify-center gap-2 mt-2"
                    >
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>Masuk ke Panel Admin</span>
                    </button>
                </form>

                <!-- Box Demo Akun -->
                <div class="mt-6 pt-5 border-t border-slate-100 bg-slate-50 p-3.5 rounded-2xl text-xs text-slate-600 space-y-1.5">
                    <div class="font-bold text-slate-800 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-key text-amber-500"></i> Akun Bawaan BGTK:
                        </span>
                        <button type="button" onclick="isiDemo()" class="text-[10px] font-bold text-bgtk-700 hover:underline">
                            Gunakan Akun Ini
                        </button>
                    </div>
                    <div class="text-[11px] font-mono text-slate-600">
                        Email: <strong>admin@bgtklampung.go.id</strong><br>
                        Password: <strong>password123</strong>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-center text-xs text-slate-400 mt-6">
            &copy; {{ date('Y') }} Balai Guru dan Tenaga Kependidikan Provinsi Lampung
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const p = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (p.type === 'password') {
                p.type = 'text';
                icon.className = 'fa-solid fa-eye-slash';
            } else {
                p.type = 'password';
                icon.className = 'fa-solid fa-eye';
            }
        }

        function isiDemo() {
            document.getElementById('emailInput').value = 'admin@bgtklampung.go.id';
            document.getElementById('passwordInput').value = 'password123';
        }
    </script>
</body>
</html>

