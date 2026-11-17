@extends('layouts.admin')

@section('title', ($isEdit ? 'Edit Template: ' . $template->nama_template : 'Tambah Template Baru') . ' - BGTK Lampung')
@section('page-title', $isEdit ? 'Edit Template Sertifikat' : 'Desain Template Baru')

@section('extra-head')
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;900&family=Great+Vibes&display=swap" rel="stylesheet">
<style>
    .font-cinzel { font-family: 'Cinzel', serif; }
    .font-greatvibes { font-family: 'Great Vibes', cursive; }
    .font-playfair { font-family: 'Playfair Display', serif; }
    .font-montserrat { font-family: 'Montserrat', sans-serif; }
    .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .font-arial { font-family: Arial, sans-serif; }
</style>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Bar Atas -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <a href="{{ route('admin.template.index') }}" class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-bgtk-700 transition gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Template
        </a>
        <div class="flex items-center space-x-2 text-xs">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="font-bold text-slate-700">Live Visual Editor & Blanko Background Uploader</span>
        </div>
    </div>

        <!-- Grid 2 Kolom (Kiri: Form Input, Kanan: Live Preview) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- ============================================== -->
            <!-- KOLOM KIRI: FORM PENGATURAN TEMPLATE (5/12)   -->
            <!-- ============================================== -->
            <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8">
                <div class="mb-6 pb-4 border-b border-slate-200">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-700">Editor CMS Desain</span>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">
                        {{ $isEdit ? 'Edit Template Sertifikat' : 'Desain Template Baru' }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        Atur warna, font, dan upload gambar blanko/background sertifikat Anda di sini.
                    </p>
                </div>

                <form 
                    action="{{ $isEdit ? route('admin.template.update', $template->id) : route('admin.template.store') }}" 
                    method="POST" 
                    enctype="multipart/form-data"
                    class="space-y-5"
                >
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <!-- Nama Template -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nama Template Desain <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="inputNamaTemplate"
                            name="nama_template" 
                            value="{{ old('nama_template', $template->nama_template) }}" 
                            placeholder="Contoh: Template Diklat Guru Penggerak Angkatan 10" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 focus:ring-4 focus:ring-bgtk-500/10 outline-none transition font-medium"
                            oninput="updateLivePreview()"
                            required
                        >
                        @error('nama_template') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- ========================================== -->
                    <!-- FITUR UPLOAD GAMBAR BLANKO KERTAS          -->
                    <!-- ========================================== -->
                    <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-amber-900 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-image text-amber-600"></i> Upload Gambar Blanko Kertas
                            </span>
                            <span class="text-[10px] text-amber-700 font-medium">Format: JPG, PNG, WEBP (Max 5MB)</span>
                        </div>

                        <!-- Upload Blanko Depan -->
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">
                                1. Background Halaman Depan:
                            </label>
                            @if($template->file_gambar_depan)
                            <div class="mb-2 flex items-center gap-2 p-2 bg-white rounded-lg border border-amber-200 text-xs">
                                <img src="{{ asset($template->file_gambar_depan) }}" alt="Blanko Depan" class="w-12 h-8 object-cover rounded border">
                                <div class="flex-grow text-[11px] truncate text-slate-600 font-mono">{{ basename($template->file_gambar_depan) }}</div>
                                <label class="text-[10px] text-rose-600 font-semibold flex items-center gap-1 cursor-pointer">
                                    <input type="checkbox" name="hapus_gambar_depan" value="1" onchange="hapusBackgroundDepan(this.checked)"> Hapus
                                </label>
                            </div>
                            @endif
                            <input 
                                type="file" 
                                id="uploadGambarDepan"
                                name="file_gambar_depan" 
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 cursor-pointer"
                                onchange="previewUploadDepan(this)"
                            >
                            <p class="text-[10px] text-slate-500 mt-1">Upload gambar ornamen / border kosong tanpa teks dari Canva atau Photoshop.</p>
                        </div>

                        <!-- Upload Blanko Belakang -->
                        <div class="pt-2 border-t border-amber-200/60">
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">
                                2. Background Halaman Belakang (Struktur JP):
                            </label>
                            @if($template->file_gambar_belakang)
                            <div class="mb-2 flex items-center gap-2 p-2 bg-white rounded-lg border border-amber-200 text-xs">
                                <img src="{{ asset($template->file_gambar_belakang) }}" alt="Blanko Belakang" class="w-12 h-8 object-cover rounded border">
                                <div class="flex-grow text-[11px] truncate text-slate-600 font-mono">{{ basename($template->file_gambar_belakang) }}</div>
                                <label class="text-[10px] text-rose-600 font-semibold flex items-center gap-1 cursor-pointer">
                                    <input type="checkbox" name="hapus_gambar_belakang" value="1" onchange="hapusBackgroundBelakang(this.checked)"> Hapus
                                </label>
                            </div>
                            @endif
                            <input 
                                type="file" 
                                id="uploadGambarBelakang"
                                name="file_gambar_belakang" 
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 cursor-pointer"
                                onchange="previewUploadBelakang(this)"
                            >
                        </div>
                    </div>

                    <!-- Orientasi & Font Nama -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Orientasi Kertas</label>
                            <select 
                                id="selectOrientasi"
                                name="orientasi" 
                                class="w-full px-3.5 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none font-medium"
                                onchange="updateLivePreview()"
                            >
                                <option value="landscape" {{ old('orientasi', $template->orientasi) === 'landscape' ? 'selected' : '' }}>Landscape (A4)</option>
                                <option value="portrait" {{ old('orientasi', $template->orientasi) === 'portrait' ? 'selected' : '' }}>Portrait (A4)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Font Nama Peserta</label>
                            <select 
                                id="selectFontNama"
                                name="font_nama" 
                                class="w-full px-3.5 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none font-medium"
                                onchange="updateLivePreview()"
                            >
                                <option value="Montserrat" {{ old('font_nama', $template->font_nama) === 'Montserrat' ? 'selected' : '' }}>Montserrat (Tegas & Formal)</option>
                                <option value="Playfair Display" {{ old('font_nama', $template->font_nama) === 'Playfair Display' ? 'selected' : '' }}>Playfair Display (Klasik Elegan)</option>
                                <option value="Great Vibes" {{ old('font_nama', $template->font_nama) === 'Great Vibes' ? 'selected' : '' }}>Great Vibes (Kaligrafi)</option>
                                <option value="Cinzel" {{ old('font_nama', $template->font_nama) === 'Cinzel' ? 'selected' : '' }}>Cinzel (Klasik Monumental)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Font Teks Narasi & Warna Primer -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Font Teks Narasi / Isi</label>
                            <select 
                                id="selectFontTeks"
                                name="font_teks" 
                                class="w-full px-3.5 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none font-medium"
                                onchange="updateLivePreview()"
                            >
                                <option value="Plus Jakarta Sans" {{ old('font_teks', $template->font_teks) === 'Plus Jakarta Sans' ? 'selected' : '' }}>Plus Jakarta Sans (Modern)</option>
                                <option value="Inter" {{ old('font_teks', $template->font_teks) === 'Inter' ? 'selected' : '' }}>Inter (Sederhana Clean)</option>
                                <option value="Arial" {{ old('font_teks', $template->font_teks) === 'Arial' ? 'selected' : '' }}>Arial (Standar)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Warna Primer Tema</label>
                            <div class="flex items-center space-x-2">
                                <input 
                                    type="color" 
                                    id="colorPicker" 
                                    value="{{ old('warna_primer', $template->warna_primer ?? '#1e3a8a') }}" 
                                    class="w-12 h-11 p-1 rounded-xl border border-slate-200 cursor-pointer bg-white"
                                    onchange="syncColorInput(this.value)"
                                >
                                <input 
                                    type="text" 
                                    id="colorInput" 
                                    name="warna_primer" 
                                    value="{{ old('warna_primer', $template->warna_primer ?? '#1e3a8a') }}" 
                                    class="w-full px-3 py-3 rounded-xl border border-slate-200 text-xs font-mono font-bold focus:border-bgtk-600 outline-none uppercase"
                                    oninput="syncColorPicker(this.value)"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Preset Warna Cepat (Quick Palette) -->
                    <div>
                        <span class="block text-[11px] text-slate-500 font-semibold mb-1.5">Pilihan Palet Warna Cepat:</span>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" onclick="setWarnaPreset('#1e3a8a')" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold text-white bg-[#1e3a8a] shadow-xs">Biru BGTK</button>
                            <button type="button" onclick="setWarnaPreset('#0f766e')" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold text-white bg-[#0f766e] shadow-xs">Tosca Modern</button>
                            <button type="button" onclick="setWarnaPreset('#7c2d12')" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold text-white bg-[#7c2d12] shadow-xs">Cokelat Maroon</button>
                            <button type="button" onclick="setWarnaPreset('#111827')" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold text-white bg-[#111827] shadow-xs">Hitam Monokrom</button>
                            <button type="button" onclick="setWarnaPreset('#4338ca')" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold text-white bg-[#4338ca] shadow-xs">Indigo Formal</button>
                        </div>
                    </div>

                    <input type="hidden" name="warna_teks" value="#1f2937">

                    <!-- Opsi Checkbox Elemen -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2.5 text-xs">
                        <span class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Opsi Tampilan Dokumen</span>

                        <label class="flex items-center space-x-2.5 text-slate-700 cursor-pointer">
                            <input 
                                type="checkbox" 
                                id="checkGarisTepi"
                                name="tampilkan_garis_tepi" 
                                value="1" 
                                {{ old('tampilkan_garis_tepi', $template->tampilkan_garis_tepi) ? 'checked' : '' }} 
                                class="w-4 h-4 text-bgtk-600 rounded"
                                onchange="updateLivePreview()"
                            >
                            <span class="font-medium">Tampilkan Bingkai Garis Tepi Bawaan (Border)</span>
                        </label>

                        <label class="flex items-center space-x-2.5 text-slate-700 cursor-pointer">
                            <input 
                                type="checkbox" 
                                id="checkQrCode"
                                name="tampilkan_qr_code" 
                                value="1" 
                                {{ old('tampilkan_qr_code', $template->tampilkan_qr_code) ? 'checked' : '' }} 
                                class="w-4 h-4 text-bgtk-600 rounded"
                                onchange="updateLivePreview()"
                            >
                            <span class="font-medium">Tampilkan QR Code Verifikasi Online</span>
                        </label>

                        <label class="flex items-center space-x-2.5 text-slate-700 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="status_aktif" 
                                value="1" 
                                {{ old('status_aktif', $template->status_aktif) ? 'checked' : '' }} 
                                class="w-4 h-4 text-bgtk-600 rounded"
                            >
                            <span class="font-medium">Status Template Aktif (Dapat Dipilih Panitia)</span>
                        </label>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi / Catatan Desain</label>
                        <textarea 
                            name="deskripsi" 
                            rows="2" 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-bgtk-600 outline-none" 
                            placeholder="Contoh: Digunakan khusus untuk Diklat Peningkatan Mutu Guru Penggerak..."
                        >{{ old('deskripsi', $template->deskripsi) }}</textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end items-center gap-3 pt-3 border-t border-slate-200">
                        <a href="{{ route('admin.template.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-bgtk-700 hover:bg-bgtk-800 text-white font-bold text-xs shadow-sm transition">
                            {{ $isEdit ? 'Simpan Perubahan' : 'Buat Template Baru' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- ============================================== -->
            <!-- KOLOM KANAN: LIVE PREVIEW SERTIFIKAT (7/12)    -->
            <!-- ============================================== -->
            <div class="lg:col-span-7 sticky top-24 space-y-4">
                
                <!-- Header Live Preview Card -->
                <div class="bg-slate-900 text-white p-4 rounded-2xl shadow-md flex flex-wrap justify-between items-center gap-3">
                    <div class="flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-xs font-black tracking-wide">LIVE PREVIEW HASIL DESAIN</span>
                        <span id="previewBadgeNama" class="text-[10px] px-2 py-0.5 rounded bg-slate-800 text-amber-300 font-mono truncate max-w-[200px]">
                            {{ $template->nama_template ?? 'Desain Baru' }}
                        </span>
                    </div>

                    <!-- Switcher Halaman 1 & 2 -->
                    <div class="flex items-center space-x-1 bg-slate-800 p-1 rounded-xl text-xs">
                        <button 
                            type="button" 
                            id="tabBtnDepan" 
                            onclick="switchPreviewPage(1)" 
                            class="px-3 py-1 rounded-lg font-bold bg-bgtk-600 text-white transition text-xs"
                        >
                            Hal. 1 (Depan)
                        </button>
                        <button 
                            type="button" 
                            id="tabBtnBelakang" 
                            onclick="switchPreviewPage(2)" 
                            class="px-3 py-1 rounded-lg font-medium text-slate-300 hover:text-white transition text-xs"
                        >
                            Hal. 2 (Struktur JP)
                        </button>
                    </div>
                </div>

                <!-- Container Lembar Sertifikat -->
                <div class="bg-slate-200/80 p-4 rounded-3xl border border-slate-300 shadow-inner flex justify-center overflow-x-auto">
                    
                    <!-- SHEET PREVIEW -->
                    <div 
                        id="previewSheet" 
                        class="bg-white rounded-lg shadow-xl w-[700px] min-w-[700px] p-5 transition-all duration-300 relative select-none"
                    >
                        
                        <!-- ================= HALAMAN 1 (MUKA DEPAN) ================= -->
                        <div 
                            id="previewHal1" 
                            class="p-5 rounded relative transition-all duration-300 bg-cover bg-center"
                            style="
                                border: 4px solid {{ $template->warna_primer ?? '#1e3a8a' }}; 
                                outline: 2px solid #d97706; 
                                outline-offset: 3px;
                                @if($template->file_gambar_depan)
                                    background-image: url('{{ asset($template->file_gambar_depan) }}');
                                @endif
                            "
                        >
                            <!-- Ornamen Sudut Bawaan -->
                            <div class="corner-ornament absolute top-1.5 left-1.5 w-6 h-6 border-t-2 border-l-2 border-amber-600"></div>
                            <div class="corner-ornament absolute top-1.5 right-1.5 w-6 h-6 border-t-2 border-r-2 border-amber-600"></div>
                            <div class="corner-ornament absolute bottom-1.5 left-1.5 w-6 h-6 border-b-2 border-l-2 border-amber-600"></div>
                            <div class="corner-ornament absolute bottom-1.5 right-1.5 w-6 h-6 border-b-2 border-r-2 border-amber-600"></div>

                            <!-- Kop Dinas -->
                            <div class="text-center relative z-10 space-y-0.5">
                                <div class="w-10 h-10 mx-auto mb-1 rounded-full flex items-center justify-center text-amber-400 font-bold text-base shadow-sm border border-amber-400" id="previewLogoBg" style="background-color: {{ $template->warna_primer ?? '#1e3a8a' }}">
                                    🎓
                                </div>
                                <div class="text-[9px] font-bold tracking-widest uppercase text-slate-600 leading-tight">
                                    KEMENTERIAN PENDIDIKAN DASAR DAN MENENGAH
                                </div>
                                <div class="text-[10px] font-extrabold tracking-widest uppercase text-slate-800 leading-tight">
                                    DIREKTORAT JENDERAL GURU DAN TENAGA KEPENDIDIKAN
                                </div>
                                <div id="previewInstansi" class="text-[12px] font-black tracking-wider uppercase leading-tight" style="color: {{ $template->warna_primer ?? '#1e3a8a' }}">
                                    BALAI GURU DAN TENAGA KEPENDIDIKAN PROVINSI LAMPUNG
                                </div>
                                <div class="text-[7.5px] text-slate-400">
                                    Jl. Gatot Subroto No. 44, Pahoman, Kota Bandar Lampung • bgtklampung.kemdikbud.go.id
                                </div>

                                <div class="w-36 h-0.5 bg-gradient-to-r from-transparent via-amber-600 to-transparent mx-auto my-1.5"></div>

                                <h2 id="previewJudul" class="text-2xl font-cinzel font-black tracking-widest uppercase" style="color: {{ $template->warna_primer ?? '#1e3a8a' }}">
                                    SERTIFIKAT
                                </h2>
                                <div class="text-[9px] font-mono font-bold text-slate-500">
                                    Nomor: 001/BGTK-LPG/PP.01.07/2026
                                </div>
                            </div>

                            <!-- Badan Sertifikat -->
                            <div class="text-center my-4 space-y-1 relative z-10">
                                <div class="text-[10px] italic text-slate-500">Diberikan kepada:</div>

                                <!-- Nama Peserta Dinamis Sesuai Font Pilihan -->
                                <div 
                                    id="previewNamaPeserta" 
                                    class="text-xl font-bold uppercase tracking-wide border-b-2 border-amber-500/40 inline-block px-3 pb-0.5 transition-all"
                                    style="color: {{ $template->warna_primer ?? '#1e3a8a' }}; font-family: '{{ $template->font_nama ?? 'Montserrat' }}';"
                                >
                                    Siti Rahmawati, S.Pd., Gr.
                                </div>

                                <div id="previewTeksIdentitas" class="text-[9px] text-slate-600 font-medium pt-0.5">
                                    NIP: <strong>198804152011012009</strong> • Instansi: <strong>SMAN 1 Bandar Lampung</strong>
                                </div>

                                <div id="previewTeksNarasi" class="text-[9.5px] text-slate-700 pt-1.5 max-w-md mx-auto leading-relaxed">
                                    Atas partisipasinya sebagai <strong class="uppercase font-bold" id="previewAksenPeran" style="color: {{ $template->warna_primer ?? '#1e3a8a' }}">PESERTA</strong> dalam kegiatan:
                                </div>

                                <div class="text-xs font-black text-slate-900 max-w-md mx-auto leading-snug">
                                    "Bimbingan Teknis Implementasi Pembelajaran Berdiferensiasi Guru Penggerak"
                                </div>

                                <div id="previewTeksJam" class="text-[8.5px] text-slate-600 max-w-md mx-auto">
                                    diselenggarakan oleh BGTK Provinsi Lampung pada tanggal <strong>02 s/d 05 Maret 2026</strong> dengan pola beban belajar setara <strong id="previewAksenJam" style="color: {{ $template->warna_primer ?? '#1e3a8a' }}">32 Jam Pelajaran (JP)</strong>.
                                </div>
                            </div>

                            <!-- Footer Pengesahan & QR -->
                            <div class="flex justify-between items-end pt-2 relative z-10 px-1 text-[9px]">
                                <!-- QR Block -->
                                <div id="previewQrBlock" class="flex items-center space-x-2 text-left">
                                    <div class="w-12 h-12 bg-white p-1 border border-slate-300 rounded shadow-xs flex items-center justify-center font-mono text-[8px] text-slate-700 font-bold">
                                        [QR]
                                    </div>
                                    <div class="leading-tight text-[7.5px] text-slate-500">
                                        <span class="font-bold text-emerald-700 block">✓ Valid BGTK</span>
                                        <span>Scan verifikasi</span>
                                        <span class="font-mono text-slate-700 block">BGTK-7A8B9C</span>
                                    </div>
                                </div>

                                <!-- TTD Pejabat -->
                                <div class="text-center w-48 text-[9px]">
                                    <div class="text-slate-600 text-[8.5px]">Bandar Lampung, 05 Maret 2026</div>
                                    <div class="text-slate-800 font-medium text-[8.5px]">Kepala Balai Guru & Tenaga Kependidikan</div>
                                    <div class="h-8 flex items-center justify-center text-[7.5px] text-slate-400 italic">
                                        [Tanda Tangan & Stempel Resmi]
                                    </div>
                                    <div class="font-bold text-slate-950 border-b border-slate-700 inline-block pb-0.5 text-[9px]">
                                        Dr. H. Ahmad Fauzan, M.Pd.
                                    </div>
                                    <div class="text-[8px] text-slate-700">NIP. 197508142000031002</div>
                                </div>
                            </div>

                        </div>

                        <!-- ================= HALAMAN 2 (MUKA BELAKANG) ================= -->
                        <div 
                            id="previewHal2" 
                            class="p-5 rounded relative transition-all duration-300 bg-cover bg-center hidden"
                            style="
                                border: 4px solid {{ $template->warna_primer ?? '#1e3a8a' }}; 
                                outline: 2px solid #d97706; 
                                outline-offset: 3px;
                                @if($template->file_gambar_belakang)
                                    background-image: url('{{ asset($template->file_gambar_belakang) }}');
                                @endif
                            "
                        >
                            <!-- Ornamen Sudut -->
                            <div class="corner-ornament absolute top-1.5 left-1.5 w-6 h-6 border-t-2 border-l-2 border-amber-600"></div>
                            <div class="corner-ornament absolute top-1.5 right-1.5 w-6 h-6 border-t-2 border-r-2 border-amber-600"></div>
                            <div class="corner-ornament absolute bottom-1.5 left-1.5 w-6 h-6 border-b-2 border-l-2 border-amber-600"></div>
                            <div class="corner-ornament absolute bottom-1.5 right-1.5 w-6 h-6 border-b-2 border-r-2 border-amber-600"></div>

                            <div class="text-center mb-3">
                                <h3 class="text-base font-cinzel font-black tracking-widest uppercase" id="previewJudulHal2" style="color: {{ $template->warna_primer ?? '#1e3a8a' }}">
                                    STRUKTUR PROGRAM PELATIHAN
                                </h3>
                                <div class="text-[10px] font-bold text-slate-800 uppercase">
                                    Bimbingan Teknis Implementasi Pembelajaran Berdiferensiasi
                                </div>
                                <div class="text-[8px] text-slate-500 font-medium">
                                    Balai Guru dan Tenaga Kependidikan Provinsi Lampung
                                </div>
                                <div class="w-24 h-0.5 bg-amber-600 mx-auto mt-1"></div>
                            </div>

                            <!-- Tabel Struktur Program -->
                            <div class="px-2 py-1">
                                <table class="w-full text-[8.5px] border border-slate-300 border-collapse bg-white/90 backdrop-blur-xs">
                                    <thead>
                                        <tr id="previewTableHead" class="text-white font-bold text-center" style="background-color: {{ $template->warna_primer ?? '#1e3a8a' }}">
                                            <th class="border border-slate-300 p-1.5 w-8">NO</th>
                                            <th class="border border-slate-300 p-1.5 text-left">MATERI POKOK / TOPIK</th>
                                            <th class="border border-slate-300 p-1.5 w-16">JP</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-slate-800">
                                        <tr class="bg-white">
                                            <td class="border border-slate-300 p-1 text-center">1</td>
                                            <td class="border border-slate-300 p-1">Kebijakan Transformasi Pendidikan Ditjen GTK</td>
                                            <td class="border border-slate-300 p-1 text-center font-semibold">4 JP</td>
                                        </tr>
                                        <tr class="bg-slate-50/80">
                                            <td class="border border-slate-300 p-1 text-center">2</td>
                                            <td class="border border-slate-300 p-1">Konsep dan Prinsip Pembelajaran Berdiferensiasi</td>
                                            <td class="border border-slate-300 p-1 text-center font-semibold">6 JP</td>
                                        </tr>
                                        <tr class="bg-white">
                                            <td class="border border-slate-300 p-1 text-center">3</td>
                                            <td class="border border-slate-300 p-1">Pemetaan Kebutuhan Belajar & Asesmen Awal Peserta Didik</td>
                                            <td class="border border-slate-300 p-1 text-center font-semibold">8 JP</td>
                                        </tr>
                                        <tr class="bg-slate-50/80">
                                            <td class="border border-slate-300 p-1 text-center">4</td>
                                            <td class="border border-slate-300 p-1">Pengembangan Modul Ajar dan Strategi Diferensiasi</td>
                                            <td class="border border-slate-300 p-1 text-center font-semibold">10 JP</td>
                                        </tr>
                                        <tr class="bg-white">
                                            <td class="border border-slate-300 p-1 text-center">5</td>
                                            <td class="border border-slate-300 p-1">Refleksi Praktik Baik dan RTL</td>
                                            <td class="border border-slate-300 p-1 text-center font-semibold">4 JP</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-slate-100 font-bold text-slate-900 border-t border-slate-300">
                                            <td colspan="2" class="border border-slate-300 p-1 text-right uppercase">Total Beban Jam:</td>
                                            <td class="border border-slate-300 p-1 text-center font-black" id="previewTotalJp" style="color: {{ $template->warna_primer ?? '#1e3a8a' }}">32 JP</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Pengesahan Belakang -->
                            <div class="flex justify-end pt-2 px-2 text-[8.5px]">
                                <div class="text-center w-48">
                                    <div class="text-slate-600 text-[8px]">Bandar Lampung, 05 Maret 2026</div>
                                    <div class="text-slate-800 font-medium text-[8px]">Kepala BGTK Provinsi Lampung</div>
                                    <div class="h-6"></div>
                                    <div class="font-bold text-slate-950 border-b border-slate-700 inline-block pb-0.5 text-[8.5px]">
                                        Dr. H. Ahmad Fauzan, M.Pd.
                                    </div>
                                    <div class="text-[7.5px] text-slate-700">NIP. 197508142000031002</div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Info Panduan -->
                <div class="p-3 bg-white rounded-2xl border border-slate-200 text-slate-500 text-[11px] flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-lightbulb text-amber-500"></i>
                        <span>Upload gambar blanko untuk menampilkan background kustom Canva/Photoshop Anda langsung di lembar preview.</span>
                    </span>
                    <span class="font-mono text-[10px] text-slate-400">Dimensi standar A4</span>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Live update preview logic
    function updateLivePreview() {
        const namaTemplate = document.getElementById('inputNamaTemplate').value || 'Desain Baru';
        const fontNama = document.getElementById('selectFontNama').value;
        const fontTeks = document.getElementById('selectFontTeks').value;
        const warnaPrimer = document.getElementById('colorInput').value || '#1e3a8a';
        const garisTepi = document.getElementById('checkGarisTepi').checked;
        const tampilkanQr = document.getElementById('checkQrCode').checked;
        const orientasi = document.getElementById('selectOrientasi').value;

        // 1. Update Badge Nama
        document.getElementById('previewBadgeNama').textContent = namaTemplate;

        // 2. Update Warna Primer Elemen
        const borderStyle = garisTepi 
            ? `4px solid ${warnaPrimer}` 
            : 'none';
        const outlineStyle = garisTepi ? '2px solid #d97706' : 'none';

        const hal1 = document.getElementById('previewHal1');
        const hal2 = document.getElementById('previewHal2');
        hal1.style.border = borderStyle;
        hal1.style.outline = outlineStyle;
        hal2.style.border = borderStyle;
        hal2.style.outline = outlineStyle;

        // Sembunyikan ornamen sudut jika border dimatikan
        const corners = document.querySelectorAll('.corner-ornament');
        corners.forEach(c => {
            c.style.display = garisTepi ? 'block' : 'none';
        });

        document.getElementById('previewLogoBg').style.backgroundColor = warnaPrimer;
        document.getElementById('previewInstansi').style.color = warnaPrimer;
        document.getElementById('previewJudul').style.color = warnaPrimer;
        document.getElementById('previewJudulHal2').style.color = warnaPrimer;
        document.getElementById('previewNamaPeserta').style.color = warnaPrimer;
        document.getElementById('previewAksenPeran').style.color = warnaPrimer;
        document.getElementById('previewAksenJam').style.color = warnaPrimer;
        document.getElementById('previewTotalJp').style.color = warnaPrimer;
        document.getElementById('previewTableHead').style.backgroundColor = warnaPrimer;

        // 3. Update Font Nama Peserta
        document.getElementById('previewNamaPeserta').style.fontFamily = `'${fontNama}', sans-serif`;

        // 4. Update Font Teks Isi
        const teksElements = [
            document.getElementById('previewTeksIdentitas'),
            document.getElementById('previewTeksNarasi'),
            document.getElementById('previewTeksJam')
        ];
        teksElements.forEach(el => {
            if (el) el.style.fontFamily = `'${fontTeks}', sans-serif`;
        });

        // 5. Toggle QR Code
        const qrBlock = document.getElementById('previewQrBlock');
        if (tampilkanQr) {
            qrBlock.style.visibility = 'visible';
            qrBlock.style.opacity = '1';
        } else {
            qrBlock.style.visibility = 'hidden';
            qrBlock.style.opacity = '0';
        }

        // 6. Orientasi Sheet
        const sheet = document.getElementById('previewSheet');
        if (orientasi === 'portrait') {
            sheet.style.width = '520px';
            sheet.style.minWidth = '520px';
        } else {
            sheet.style.width = '700px';
            sheet.style.minWidth = '700px';
        }
    }

    // ==========================================
    // CLIENT-SIDE INSTANT PREVIEW UPLOAD GAMBAR
    // ==========================================
    function previewUploadDepan(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const hal1 = document.getElementById('previewHal1');
                hal1.style.backgroundImage = `url('${e.target.result}')`;
                hal1.style.backgroundSize = 'cover';
                hal1.style.backgroundPosition = 'center';
                // Beralih ke halaman depan untuk langsung melihat hasilnya
                switchPreviewPage(1);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewUploadBelakang(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const hal2 = document.getElementById('previewHal2');
                hal2.style.backgroundImage = `url('${e.target.result}')`;
                hal2.style.backgroundSize = 'cover';
                hal2.style.backgroundPosition = 'center';
                // Beralih ke halaman belakang untuk langsung melihat hasilnya
                switchPreviewPage(2);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function hapusBackgroundDepan(isChecked) {
        const hal1 = document.getElementById('previewHal1');
        if (isChecked) {
            hal1.style.backgroundImage = 'none';
        }
    }

    function hapusBackgroundBelakang(isChecked) {
        const hal2 = document.getElementById('previewHal2');
        if (isChecked) {
            hal2.style.backgroundImage = 'none';
        }
    }

    function switchPreviewPage(page) {
        const hal1 = document.getElementById('previewHal1');
        const hal2 = document.getElementById('previewHal2');
        const btn1 = document.getElementById('tabBtnDepan');
        const btn2 = document.getElementById('tabBtnBelakang');

        if (page === 1) {
            hal1.classList.remove('hidden');
            hal2.classList.add('hidden');
            btn1.className = 'px-3 py-1 rounded-lg font-bold bg-bgtk-600 text-white transition text-xs';
            btn2.className = 'px-3 py-1 rounded-lg font-medium text-slate-300 hover:text-white transition text-xs';
        } else {
            hal1.classList.add('hidden');
            hal2.classList.remove('hidden');
            btn2.className = 'px-3 py-1 rounded-lg font-bold bg-bgtk-600 text-white transition text-xs';
            btn1.className = 'px-3 py-1 rounded-lg font-medium text-slate-300 hover:text-white transition text-xs';
        }
    }

    function syncColorInput(val) {
        document.getElementById('colorInput').value = val.toUpperCase();
        updateLivePreview();
    }

    function syncColorPicker(val) {
        if (/^#[0-9A-F]{6}$/i.test(val)) {
            document.getElementById('colorPicker').value = val;
            updateLivePreview();
        }
    }

    function setWarnaPreset(hex) {
        document.getElementById('colorPicker').value = hex;
        document.getElementById('colorInput').value = hex.toUpperCase();
        updateLivePreview();
    }

    // Jalankan sekali saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        updateLivePreview();
    });
</script>
@endsection
