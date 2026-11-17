@extends('layouts.app')

@section('title', 'Verifikasi Sertifikat: ' . $sertifikat->nomor_sertifikat . ' — BGTK Lampung')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-6">

    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('sertifikat.beranda') }}" class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-slate-900 transition gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- Card Utama Verifikasi -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl shadow-slate-200/40 overflow-hidden">
        
        <!-- Header Status -->
        @if($sertifikat->status === 'aktif')
        <div class="p-8 sm:p-10 text-center border-b border-slate-100 bg-gradient-to-b from-slate-50 to-white">
            <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 text-2xl border border-emerald-200 shadow-xs">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold uppercase tracking-wider border border-emerald-200 mb-2">
                <span>Dokumen Sah & Terverifikasi</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-950">
                Sertifikat Resmi BGTK Lampung
            </h1>
            <p class="text-xs text-slate-500 mt-2 max-w-lg mx-auto leading-relaxed">
                Dokumen elektronik ini telah diperiksa secara kriptografis dan terdaftar resmi pada pangkalan data Balai Guru dan Tenaga Kependidikan Provinsi Lampung.
            </p>
        </div>
        @else
        <div class="p-8 sm:p-10 text-center border-b border-slate-100 bg-rose-50/50">
            <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-ban"></i>
            </div>
            <h1 class="text-2xl font-black text-rose-900">
                Sertifikat Tidak Berlaku / Dicabut
            </h1>
            <p class="text-xs text-rose-700 mt-1 max-w-md mx-auto">
                Alasan: {{ $sertifikat->alasan_dicabut ?? 'Dokumen telah ditarik atau mengalami revisi.' }}
            </p>
        </div>
        @endif

        <!-- Rincian Data -->
        <div class="p-6 sm:p-10 space-y-8">
            
            <!-- Bar Nomor & Token ID -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nomor Registrasi:</span>
                    <div class="font-mono text-sm sm:text-base font-bold text-slate-900">{{ $sertifikat->nomor_sertifikat }}</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 block">Kode Token:</span>
                        <span class="font-mono text-xs font-bold text-slate-800">{{ $sertifikat->kode_verifikasi }}</span>
                    </div>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                </div>
            </div>

            <!-- Identitas Penerima -->
            <div class="space-y-3">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Identitas Penerima Sertifikat</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-2xl border border-slate-200/80 bg-white">
                        <div class="text-[10px] text-slate-400">Nama Lengkap & Gelar</div>
                        <div class="text-base font-extrabold text-slate-950 mt-1">{{ $sertifikat->nama_peserta }}</div>
                    </div>
                    <div class="p-4 rounded-2xl border border-slate-200/80 bg-white">
                        <div class="text-[10px] text-slate-400">NIP / NUPTK / NIK</div>
                        <div class="text-base font-bold text-slate-900 mt-1 font-mono">{{ $sertifikat->nomor_identitas ?? '-' }}</div>
                    </div>
                    <div class="p-4 rounded-2xl border border-slate-200/80 bg-white">
                        <div class="text-[10px] text-slate-400">Instansi / Unit Kerja</div>
                        <div class="font-bold text-slate-900 mt-1">{{ $sertifikat->instansi ?? '-' }}</div>
                    </div>
                    <div class="p-4 rounded-2xl border border-slate-200/80 bg-white">
                        <div class="text-[10px] text-slate-400">Kabupaten / Kota</div>
                        <div class="font-bold text-slate-900 mt-1">{{ $sertifikat->kabupaten_kota ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Kegiatan Diklat -->
            <div class="space-y-3">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Kegiatan Pelatihan / Diklat</span>
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <h3 class="text-base font-bold text-slate-950">{{ $sertifikat->kegiatan->nama_kegiatan }}</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-slate-200/60 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[10px]">Jenis Kegiatan:</span>
                            <strong class="text-slate-900">{{ $sertifikat->kegiatan->jenis_kegiatan }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px]">Beban Pelatihan:</span>
                            <strong class="text-slate-950">{{ $sertifikat->kegiatan->jumlah_jam ?? '-' }} Jam Pelajaran (JP)</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px]">Waktu Pelaksanaan:</span>
                            <strong class="text-slate-900">
                                {{ $sertifikat->kegiatan->tanggal_mulai ? $sertifikat->kegiatan->tanggal_mulai->format('d M Y') : '-' }} s/d 
                                {{ $sertifikat->kegiatan->tanggal_selesai ? $sertifikat->kegiatan->tanggal_selesai->format('d M Y') : '-' }}
                            </strong>
                        </div>
                    </div>

                    <!-- Struktur Program jika ada -->
                    @if($sertifikat->kegiatan->materi && $sertifikat->kegiatan->materi->count() > 0)
                    <div class="mt-4 pt-4 border-t border-slate-200/60">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Struktur Program Pelatihan:</span>
                        <div class="border border-slate-200 rounded-xl overflow-hidden bg-white text-xs">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 text-[10px]">
                                    <tr>
                                        <th class="p-2 w-8 text-center">No</th>
                                        <th class="p-2">Materi Pokok</th>
                                        <th class="p-2 w-16 text-center">JP</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($sertifikat->kegiatan->materi as $idx => $m)
                                    <tr>
                                        <td class="p-2 text-center text-slate-400">{{ $idx + 1 }}</td>
                                        <td class="p-2 font-medium text-slate-800">{{ $m->nama_materi }}</td>
                                        <td class="p-2 text-center font-bold text-slate-900">{{ $m->jumlah_jam }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pejabat Penandatangan -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 text-xs">
                <div>
                    <span class="text-[10px] text-slate-400 block">Ditandatangani secara elektronik oleh:</span>
                    <div class="font-bold text-slate-950">{{ $sertifikat->kegiatan->nama_penandatangan ?? 'Kepala Balai BGTK Lampung' }}</div>
                    <div class="text-slate-500 text-[11px]">NIP. {{ $sertifikat->kegiatan->nip_penandatangan ?? '-' }}</div>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-slate-400 block">Tanggal Pengesahan:</span>
                    <strong class="text-slate-900">
                        {{ $sertifikat->kegiatan->tanggal_sertifikat ? $sertifikat->kegiatan->tanggal_sertifikat->translatedFormat('d F Y') : '-' }}
                    </strong>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-2">
                <a 
                    href="{{ route('sertifikat.cetak', $sertifikat->kode_verifikasi) }}" 
                    target="_blank"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-full bg-slate-950 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition gap-2"
                >
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Lembar Sertifikat Resmi (A4)</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
