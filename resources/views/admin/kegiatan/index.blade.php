@extends('layouts.admin')

@section('title', 'Kelola Kegiatan Diklat - BGTK Provinsi Lampung')
@section('page-title', 'Kegiatan & Pelatihan Diklat')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900">Daftar Kegiatan & Pelatihan BGTK</h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola agenda Bimbingan Teknis, Lokakarya Guru Penggerak, dan Diklat yang menerbitkan sertifikat resmi.
            </p>
        </div>
        <a 
            href="{{ route('admin.kegiatan.create') }}" 
            class="inline-flex items-center px-5 py-2.5 rounded-xl bg-bgtk-700 hover:bg-bgtk-800 text-white font-bold text-xs shadow-sm transition gap-2 shrink-0"
        >
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Kegiatan Baru</span>
        </a>
    </div>

    <!-- Tabel Kegiatan -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4">Kode & Kegiatan</th>
                        <th class="p-4">Jenis & Beban</th>
                        <th class="p-4">Template Desain</th>
                        <th class="p-4">Jadwal Pelaksanaan</th>
                        <th class="p-4 text-center">Peserta</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($kegiatan as $k)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4">
                            <span class="font-mono text-[10px] font-bold text-bgtk-700 bg-bgtk-50 px-2 py-0.5 rounded border border-bgtk-200">{{ $k->kode_kegiatan }}</span>
                            <div class="font-bold text-slate-900 text-sm mt-1 max-w-md">{{ $k->nama_kegiatan }}</div>
                        </td>
                        <td class="p-4">
                            <span class="font-semibold text-slate-800">{{ $k->jenis_kegiatan }}</span>
                            <div class="text-slate-500 font-bold text-bgtk-700">{{ $k->jumlah_jam ?? '-' }} JP</div>
                        </td>
                        <td class="p-4">
                            @if($k->template)
                                <div class="flex items-center gap-1.5 font-medium text-slate-800">
                                    <span class="w-3 h-3 rounded-full border shrink-0" style="background-color: {{ $k->template->warna_primer }}"></span>
                                    <span>{{ $k->template->nama_template }}</span>
                                </div>
                            @else
                                <span class="text-slate-400 italic">Template Standar</span>
                            @endif
                        </td>
                        <td class="p-4 text-slate-600">
                            <div>{{ $k->tanggal_mulai ? $k->tanggal_mulai->format('d M Y') : '-' }}</div>
                            <div class="text-[11px] text-slate-400">s/d {{ $k->tanggal_selesai ? $k->tanggal_selesai->format('d M Y') : '-' }}</div>
                        </td>
                        <td class="p-4 text-center">
                            <a href="{{ route('admin.sertifikat.index', ['kegiatan_id' => $k->id]) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-bgtk-50 text-bgtk-800 font-bold hover:bg-bgtk-100 transition">
                                <i class="fa-solid fa-users text-[10px]"></i> {{ $k->sertifikat_count }}
                            </a>
                        </td>
                        <td class="p-4 text-center">
                            @if($k->status_terbit)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Terbit</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">Draft</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.kegiatan.edit', $k->id) }}" class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="Edit Kegiatan">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.kegiatan.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini beserta seluruh sertifikatnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 transition" title="Hapus Kegiatan">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400">
                            Belum ada kegiatan pelatihan yang tercatat. Silakan tambah kegiatan baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kegiatan->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $kegiatan->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

