@extends('layouts.admin')

@section('title', 'Generator Sertifikat Masal - BGTK Lampung')
@section('page-title', 'Generator Sertifikat Masal')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-bgtk-900 to-slate-900 text-white p-6 sm:p-8 rounded-3xl shadow-sm relative overflow-hidden">
        <div class="relative z-10 max-w-2xl space-y-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-400/20 text-amber-300 text-xs font-bold uppercase tracking-wider">
                <i class="fa-solid fa-bolt"></i> Batch Certificate Generator
            </span>
            <h1 class="text-2xl sm:text-3xl font-black">
                Input Nama Sekaligus & Generate Masal
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Tidak perlu input satu per satu. Cukup tempel daftar nama guru atau upload file CSV, sistem akan otomatis menerbitkan nomor sertifikat resmi dan menyiapkan dokumen siap cetak.
            </p>
        </div>
    </div>

    <!-- Formulir Generator Masal -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10">
        
        <form action="{{ route('admin.sertifikat.proses-masal') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- BAGIAN 1: PILIH KEGIATAN & PERAN -->
            <div class="space-y-4 pb-6 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-slate-900 text-white text-xs font-bold flex items-center justify-center">1</span>
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Pilih Kegiatan Pelatihan</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Agenda Pelatihan / Bimtek <span class="text-rose-500">*</span>
                        </label>
                        <select name="kegiatan_id" id="selectKegiatan" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none font-semibold" required>
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach($daftarKegiatan as $k)
                            <option value="{{ $k->id }}" {{ $selectedKegiatanId == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kegiatan }} ({{ $k->jenis_kegiatan }} • {{ $k->jumlah_jam ?? 0 }} JP)
                            </option>
                            @endforeach
                        </select>
                        <div class="mt-1 flex items-center justify-between text-xs text-slate-400">
                            <span>Template yang terpasang akan otomatis digunakan.</span>
                            <a href="{{ route('admin.kegiatan.create') }}" class="text-bgtk-700 font-bold hover:underline">+ Buat Kegiatan Baru</a>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Peran Peserta Default
                        </label>
                        <select name="peran_default" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-bgtk-600 outline-none font-semibold">
                            <option value="Peserta" selected>Peserta</option>
                            <option value="Narasumber">Narasumber</option>
                            <option value="Fasilitator">Fasilitator</option>
                            <option value="Moderator">Moderator</option>
                            <option value="Panitia">Panitia</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: MASUKKAN DAFTAR NAMA SEKALIGUS -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-slate-900 text-white text-xs font-bold flex items-center justify-center">2</span>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Masukkan Daftar Nama Sekaligus</h3>
                    </div>

                    <button type="button" onclick="isiContohBanyak()" class="px-3 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 text-xs font-bold border border-amber-200 transition">
                        <i class="fa-solid fa-magic mr-1"></i> Gunakan Contoh 5 Nama
                    </button>
                </div>

                <!-- Input Textarea Masal -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        Metode A: Tempel (Paste) Daftar Nama Langsung di Bawah Ini:
                    </label>
                    <textarea 
                        name="data_teks" 
                        id="inputTextarea"
                        rows="8" 
                        class="w-full p-4 rounded-2xl border border-slate-200 text-xs font-mono focus:border-bgtk-600 focus:ring-4 focus:ring-bgtk-500/10 outline-none transition leading-relaxed"
                        placeholder="Contoh format fleksibel (satu nama per baris):&#10;Ahmad Fauzi, S.Pd.&#10;Siti Nurhaliza, M.Pd. | 198804152011012009 | SMAN 1 Bandar Lampung&#10;Rudi Hartono, S.Kom. | 198207192008011015 | SMPN 2 Kalianda | Lampung Selatan"
                        oninput="hitungBaris()"
                    ></textarea>

                    <div class="mt-2 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-2">
                        <span id="labelJumlahNama" class="font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md">
                            Terdeteksi: 0 nama
                        </span>
                        <span class="text-slate-400 text-[11px]">
                            Gunakan pemisah pipa (<strong class="font-mono text-slate-700">|</strong>) atau titik koma (<strong class="font-mono text-slate-700">;</strong>) untuk menyertakan NIP & Instansi.
                        </span>
                    </div>
                </div>

                <!-- Opsi Upload Berkas CSV -->
                <div class="pt-4 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        Metode B: Atau Unggah Berkas Spreadsheet (CSV / TXT):
                    </label>
                    <input 
                        type="file" 
                        name="file_csv" 
                        accept=".csv,.txt"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-800 hover:file:bg-slate-200 cursor-pointer"
                    >
                </div>
            </div>

            <!-- TOMBOL EKSEKUSI GENERATOR -->
            <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-xs text-slate-400">
                    <i class="fa-solid fa-shield-check text-emerald-600 mr-1"></i>
                    Nomor sertifikat dan QR Code akan digenerate secara otomatis dan unik.
                </div>

                <button 
                    type="submit" 
                    class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-slate-950 hover:bg-slate-800 text-white font-bold text-xs shadow-lg shadow-slate-950/20 transition flex items-center justify-center gap-2"
                >
                    <i class="fa-solid fa-bolt text-amber-400"></i>
                    <span>Generate Semua Sertifikat Sekaligus</span>
                </button>
            </div>

        </form>

    </div>

</div>
@endsection

@section('scripts')
<script>
    function hitungBaris() {
        const text = document.getElementById('inputTextarea').value.trim();
        if (!text) {
            document.getElementById('labelJumlahNama').textContent = 'Terdeteksi: 0 nama';
            return;
        }
        const lines = text.split(/\r\n|\r|\n/).filter(line => line.trim().length > 0);
        document.getElementById('labelJumlahNama').textContent = 'Terdeteksi: ' + lines.length + ' nama peserta siap digenerate';
    }

    function isiContohBanyak() {
        const contoh = 
`Hendra Kurniawan, S.Pd., M.M. | 198506122009021004 | SMAN 2 Bandar Lampung | Kota Bandar Lampung
Nurlaila Sari, S.Pd. | 199003152014032001 | SMPN 1 Natar | Kabupaten Lampung Selatan
Dedi Kusuma, S.Pd., Gr. | 198711202010011012 | SMAN 1 Metro | Kota Metro
Fitri Handayani, M.Pd. | 198305042008012018 | SDN 3 Pringsewu | Kabupaten Pringsewu
Bambang Wijaya, S.Pd. | 198908222015021003 | SMAN 1 Terusan Nunyai | Kabupaten Lampung Tengah`;

        document.getElementById('inputTextarea').value = contoh;
        hitungBaris();
    }
</script>
@endsection

