@extends('layouts.admin')

@section('title', ($isEdit ? 'Edit Kegiatan: ' . $kegiatan->nama_kegiatan : 'Tambah Kegiatan Baru') . ' - BGTK Lampung')
@section('page-title', $isEdit ? 'Edit Kegiatan Pelatihan' : 'Tambah Kegiatan Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="mb-4">
        <a href="{{ route('admin.kegiatan.index') }}" class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-bgtk-700 transition gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Kegiatan
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10">
        <div class="mb-8 pb-4 border-b border-slate-200">
            <h1 class="text-xl sm:text-2xl font-black text-slate-900">
                {{ $isEdit ? 'Perbarui Data Kegiatan' : 'Formulir Kegiatan Pelatihan Baru' }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Lengkapi rincian pelatihan, pilih template desain sertifikat CMS, dan nama pejabat penandatangan.
            </p>
        </div>

        <form action="{{ $isEdit ? route('admin.kegiatan.update', $kegiatan->id) : route('admin.kegiatan.store') }}" method="POST" class="space-y-6">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- Nama & Kode Kegiatan -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kegiatan / Pelatihan <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        name="nama_kegiatan" 
                        value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" 
                        placeholder="Contoh: Bimbingan Teknis Implementasi Pembelajaran Berdiferensiasi" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none"
                        required
                    >
                    @error('nama_kegiatan') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Kegiatan <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        name="kode_kegiatan" 
                        value="{{ old('kode_kegiatan', $kegiatan->kode_kegiatan ?? 'BGTK-' . date('Y') . '-BIMTEK-' . rand(10,99)) }}" 
                        placeholder="BGTK-2026-BIMTEK-01" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-mono focus:border-bgtk-600 outline-none uppercase"
                        required
                    >
                    @error('kode_kegiatan') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Jenis Kegiatan & Pilihan Template CMS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Kegiatan</label>
                    <select name="jenis_kegiatan" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none">
                        <option value="Bimtek" {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) === 'Bimtek' ? 'selected' : '' }}>Bimbingan Teknis (Bimtek)</option>
                        <option value="Diklat" {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) === 'Diklat' ? 'selected' : '' }}>Pendidikan & Pelatihan (Diklat)</option>
                        <option value="Lokakarya" {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) === 'Lokakarya' ? 'selected' : '' }}>Lokakarya Guru Penggerak</option>
                        <option value="Webinar" {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) === 'Webinar' ? 'selected' : '' }}>Webinar Nasional / Seri Guru</option>
                        <option value="Pelatihan" {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) === 'Pelatihan' ? 'selected' : '' }}>Pelatihan Mandiri</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Template Desain Sertifikat (CMS)</label>
                    <select name="template_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none">
                        <option value="">-- Gunakan Template Standar --</option>
                        @foreach($templates as $t)
                        <option value="{{ $t->id }}" {{ old('template_id', $kegiatan->template_id) == $t->id ? 'selected' : '' }}>
                            {{ $t->nama_template }} ({{ $t->orientasi }})
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tanggal & Jam Pelajaran (JP) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Mulai <span class="text-rose-500">*</span></label>
                    <input 
                        type="date" 
                        name="tanggal_mulai" 
                        value="{{ old('tanggal_mulai', $kegiatan->tanggal_mulai ? $kegiatan->tanggal_mulai->format('Y-m-d') : date('Y-m-d')) }}" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Selesai <span class="text-rose-500">*</span></label>
                    <input 
                        type="date" 
                        name="tanggal_selesai" 
                        value="{{ old('tanggal_selesai', $kegiatan->tanggal_selesai ? $kegiatan->tanggal_selesai->format('Y-m-d') : date('Y-m-d')) }}" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jumlah Jam Pelajaran (JP)</label>
                    <input 
                        type="number" 
                        name="jumlah_jam" 
                        value="{{ old('jumlah_jam', $kegiatan->jumlah_jam ?? 32) }}" 
                        placeholder="Contoh: 32" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none"
                    >
                </div>
            </div>

            <!-- Pejabat Penandatangan Sertifikat -->
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                <span class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Pejabat Penandatangan Sertifikat</span>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Nama Lengkap & Gelar Pejabat</label>
                        <input 
                            type="text" 
                            name="nama_penandatangan" 
                            value="{{ old('nama_penandatangan', $kegiatan->nama_penandatangan ?? 'Dr. H. Ahmad Fauzan, M.Pd.') }}" 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-bgtk-600 outline-none"
                        >
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">NIP Pejabat</label>
                        <input 
                            type="text" 
                            name="nip_penandatangan" 
                            value="{{ old('nip_penandatangan', $kegiatan->nip_penandatangan ?? '197508142000031002') }}" 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-mono focus:border-bgtk-600 outline-none"
                        >
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Jabatan Penandatangan</label>
                        <input 
                            type="text" 
                            name="jabatan_penandatangan" 
                            value="{{ old('jabatan_penandatangan', $kegiatan->jabatan_penandatangan ?? 'Kepala Balai Guru dan Tenaga Kependidikan Provinsi Lampung') }}" 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-bgtk-600 outline-none"
                        >
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Tanggal Terbit Sertifikat</label>
                        <input 
                            type="date" 
                            name="tanggal_sertifikat" 
                            value="{{ old('tanggal_sertifikat', $kegiatan->tanggal_sertifikat ? $kegiatan->tanggal_sertifikat->format('Y-m-d') : date('Y-m-d')) }}" 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-bgtk-600 outline-none"
                        >
                    </div>

                    <div class="flex items-center pt-5">
                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs text-slate-700">
                            <input 
                                type="checkbox" 
                                name="status_terbit" 
                                value="1" 
                                {{ old('status_terbit', $kegiatan->status_terbit) ? 'checked' : '' }} 
                                class="w-4 h-4 text-bgtk-600 rounded"
                            >
                            <span class="font-bold">Terbitkan Sertifikat (Bisa Dicari Peserta di Web Publik)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Keterangan / Deskripsi Kegiatan</label>
                <textarea 
                    name="deskripsi" 
                    rows="3" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs focus:border-bgtk-600 outline-none"
                    placeholder="Tuliskan tujuan peningkatan kompetensi dan rincian pelatihan..."
                >{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
            </div>

            <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.kegiatan.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-bgtk-700 hover:bg-bgtk-800 text-white font-bold text-xs shadow-sm transition">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Buat Kegiatan' }}
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

