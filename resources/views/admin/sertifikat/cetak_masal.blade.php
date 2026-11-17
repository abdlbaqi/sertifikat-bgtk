<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak_Masal_Sertifikat_{{ Str::slug($kegiatan->nama_kegiatan) }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;0,700;0,800;1,400&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Cinzel:wght@600;700;800&family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @php
        $tpl = $kegiatan->template;
        $warnaPrimer = $tpl->warna_primer ?? '#1e3a8a';
        $fontNama = $tpl->font_nama ?? 'Montserrat';
        $fontTeks = $tpl->font_teks ?? 'Plus Jakarta Sans';
        $tampilkanBorder = $tpl ? $tpl->tampilkan_garis_tepi : true;
        $tampilkanQr = $tpl ? $tpl->tampilkan_qr_code : true;
        $bgDepan = $kegiatan->template_background ?? ($tpl->file_gambar_depan ?? null);
        $bgBelakang = $tpl->file_gambar_belakang ?? null;
    @endphp

    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            font-family: '{{ $fontTeks }}', sans-serif;
            background-color: #3f3f46;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .cert-sheet {
            width: 297mm;
            height: 210mm;
            min-height: 210mm;
            position: relative;
            background-color: #ffffff;
            margin: 20px auto;
            box-sizing: border-box;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            page-break-after: always;
            break-after: page;
        }

        .cert-inner {
            position: absolute;
            inset: 10mm;
            box-sizing: border-box;
            background-size: cover;
            background-position: center;
        }

        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
        .font-greatvibes { font-family: 'Great Vibes', cursive; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }

        .cert-border-outer {
            border: 4px solid {{ $warnaPrimer }};
            outline: 2px solid #d97706;
            outline-offset: 4px;
        }

        @media print {
            body {
                background: transparent;
            }

            .no-print {
                display: none !important;
            }

            .cert-sheet {
                margin: 0 !important;
                box-shadow: none !important;
                width: 297mm !important;
                height: 210mm !important;
                max-height: 210mm !important;
            }
        }
    </style>
</head>
<body>

    <!-- Bar Navigasi Cetak Masal (Tidak ikut tercetak) -->
    <div class="no-print bg-slate-900 text-white px-6 py-4 sticky top-0 z-50 shadow-lg flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.sertifikat.index', ['kegiatan_id' => $kegiatan->id]) }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-semibold transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Admin
            </a>
            <span class="text-xs sm:text-sm font-semibold text-slate-200">
                Cetak Masal: <strong>{{ $kegiatan->nama_kegiatan }}</strong>
                <span class="px-2 py-0.5 rounded bg-amber-500 text-slate-950 font-bold ml-2 text-xs">
                    {{ $kegiatan->sertifikat->count() }} Sertifikat
                </span>
            </span>
        </div>

        <div class="flex items-center space-x-3">
            <span class="text-xs text-slate-400 hidden md:inline">Semua sertifikat digabungkan dalam satu perintah cetak</span>
            <button onclick="window.print()" class="px-6 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-bold text-xs shadow-md transition flex items-center gap-2">
                <i class="fa-solid fa-print text-sm"></i>
                <span>Cetak Semua ({{ $kegiatan->sertifikat->count() }} Dokumen)</span>
            </button>
        </div>
    </div>

    <!-- LOOP SEMUA SERTIFIKAT KEGIATAN INI -->
    @foreach($kegiatan->sertifikat as $index => $sertifikat)
        
        <!-- HALAMAN DEPAN PESERTA #{{ $index + 1 }} -->
        <div class="cert-sheet">
            <div 
                class="cert-inner {{ $tampilkanBorder ? 'cert-border-outer' : '' }} bg-white flex flex-col justify-between p-8 relative overflow-hidden"
                style="{{ $bgDepan ? "background-image: url('" . asset($bgDepan) . "');" : "" }}"
            >
                @if($tampilkanBorder)
                <div class="absolute top-2 left-2 w-12 h-12 border-t-4 border-l-4 border-amber-600 pointer-events-none"></div>
                <div class="absolute top-2 right-2 w-12 h-12 border-t-4 border-r-4 border-amber-600 pointer-events-none"></div>
                <div class="absolute bottom-2 left-2 w-12 h-12 border-b-4 border-l-4 border-amber-600 pointer-events-none"></div>
                <div class="absolute bottom-2 right-2 w-12 h-12 border-b-4 border-r-4 border-amber-600 pointer-events-none"></div>
                @endif

                <!-- Kop Kedinasan -->
                <div class="text-center relative z-10">
                    <div class="flex items-center justify-center space-x-4 mb-2">
                        <div class="w-14 h-14 rounded-full text-amber-400 flex items-center justify-center text-2xl font-bold shadow-sm border-2 border-amber-400" style="background-color: {{ $warnaPrimer }}">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                    </div>

                    <div class="text-[11px] font-bold tracking-widest text-slate-700 uppercase leading-tight">
                        KEMENTERIAN PENDIDIKAN DASAR DAN MENENGAH
                    </div>
                    <div class="text-[12px] font-extrabold tracking-widest text-slate-900 uppercase leading-tight">
                        DIREKTORAT JENDERAL GURU DAN TENAGA KEPENDIDIKAN
                    </div>
                    <div class="text-[14px] font-black tracking-wider uppercase leading-tight mt-0.5" style="color: {{ $warnaPrimer }}">
                        BALAI GURU DAN TENAGA KEPENDIDIKAN PROVINSI LAMPUNG
                    </div>
                    <div class="text-[9px] text-slate-500 font-medium">
                        Jalan Gatot Subroto No. 44, Pahoman, Kota Bandar Lampung 35222 • Laman: bgtklampung.kemdikbud.go.id
                    </div>

                    <div class="w-48 h-0.5 bg-gradient-to-r from-transparent via-amber-600 to-transparent mx-auto mt-2 mb-2"></div>

                    <h1 class="text-3xl font-cinzel font-black tracking-widest uppercase mt-1" style="color: {{ $warnaPrimer }}">
                        SERTIFIKAT
                    </h1>
                    <div class="text-[11px] font-mono font-semibold text-slate-600 tracking-wide">
                        Nomor: {{ $sertifikat->nomor_sertifikat }}
                    </div>
                </div>

                <!-- Badan Sertifikat -->
                <div class="text-center my-auto py-2 relative z-10 space-y-1.5">
                    <div class="text-xs text-slate-600 italic">Diberikan Kepada:</div>

                    <div 
                        class="text-2xl sm:text-3xl font-bold tracking-wide uppercase px-4 border-b-2 border-amber-600/40 inline-block pb-1"
                        style="color: {{ $warnaPrimer }}; font-family: '{{ $fontNama }}', sans-serif;"
                    >
                        {{ $sertifikat->nama_peserta }}
                    </div>

                    <div class="text-[11px] text-slate-600 font-medium">
                        @if($sertifikat->nomor_identitas)
                            <span>NIP/NUPTK: <strong>{{ $sertifikat->nomor_identitas }}</strong></span> • 
                        @endif
                        <span>Instansi: <strong>{{ $sertifikat->instansi ?? 'Satuan Pendidikan' }}</strong></span>
                        @if($sertifikat->kabupaten_kota)
                            • <span>{{ $sertifikat->kabupaten_kota }}</span>
                        @endif
                    </div>

                    <div class="text-xs text-slate-700 max-w-3xl mx-auto pt-2 leading-relaxed">
                        Atas partisipasinya sebagai <strong class="uppercase font-bold" style="color: {{ $warnaPrimer }}">{{ $sertifikat->peran }}</strong> dalam kegiatan:
                    </div>

                    <div class="text-base sm:text-lg font-black text-slate-900 max-w-2xl mx-auto leading-snug">
                        "{{ $kegiatan->nama_kegiatan }}"
                    </div>

                    <div class="text-[11px] text-slate-600 max-w-2xl mx-auto">
                        diselenggarakan oleh Balai Guru dan Tenaga Kependidikan Provinsi Lampung pada tanggal 
                        <strong>{{ $kegiatan->tanggal_mulai ? $kegiatan->tanggal_mulai->translatedFormat('d F Y') : '-' }}</strong> 
                        sampai dengan 
                        <strong>{{ $kegiatan->tanggal_selesai ? $kegiatan->tanggal_selesai->translatedFormat('d F Y') : '-' }}</strong> 
                        dengan pola beban belajar setara 
                        <strong style="color: {{ $warnaPrimer }}">{{ $kegiatan->jumlah_jam ?? '-' }} Jam Pelajaran (JP)</strong>.
                    </div>
                </div>

                <!-- Footer Pengesahan -->
                <div class="flex justify-between items-end pt-2 relative z-10">
                    @if($tampilkanQr)
                    <div class="flex items-center space-x-3 text-left">
                        <div class="p-1.5 bg-white border border-slate-300 rounded-lg shadow-sm">
                            @php
                                $verifUrl = route('sertifikat.verifikasi', $sertifikat->kode_verifikasi);
                                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=110x110&margin=2&data=' . urlencode($verifUrl);
                            @endphp
                            <img src="{{ $qrUrl }}" alt="QR Verifikasi" class="w-16 h-16">
                        </div>
                        <div class="text-[9px] text-slate-600 space-y-0.5 leading-tight">
                            <div class="font-bold text-slate-800 flex items-center gap-1">
                                <i class="fa-solid fa-shield-check text-emerald-600"></i> Terverifikasi Digital
                            </div>
                            <div>Scan QR validasi keaslian</div>
                            <div class="font-mono text-slate-500">ID: {{ $sertifikat->kode_verifikasi }}</div>
                        </div>
                    </div>
                    @else
                    <div></div>
                    @endif

                    <div class="text-center w-64 text-[11px]">
                        <div class="text-slate-700">
                            Bandar Lampung, {{ $kegiatan->tanggal_sertifikat ? $kegiatan->tanggal_sertifikat->translatedFormat('d F Y') : date('d F Y') }}
                        </div>
                        <div class="text-slate-800 font-medium">
                            {{ $kegiatan->jabatan_penandatangan }}
                        </div>
                        <div class="h-16 flex items-center justify-center relative my-0.5">
                            <div class="w-24 h-12 border border-dashed border-slate-300 rounded flex items-center justify-center text-[9px] text-slate-400">
                                [Tanda Tangan Elektronik]
                            </div>
                        </div>
                        <div class="font-bold text-slate-950 text-xs border-b border-slate-700 inline-block pb-0.5">
                            {{ $kegiatan->nama_penandatangan ?? 'Dr. H. Ahmad Fauzan, M.Pd.' }}
                        </div>
                        <div class="text-[10px] text-slate-700">
                            NIP. {{ $kegiatan->nip_penandatangan ?? '197508142000031002' }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

    @endforeach

</body>
</html>

