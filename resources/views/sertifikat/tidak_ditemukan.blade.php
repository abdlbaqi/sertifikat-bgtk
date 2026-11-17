@extends('layouts.app')

@section('title', 'Sertifikat Tidak Ditemukan - BGTK Provinsi Lampung')

@section('content')
<div class="py-16 bg-slate-50">
    <div class="max-w-xl mx-auto px-4 text-center">
        <div class="w-20 h-20 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <span class="text-xs font-bold uppercase tracking-widest text-rose-600">Peringatan Keaslian Dokumen</span>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2 mb-3">
            Sertifikat Tidak Terdaftar!
        </h1>

        <p class="text-slate-600 text-sm leading-relaxed mb-6">
            Nomor sertifikat atau kode verifikasi <strong class="text-slate-900 font-mono">"{{ $kode }}"</strong> tidak ditemukan pada pangkalan data resmi Balai Guru dan Tenaga Kependidikan Provinsi Lampung.
        </p>

        <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs text-left mb-8">
            <div class="font-bold mb-1 flex items-center gap-1.5">
                <i class="fa-solid fa-circle-info"></i> Kemungkinan Penyebab:
            </div>
            <ul class="list-disc list-inside space-y-1 text-slate-700">
                <li>Sertifikat belum diterbitkan atau masih dalam proses rekapitulasi data panitia.</li>
                <li>Terjadi kesalahan ketik pada saat memasukkan kode verifikasi atau nomor sertifikat.</li>
                <li>Dokumen tidak diterbitkan secara resmi oleh BGTK Provinsi Lampung.</li>
            </ul>
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-3">
            <a href="{{ route('sertifikat.beranda') }}#cari" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-bgtk-700 hover:bg-bgtk-800 text-white font-semibold text-xs shadow-sm transition gap-2">
                <i class="fa-solid fa-magnifying-glass"></i> Cari Kembali
            </a>
            <a href="{{ route('sertifikat.beranda') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-xs border border-slate-200 transition">
                Ke Halaman Utama
            </a>
        </div>
    </div>
</div>
@endsection

