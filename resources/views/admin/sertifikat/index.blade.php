@extends('layouts.admin')

@section('title', 'Data Sertifikat Peserta - BGTK Provinsi Lampung')
@section('page-title', 'Data Sertifikat Peserta')

@section('content')
<div class="space-y-6">

    <!-- Header & Aksi Cepat -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900">Penerbitan Sertifikat Peserta</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Kelola sertifikat guru dan tenaga kependidikan. Anda bisa memasukkan ratusan nama sekaligus atau mencetak semuanya dalam 1 berkas.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2">
                <!-- Tombol Input Masal Sekaligus (Fitur Utama) -->
                <a 
                    href="{{ route('admin.sertifikat.generator') }}" 
                    class="inline-flex items-center px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-md transition gap-2 shrink-0"
                >
                    <i class="fa-solid fa-bolt"></i>
                    <span>Input Nama Sekaligus (Masal)</span>
                </a>

                <!-- Tombol Cetak Semua Sekaligus Jika Kegiatan Dipilih -->
                @if($kegiatanId)
                <a 
                    href="{{ route('admin.kegiatan.cetak-masal', $kegiatanId) }}" 
                    target="_blank"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl bg-slate-950 hover:bg-slate-800 text-white font-bold text-xs shadow-sm transition gap-1.5 shrink-0"
                >
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Semua (PDF Masal)</span>
                </a>
                @endif

                <a 
                    href="{{ route('admin.sertifikat.create') }}" 
                    class="inline-flex items-center px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition gap-1.5 shrink-0"
                >
                    <i class="fa-solid fa-plus"></i>
                    <span>Input 1 Orang</span>
                </a>
            </div>
        </div>

        <!-- Form Filter & Pencarian -->
        <form action="{{ route('admin.sertifikat.index') }}" method="GET" class="pt-4 border-t border-slate-100 flex flex-col md:flex-row gap-3">
            <div class="flex-grow">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $q }}" 
                    placeholder="Cari berdasarkan nama peserta, NIP, no. sertifikat..." 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-bgtk-600 outline-none"
                >
            </div>

            <div class="w-full md:w-80">
                <select name="kegiatan_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-bgtk-600 outline-none font-medium" onchange="this.form.submit()">
                    <option value="">-- Semua Kegiatan Pelatihan --</option>
                    @foreach($daftarKegiatan as $dk)
                    <option value="{{ $dk->id }}" {{ $kegiatanId == $dk->id ? 'selected' : '' }}>
                        {{ Str::limit($dk->nama_kegiatan, 42) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition">
                    Filter
                </button>
                @if($q || $kegiatanId)
                <a href="{{ route('admin.sertifikat.index') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold flex items-center justify-center">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Data Sertifikat -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4">Identitas Peserta</th>
                        <th class="p-4">Nomor & Token QR</th>
                        <th class="p-4">Kegiatan Diklat</th>
                        <th class="p-4">Asal Instansi</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Unduhan</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($sertifikat as $s)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4">
                            <div class="font-bold text-slate-900 text-sm">{{ $s->nama_peserta }}</div>
                            <div class="text-[11px] text-slate-500">NIP: {{ $s->nomor_identitas ?? '-' }}</div>
                            <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[9px] font-bold uppercase bg-slate-100 text-slate-700">
                                {{ $s->peran }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="font-mono text-xs font-bold text-slate-900">{{ $s->nomor_sertifikat }}</div>
                            <div class="font-mono text-[11px] text-bgtk-700 font-semibold">ID: {{ $s->kode_verifikasi }}</div>
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-slate-800 max-w-xs truncate">{{ $s->kegiatan->nama_kegiatan }}</div>
                            <div class="text-[11px] text-slate-400">{{ $s->kegiatan->jenis_kegiatan }} • {{ $s->kegiatan->jumlah_jam ?? '-' }} JP</div>
                        </td>
                        <td class="p-4">
                            <div class="font-medium text-slate-800">{{ $s->instansi ?? '-' }}</div>
                            <div class="text-[11px] text-slate-400">{{ $s->kabupaten_kota ?? '-' }}</div>
                        </td>
                        <td class="p-4 text-center">
                            @if($s->status === 'aktif')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Dicabut</span>
                            @endif
                        </td>
                        <td class="p-4 text-center font-bold text-slate-700">
                            {{ $s->jumlah_unduh }}x
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end space-x-1.5">
                                <a href="{{ route('sertifikat.cetak', $s->kode_verifikasi) }}" target="_blank" class="p-2 rounded-lg bg-bgtk-50 hover:bg-bgtk-100 text-bgtk-700 transition" title="Lihat & Cetak Lembar Sertifikat">
                                    <i class="fa-solid fa-print"></i>
                                </a>
                                <a href="{{ route('sertifikat.verifikasi', $s->kode_verifikasi) }}" target="_blank" class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="Buka Halaman Verifikasi QR">
                                    <i class="fa-solid fa-qrcode"></i>
                                </a>
                                <a href="{{ route('admin.sertifikat.edit', $s->id) }}" class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.sertifikat.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus sertifikat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 transition" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400">
                            Tidak ditemukan data sertifikat yang sesuai kriteria pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sertifikat->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $sertifikat->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
