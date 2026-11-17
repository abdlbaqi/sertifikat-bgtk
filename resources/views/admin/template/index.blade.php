@extends('layouts.admin')

@section('title', 'CMS Template Desain Sertifikat - BGTK Lampung')
@section('page-title', 'CMS Template Desain Sertifikat')

@section('content')
<div class="space-y-6">

    <!-- Header Halaman CMS -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200">
                Content Management System (CMS)
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-2">Daftar Desain Template Sertifikat</h1>
            <p class="text-xs text-slate-500 mt-1 max-w-2xl">
                Kelola tema warna, tipografi font, dan upload gambar blanko latar belakang (Canva/Photoshop) untuk kegiatan pelatihan BGTK Lampung.
            </p>
        </div>
        <a 
            href="{{ route('admin.template.create') }}" 
            class="inline-flex items-center px-5 py-2.5 rounded-xl bg-bgtk-700 hover:bg-bgtk-800 text-white font-bold text-xs shadow-sm transition gap-2 shrink-0"
        >
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Desain Template Baru</span>
        </a>
    </div>

    <!-- Grid Template Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $tpl)
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <!-- Mini Preview Banner -->
                <div 
                    class="h-36 p-4 relative flex flex-col justify-between bg-cover bg-center" 
                    style="
                        background-color: {{ $tpl->warna_primer }}; 
                        color: #ffffff;
                        @if($tpl->file_gambar_depan)
                            background-image: url('{{ asset($tpl->file_gambar_depan) }}');
                        @endif
                    "
                >
                    <div class="flex justify-between items-center text-xs relative z-10">
                        <span class="px-2 py-0.5 rounded bg-black/40 backdrop-blur-xs text-[10px] font-mono uppercase text-white font-bold">
                            {{ $tpl->orientasi }} A4
                        </span>
                        @if($tpl->is_bawaan)
                            <span class="px-2 py-0.5 rounded bg-amber-400 text-slate-950 text-[10px] font-bold shadow-xs">
                                <i class="fa-solid fa-star text-[9px]"></i> Bawaan Sistem
                            </span>
                        @endif
                    </div>

                    <div class="text-center relative z-10 bg-black/20 backdrop-blur-xs rounded-lg py-1 px-2 mx-auto max-w-full">
                        <div class="text-[9px] tracking-widest uppercase opacity-90 font-bold">SERTIFIKAT ELEKTRONIK</div>
                        <div class="text-base font-bold truncate px-2" style="font-family: {{ $tpl->font_nama }}">
                            Nama Peserta Pelatihan
                        </div>
                    </div>

                    <div class="flex justify-between items-end text-[9px] opacity-90 relative z-10">
                        <span class="bg-black/30 px-1.5 py-0.5 rounded"><i class="fa-solid fa-qrcode"></i> QR Valid</span>
                        <span class="font-bold">BGTK Lampung</span>
                    </div>
                </div>

                <!-- Info Konten -->
                <div class="p-5 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-slate-900 text-base leading-tight">{{ $tpl->nama_template }}</h3>
                            <span class="text-xs font-mono text-slate-400">{{ $tpl->kode_template }}</span>
                        </div>
                        @if($tpl->status_aktif)
                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">Aktif</span>
                        @else
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-xs font-bold">Nonaktif</span>
                        @endif
                    </div>

                    <p class="text-xs text-slate-500 line-clamp-2">
                        {{ $tpl->deskripsi ?? 'Tidak ada keterangan tambahan.' }}
                    </p>

                    <!-- Konfigurasi Singkat -->
                    <div class="grid grid-cols-2 gap-2 text-[11px] pt-3 border-t border-slate-100 text-slate-600">
                        <div>Font Nama: <strong class="text-slate-800">{{ $tpl->font_nama }}</strong></div>
                        <div>Font Isi: <strong class="text-slate-800">{{ $tpl->font_teks }}</strong></div>
                        <div class="flex items-center gap-1.5">
                            Warna: 
                            <span class="w-3.5 h-3.5 rounded-full border border-slate-300 inline-block shadow-xs" style="background-color: {{ $tpl->warna_primer }}"></span>
                            <span class="font-mono text-[10px]">{{ $tpl->warna_primer }}</span>
                        </div>
                        <div>Dipakai: <strong class="text-bgtk-700">{{ $tpl->kegiatan_count }} Kegiatan</strong></div>
                        @if($tpl->file_gambar_depan)
                        <div class="col-span-2 text-[10px] text-amber-700 font-semibold flex items-center gap-1">
                            <i class="fa-solid fa-image"></i> Memakai Blanko Kustom
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer Aksi -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                <a href="{{ route('admin.template.edit', $tpl->id) }}" class="font-semibold text-bgtk-700 hover:text-bgtk-900 flex items-center gap-1">
                    <i class="fa-solid fa-pen-to-square"></i> Buka Visual Editor
                </a>

                @if(!$tpl->is_bawaan)
                <form action="{{ route('admin.template.destroy', $tpl->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus template ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-trash-can"></i> Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 bg-white rounded-3xl border border-slate-200">
            <i class="fa-solid fa-palette text-4xl text-slate-300 mb-3"></i>
            <h4 class="font-bold text-slate-700">Belum ada template sertifikat</h4>
            <p class="text-xs text-slate-400 mt-1">Tambahkan template desain baru untuk kegiatan pelatihan BGTK.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection
