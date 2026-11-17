@extends('layouts.admin')

@section('title', 'Dashboard Administrator - BGTK Provinsi Lampung')
@section('page-title', 'Dashboard Utama')

@section('content')
<div class="space-y-8">

    <!-- Banner Selamat Datang -->
    <div class="bg-gradient-to-r from-bgtk-900 via-bgtk-800 to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-md relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 opacity-10 text-9xl">
            <i class="fa-solid fa-award"></i>
        </div>
        <div class="relative z-10 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-bgtk-700/60 border border-bgtk-600/50 text-xs text-emas-400 font-semibold mb-3">
                <i class="fa-solid fa-circle-check"></i> Panel Kontrol Resmi Terverifikasi
            </div>
            <h1 class="text-2xl sm:text-3xl font-black leading-tight">
                Selamat Datang, {{ Auth::user()->name }}!
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed">
                Kelola seluruh penerbitan sertifikat digital, kegiatan pelatihan/Bimtek guru, dan kustomisasi desain template CMS BGTK Provinsi Lampung dari satu tempat.
            </p>

            <div class="mt-6 flex flex-wrap gap-2.5">
                <a href="{{ route('admin.sertifikat.generator') }}" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-sm"></i>
                    <span>Input Nama Sekaligus (Generator Masal)</span>
                </a>
                <a href="{{ route('admin.kegiatan.create') }}" class="px-4 py-2.5 rounded-xl bg-bgtk-600 hover:bg-bgtk-500 text-white font-bold text-xs shadow-sm transition flex items-center gap-1.5">
                    <i class="fa-solid fa-plus"></i> Tambah Kegiatan
                </a>
                <a href="{{ route('admin.template.create') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs backdrop-blur-xs transition flex items-center gap-1.5">
                    <i class="fa-solid fa-palette"></i> Desain Template
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Kartu Statistik Metrik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-bgtk-50 text-bgtk-700 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-file-shield"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900">{{ number_format($totalSertifikat) }}</div>
                <div class="text-xs text-slate-500 font-medium">Sertifikat Aktif</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900">{{ number_format($totalKegiatan) }}</div>
                <div class="text-xs text-slate-500 font-medium">Kegiatan Diklat / Bimtek</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900">{{ number_format($totalTemplate) }}</div>
                <div class="text-xs text-slate-500 font-medium">Template Desain CMS</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-download"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900">{{ number_format($totalUnduh) }}x</div>
                <div class="text-xs text-slate-500 font-medium">Total Diunduh Peserta</div>
            </div>
        </div>
    </div>

    <!-- Bagian 2 Kolom: Kegiatan Terbaru & Template Desain -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Kolom Kiri: Kegiatan Terbaru (7/12) -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <div class="flex justify-between items-center mb-5 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Kegiatan & Pelatihan Terkini</h3>
                    <p class="text-xs text-slate-400">Daftar kegiatan Bimtek & Lokakarya BGTK Lampung</p>
                </div>
                <a href="{{ route('admin.kegiatan.index') }}" class="text-xs font-bold text-bgtk-700 hover:underline">
                    Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="space-y-3">
                @forelse($kegiatanTerbaru as $k)
                <div class="p-4 rounded-2xl bg-slate-50 hover:bg-bgtk-50/50 border border-slate-200/80 transition flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-bgtk-100 text-bgtk-800">
                                {{ $k->jenis_kegiatan }}
                            </span>
                            <span class="text-xs font-bold text-bgtk-700">{{ $k->jumlah_jam ?? '-' }} JP</span>
                            <span class="text-[11px] font-mono text-slate-400">• {{ $k->kode_kegiatan }}</span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900">{{ $k->nama_kegiatan }}</h4>
                        <div class="text-[11px] text-slate-500 flex items-center gap-3">
                            <span><i class="fa-solid fa-users mr-1 text-slate-400"></i> {{ $k->sertifikat_count }} Peserta</span>
                            <span><i class="fa-solid fa-paint-brush mr-1 text-slate-400"></i> {{ $k->template->nama_template ?? 'Template Standar' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('admin.kegiatan.edit', $k->id) }}" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-xs font-semibold text-slate-700">
                            Edit
                        </a>
                        <a href="{{ route('admin.sertifikat.index', ['kegiatan_id' => $k->id]) }}" class="px-3 py-1.5 rounded-lg bg-bgtk-700 hover:bg-bgtk-800 text-xs font-semibold text-white">
                            Peserta
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-xs text-slate-400">
                    Belum ada kegiatan pelatihan yang tercatat.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Kolom Kanan: Template CMS & Sertifikat Terbaru (5/12) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Template Desain Terkini -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900">Template Desain (CMS)</h3>
                    <a href="{{ route('admin.template.index') }}" class="text-xs font-bold text-bgtk-700 hover:underline">
                        Kelola Template <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="space-y-2.5">
                    @foreach($templates as $t)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200/80 text-xs">
                        <div class="flex items-center space-x-3 truncate">
                            <span class="w-4 h-4 rounded-full border border-slate-300 shrink-0" style="background-color: {{ $t->warna_primer }}"></span>
                            <div class="truncate">
                                <div class="font-bold text-slate-800 truncate">{{ $t->nama_template }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $t->font_nama }} • {{ $t->orientasi }}</div>
                            </div>
                        </div>
                        <a href="{{ route('admin.template.edit', $t->id) }}" class="px-2.5 py-1 rounded bg-white border border-slate-200 text-slate-600 hover:text-bgtk-700 font-semibold text-[11px] shrink-0">
                            Ubah
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Sertifikat Terakhir Diterbitkan -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900">Sertifikat Terbit Terbaru</h3>
                    <a href="{{ route('admin.sertifikat.index') }}" class="text-xs font-bold text-bgtk-700 hover:underline">
                        Semua <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="space-y-2.5">
                    @foreach($sertifikatTerbaru as $s)
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-200/60 text-xs">
                        <div class="truncate">
                            <div class="font-bold text-slate-900 truncate">{{ $s->nama_peserta }}</div>
                            <div class="text-[10px] text-slate-500 truncate">{{ $s->instansi ?? 'BGTK Lampung' }} • <span class="font-mono text-bgtk-700">{{ $s->kode_verifikasi }}</span></div>
                        </div>
                        <a href="{{ route('sertifikat.cetak', $s->kode_verifikasi) }}" target="_blank" class="text-bgtk-700 hover:text-bgtk-900 font-bold text-[11px] shrink-0 ml-2">
                            <i class="fa-solid fa-print"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

