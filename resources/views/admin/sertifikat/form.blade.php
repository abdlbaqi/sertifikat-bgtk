@extends('layouts.admin')

@section('title', ($isEdit ? 'Edit Sertifikat: ' . $sertifikat->nomor_sertifikat : 'Terbitkan Sertifikat Baru') . ' - BGTK Lampung')
@section('page-title', $isEdit ? 'Edit Data Sertifikat' : 'Terbitkan Sertifikat Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="mb-4">
        <a href="{{ route('admin.sertifikat.index') }}" class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-bgtk-700 transition gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Sertifikat
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10">
        <div class="mb-8 pb-4 border-b border-slate-200">
            <h1 class="text-xl sm:text-2xl font-black text-slate-900">
                {{ $isEdit ? 'Perbarui Sertifikat Peserta' : 'Terbitkan Sertifikat Peserta Baru' }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Lengkapi identitas guru/peserta pelatihan. Nomor sertifikat dan kode verifikasi QR akan digenerate otomatis jika dikosongkan.
            </p>
        </div>

        <form action="{{ $isEdit ? route('admin.sertifikat.update', $sertifikat->id) : route('admin.sertifikat.store') }}" method="POST" class="space-y-5">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- Pilih Kegiatan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kegiatan Diklat / Pelatihan <span class="text-rose-500">*</span></label>
                <select name="kegiatan_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none" required>
                    <option value="">-- Pilih Kegiatan Pelatihan --</option>
                    @foreach($daftarKegiatan as $k)
                    <option value="{{ $k->id }}" {{ old('kegiatan_id', $sertifikat->kegiatan_id) == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kegiatan }} ({{ $k->kode_kegiatan }} - {{ $k->jumlah_jam ?? 0 }} JP)
                    </option>
                    @endforeach
                </select>
                @error('kegiatan_id') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Nama Lengkap & Peran -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap & Gelar Peserta <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        name="nama_peserta" 
                        value="{{ old('nama_peserta', $sertifikat->nama_peserta) }}" 
                        placeholder="Contoh: Siti Rahmawati, S.Pd., Gr." 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none font-bold"
                        required
                    >
                    @error('nama_peserta') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Peran</label>
                    <select name="peran" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none font-semibold">
                        <option value="Peserta" {{ old('peran', $sertifikat->peran) === 'Peserta' ? 'selected' : '' }}>Peserta</option>
                        <option value="Narasumber" {{ old('peran', $sertifikat->peran) === 'Narasumber' ? 'selected' : '' }}>Narasumber</option>
                        <option value="Fasilitator" {{ old('peran', $sertifikat->peran) === 'Fasilitator' ? 'selected' : '' }}>Fasilitator</option>
                        <option value="Moderator" {{ old('peran', $sertifikat->peran) === 'Moderator' ? 'selected' : '' }}>Moderator</option>
                        <option value="Panitia" {{ old('peran', $sertifikat->peran) === 'Panitia' ? 'selected' : '' }}>Panitia</option>
                    </select>
                </div>
            </div>

            <!-- NIP & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIP / NUPTK / NIK</label>
                    <input 
                        type="text" 
                        name="nomor_identitas" 
                        value="{{ old('nomor_identitas', $sertifikat->nomor_identitas) }}" 
                        placeholder="Contoh: 198804152011012009" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-mono focus:border-bgtk-600 outline-none"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email Peserta</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $sertifikat->email) }}" 
                        placeholder="nama.guru@belajar.id" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none"
                    >
                </div>
            </div>

            <!-- Instansi & Kabupaten/Kota -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Instansi / Asal Sekolah</label>
                    <input 
                        type="text" 
                        name="instansi" 
                        value="{{ old('instansi', $sertifikat->instansi) }}" 
                        placeholder="Contoh: SMAN 1 Bandar Lampung" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kabupaten / Kota di Lampung</label>
                    <input 
                        type="text" 
                        name="kabupaten_kota" 
                        value="{{ old('kabupaten_kota', $sertifikat->kabupaten_kota) }}" 
                        placeholder="Contoh: Kota Bandar Lampung / Lampung Selatan" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none"
                    >
                </div>
            </div>

            <!-- Nomor Sertifikat Resmi -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Registrasi Sertifikat</label>
                <input 
                    type="text" 
                    name="nomor_sertifikat" 
                    value="{{ old('nomor_sertifikat', $sertifikat->nomor_sertifikat) }}" 
                    placeholder="Kosongkan untuk otomatis format BGTK Lampung (000X/BGTK-LPG/PP.01.07/2026)" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-mono focus:border-bgtk-600 outline-none"
                >
                <p class="text-[10px] text-slate-500 mt-1">Kosongkan jika ingin sistem membuat nomor secara otomatis dan berurutan.</p>
            </div>

            @if($isEdit)
            <!-- Status Sertifikat (Hanya di Edit) -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 text-xs">
                <span class="block font-bold text-slate-700 uppercase tracking-wider">Status Keabsahan Dokumen</span>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center space-x-2 cursor-pointer font-bold text-emerald-700">
                        <input type="radio" name="status" value="aktif" {{ old('status', $sertifikat->status) === 'aktif' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600">
                        <span>Aktif & Terverifikasi Sah</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer font-bold text-rose-700">
                        <input type="radio" name="status" value="dicabut" {{ old('status', $sertifikat->status) === 'dicabut' ? 'checked' : '' }} class="w-4 h-4 text-rose-600">
                        <span>Dicabut / Dibatalkan</span>
                    </label>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Alasan Pencabutan (Bila dicabut)</label>
                    <input 
                        type="text" 
                        name="alasan_dicabut" 
                        value="{{ old('alasan_dicabut', $sertifikat->alasan_dicabut) }}" 
                        placeholder="Contoh: Kesalahan identitas atau revisi nomor SK" 
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-bgtk-600 outline-none"
                    >
                </div>
            </div>
            @endif

            <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.sertifikat.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-bgtk-700 hover:bg-bgtk-800 text-white font-bold text-xs shadow-sm transition">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan Sertifikat' }}
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

