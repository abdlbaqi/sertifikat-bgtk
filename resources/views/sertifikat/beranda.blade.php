@extends('layouts.app')

@section('title', 'BGTK Provinsi Lampung — Generator & Studio Template Sertifikat Masal')

@section('content')
<div class="relative overflow-hidden bg-white ambient-glow bg-grid-subtle pb-20">

    <!-- ======================================================== -->
    <!-- HERO SECTION WITH CONCENTRIC ORBITAL RINGS (DRIBBBLE UI) -->
    <!-- ======================================================== -->
    <section class="relative pt-12 sm:pt-20 pb-20 lg:pb-32 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center">
        
        <!-- CONCENTRIC ORBITAL RINGS SVG / CSS (Background Rings) -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1100px] h-[1100px] pointer-events-none z-0 flex items-center justify-center opacity-70">
            <!-- Ring 1 (Innermost) -->
            <div class="absolute w-[360px] h-[360px] rounded-full border border-slate-200/90 border-dashed"></div>
            <!-- Ring 2 -->
            <div class="absolute w-[580px] h-[580px] rounded-full border border-slate-200/80"></div>
            <!-- Ring 3 -->
            <div class="absolute w-[820px] h-[820px] rounded-full border border-slate-200/60 border-dashed"></div>
            <!-- Ring 4 (Outermost) -->
            <div class="absolute w-[1080px] h-[1080px] rounded-full border border-slate-200/40"></div>

            <!-- Floating Orbital Badges -->
            <div class="absolute top-[22%] left-[28%] w-10 h-10 rounded-full bg-white shadow-lg border border-slate-100 flex items-center justify-center text-xs animate-float" title="Kemendikdasmen">
                <span class="text-base">🎓</span>
            </div>
            <div class="absolute top-[18%] right-[30%] w-10 h-10 rounded-full bg-white shadow-lg border border-slate-100 flex items-center justify-center text-xs animate-float-reverse" title="Template Desain">
                <span class="text-base">🎨</span>
            </div>
            <div class="absolute bottom-[24%] left-[20%] w-12 h-12 rounded-full bg-white shadow-lg border border-slate-100 flex items-center justify-center text-xs animate-float font-bold text-slate-800" title="Input Sekaligus">
                <span class="text-xs">⚡ Masal</span>
            </div>
            <div class="absolute bottom-[22%] right-[22%] w-11 h-11 rounded-full bg-white shadow-lg border border-slate-100 flex items-center justify-center text-xs animate-float-reverse" title="Batch PDF Print">
                <i class="fa-solid fa-print text-slate-800 text-sm"></i>
            </div>
            <div class="absolute top-[48%] left-[12%] w-9 h-9 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-emerald-600 animate-float">
                <i class="fa-solid fa-circle-check text-xs"></i>
            </div>
            <div class="absolute top-[46%] right-[14%] w-9 h-9 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-bgtk-600 animate-float-reverse">
                <i class="fa-solid fa-palette text-xs"></i>
            </div>
        </div>

        <!-- HERO CONTENT -->
        <div class="relative z-10 max-w-3xl mx-auto space-y-6">
            
            <!-- Top Trust Pill -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-slate-200/80 shadow-xs text-xs font-semibold text-slate-600">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                <span class="font-bold text-slate-900">Studio Pembuat Sertifikat Masal</span>
                <span class="text-slate-300">|</span>
                <span>BGTK Provinsi Lampung</span>
            </div>

            <!-- Main Headline -->
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-slate-950 leading-[1.15]">
                Generator Sertifikat Masal <br class="hidden sm:inline">
                <span class="text-slate-950">& Studio Template CMS</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-slate-500 text-sm sm:text-base max-w-xl mx-auto leading-relaxed font-normal">
                Atur desain template sertifikat kedinasan, masukkan puluhan hingga ratusan nama peserta sekaligus, dan cetak masal seluruh sertifikat dalam satu berkas PDF.
            </p>

            <!-- CTA Action Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <a href="{{ route('admin.sertifikat.generator') }}" class="px-7 py-3.5 rounded-full bg-slate-950 hover:bg-slate-800 text-white font-bold text-xs shadow-lg shadow-slate-950/15 transition flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-amber-400"></i>
                    <span>Mulai Input Nama Sekaligus</span>
                </a>
                <a href="{{ route('admin.template.index') }}" class="px-7 py-3.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-900 font-semibold text-xs border border-slate-200/80 transition flex items-center gap-2">
                    <i class="fa-solid fa-palette text-slate-500"></i>
                    <span>Kelola Template CMS</span>
                </a>
            </div>

            <!-- ============================================== -->
            <!-- FLOATING CARDS (DRIBBBLE HERO CENTER)          -->
            <!-- ============================================== -->
            <div class="pt-8 pb-4 max-w-md mx-auto space-y-2.5">
                <div class="bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 flex items-center justify-between gap-3 text-left animate-float">
                    <div class="flex items-center space-x-3 truncate">
                        <div class="w-9 h-9 rounded-full bg-slate-950 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                            <i class="fa-solid fa-users text-xs text-amber-400"></i>
                        </div>
                        <div class="truncate">
                            <div class="text-xs font-bold text-slate-900 truncate">Import Sekaligus: 50 Guru</div>
                            <div class="text-[10px] text-slate-500 truncate">Bimtek Pembelajaran Berdiferensiasi • 32 JP</div>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px] border border-emerald-200 shrink-0">
                        ⚡ 1 Klik
                    </span>
                </div>

                <div class="bg-white/90 backdrop-blur-md p-3 rounded-2xl shadow-lg shadow-slate-200/40 border border-slate-100/90 flex items-center justify-between gap-3 text-left scale-95 opacity-90 animate-float-reverse">
                    <div class="flex items-center space-x-3 truncate">
                        <div class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                            <i class="fa-solid fa-print text-xs"></i>
                        </div>
                        <div class="truncate">
                            <div class="text-xs font-bold text-slate-900 truncate">Cetak Semua Sekaligus</div>
                            <div class="text-[10px] text-slate-500 truncate">Gabung dalam 1 File PDF A4 Multi-Halaman</div>
                        </div>
                    </div>
                    <span class="font-mono text-[10px] text-slate-400 font-semibold shrink-0">Batch PDF</span>
                </div>
            </div>

            <!-- KOTAK CEPAT GENERATE DI BERANDA -->
            <div class="pt-4 max-w-2xl mx-auto">
                <div class="bg-white rounded-3xl p-6 shadow-2xl shadow-slate-300/50 border border-slate-200 text-left space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                Generator Cepat
                            </span>
                            <h3 class="text-base font-bold text-slate-900 mt-1">Tempel Daftar Nama Peserta di Sini:</h3>
                        </div>
                        <a href="{{ route('admin.sertifikat.generator') }}" class="text-xs font-bold text-bgtk-700 hover:underline">
                            Buka Halaman Lengkap &rarr;
                        </a>
                    </div>

                    <form action="{{ route('admin.sertifikat.proses-masal') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kegiatan_id" value="{{ $kegiatanTerbaru->first()->id ?? 1 }}">
                        <input type="hidden" name="peran_default" value="Peserta">

                        <textarea 
                            name="data_teks" 
                            rows="4" 
                            class="w-full p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono focus:bg-white focus:border-slate-900 outline-none transition"
                            placeholder="Ahmad Fauzi, S.Pd.&#10;Siti Nurhaliza, M.Pd. | 198804152011012009 | SMAN 1 Bandar Lampung&#10;Rudi Hartono, S.Kom. | 198207192008011015 | SMPN 2 Kalianda"
                        ></textarea>

                        <div class="mt-3 flex flex-col sm:flex-row justify-between items-center gap-3">
                            <span class="text-[11px] text-slate-400">
                                Digenerate untuk: <strong>{{ $kegiatanTerbaru->first()->nama_kegiatan ?? 'Kegiatan Bimtek Terkini' }}</strong>
                            </span>
                            <button 
                                type="submit" 
                                class="w-full sm:w-auto px-6 py-2.5 rounded-full bg-slate-950 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-1.5"
                            >
                                <i class="fa-solid fa-bolt text-amber-400"></i>
                                <span>Generate Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </section>

    <!-- ======================================================== -->
    <!-- BENTO GRID SECTION: TIGA LANGKAH MUDAH                   -->
    <!-- ======================================================== -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center max-w-2xl mx-auto mb-14 space-y-2">
            <h2 class="text-3xl font-black tracking-tight text-slate-950">
                Alur Pembuatan Sertifikat Tanpa Ribet
            </h2>
            <p class="text-slate-500 text-xs sm:text-sm">
                Tiga langkah praktis panitia pelatihan BGTK Lampung untuk menerbitkan sertifikat ratusan guru.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-slate-50/70 rounded-3xl p-6 border border-slate-200/80 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-white shadow-xs border border-slate-200 flex items-center justify-center text-slate-900 font-black text-sm">
                        1
                    </div>
                    <h3 class="text-lg font-bold text-slate-950">Atur Desain Template</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pilih template kedinasan resmi atau unggah blanko background kustom hasil rancangan Canva/Photoshop di CMS Template.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-200/60">
                    <a href="{{ route('admin.template.index') }}" class="text-xs font-bold text-slate-900 hover:underline">
                        Editor Template &rarr;
                    </a>
                </div>
            </div>

            <div class="bg-slate-50/70 rounded-3xl p-6 border border-slate-200/80 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-white shadow-xs border border-slate-200 flex items-center justify-center text-slate-900 font-black text-sm">
                        2
                    </div>
                    <h3 class="text-lg font-bold text-slate-950">Masukkan Nama Sekaligus</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Salin daftar nama guru dari Excel atau WhatsApp, lalu tempel sekaligus di kotak generator. Nomor dan QR code dibuat otomatis.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-200/60">
                    <a href="{{ route('admin.sertifikat.generator') }}" class="text-xs font-bold text-slate-900 hover:underline">
                        Buka Generator &rarr;
                    </a>
                </div>
            </div>

            <div class="bg-slate-50/70 rounded-3xl p-6 border border-slate-200/80 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-white shadow-xs border border-slate-200 flex items-center justify-center text-slate-900 font-black text-sm">
                        3
                    </div>
                    <h3 class="text-lg font-bold text-slate-950">Cetak Semua (Batch PDF)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Klik tombol "Cetak Semua" untuk mencetak atau menyimpan seluruh sertifikat peserta ke dalam satu dokumen PDF multi-halaman siap pakai.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-200/60">
                    <a href="{{ route('admin.kegiatan.index') }}" class="text-xs font-bold text-slate-900 hover:underline">
                        Daftar Kegiatan &rarr;
                    </a>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection
