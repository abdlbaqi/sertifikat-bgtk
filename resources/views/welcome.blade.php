<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sertifikatku – Buat Sertifikat Custom</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|cormorant-garamond:500,600,700|pinyon-script:400" rel="stylesheet" />

    <style>
        :root {
            --bg: #eef1f6;
            --panel: #ffffff;
            --ink: #14213d;
            --muted: #5b6579;
            --line: #d6dce8;
            --accent: #14213d;
            --gold: #b8892b;
            --radius: 10px;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #0e1424;
                --panel: #172036;
                --ink: #e8ecf5;
                --muted: #9aa5bd;
                --line: #2a3654;
                --accent: #e8ecf5;
            }
        }
        * { box-sizing: border-box; margin: 0; }
        body { font-family: 'Figtree', system-ui, sans-serif; background: var(--bg); color: var(--ink); line-height: 1.5; }
        a { color: inherit; text-decoration: none; }

        /* Header */
        .top { max-width: 1240px; margin: 0 auto; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between; }
        .brand { font-family: 'Cormorant Garamond', serif; font-weight: 700; font-size: 26px; letter-spacing: .01em; }
        .brand i { font-style: normal; color: var(--gold); }
        .nav { display: flex; gap: 10px; font-size: 14px; }
        .btn { display: inline-block; padding: 9px 18px; border-radius: 8px; border: 1px solid var(--line); background: transparent; color: var(--ink); font: inherit; font-weight: 600; cursor: pointer; }
        .btn:hover { border-color: var(--ink); }
        .btn.primary { background: var(--ink); color: var(--bg); border-color: var(--ink); }
        .btn:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible { outline: 3px solid var(--gold); outline-offset: 2px; }

        /* Hero */
        .hero { max-width: 1240px; margin: 0 auto; padding: 8px 24px 20px; }
        .hero h1 { font-family: 'Cormorant Garamond', serif; font-weight: 700; font-size: clamp(34px, 5vw, 56px); line-height: 1.05; max-width: 16ch; }
        .hero p { margin-top: 12px; color: var(--muted); max-width: 52ch; }

        /* Editor */
        .studio { max-width: 1240px; margin: 0 auto; padding: 12px 24px 56px; display: grid; grid-template-columns: 340px 1fr; gap: 24px; align-items: start; }
        .form { background: var(--panel); border: 1px solid var(--line); border-radius: var(--radius); padding: 20px; display: grid; gap: 14px; position: sticky; top: 16px; }
        .form h2 { font-size: 16px; }
        label { display: grid; gap: 5px; font-size: 13px; font-weight: 600; color: var(--muted); }
        input, select, textarea { font: inherit; font-weight: 400; color: var(--ink); background: var(--bg); border: 1px solid var(--line); border-radius: 8px; padding: 9px 11px; width: 100%; }
        textarea { resize: vertical; min-height: 64px; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        input[type=color] { padding: 2px; height: 40px; cursor: pointer; }
        .actions { display: flex; gap: 10px; margin-top: 4px; }
        .actions .btn { flex: 1; text-align: center; }
        .hint { font-size: 12px; color: var(--muted); }

        .stage { background: var(--panel); border: 1px solid var(--line); border-radius: var(--radius); padding: clamp(12px, 2.5vw, 28px); }

        /* Sertifikat (ukuran A4 landscape, skala mengikuti lebar kontainer) */
        .cert { container-type: inline-size; width: 100%; aspect-ratio: 297 / 210; background: #fffdf8; color: #1a1a1a; position: relative; box-shadow: 0 10px 40px rgba(20, 33, 61, .18); overflow: hidden; }
        .cert-inner { position: absolute; inset: 3.2cqw; border: .35cqw solid var(--c); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 4cqw 8cqw; }
        .cert-inner::before { content: ""; position: absolute; inset: .9cqw; border: .12cqw solid var(--c); opacity: .6; pointer-events: none; }
        .cert .kicker { font-family: 'Cormorant Garamond', serif; font-weight: 600; font-size: 4.6cqw; letter-spacing: .28em; color: var(--c); }
        .cert .sub { font-size: 1.6cqw; margin-top: 1.6cqw; color: #55555f; }
        .cert .name { font-family: 'Pinyon Script', cursive; font-size: 8.6cqw; line-height: 1.15; margin: 1.6cqw 0 1cqw; color: #111; border-bottom: .15cqw solid var(--c); padding: 0 4cqw .6cqw; max-width: 100%; overflow-wrap: anywhere; }
        .cert .desc { font-size: 1.7cqw; max-width: 62%; color: #3b3b44; white-space: pre-line; }
        .cert .meta { position: absolute; left: 8cqw; right: 8cqw; bottom: 6cqw; display: flex; justify-content: space-between; align-items: end; font-size: 1.5cqw; color: #3b3b44; }
        .cert .sign { text-align: center; min-width: 20cqw; }
        .cert .sign b { display: block; border-top: .12cqw solid #1a1a1a; margin-top: 4cqw; padding-top: .6cqw; font-size: 1.7cqw; }
        .seal { width: 9cqw; height: 9cqw; border-radius: 50%; background: radial-gradient(circle at 35% 30%, #e9c874, var(--gold)); border: .4cqw double #fff6; display: grid; place-items: center; color: #fff; font-family: 'Cormorant Garamond', serif; font-weight: 700; font-size: 1.5cqw; box-shadow: 0 .3cqw .8cqw rgba(0,0,0,.25); }

        /* Template */
        .cert[data-theme="klasik"] { --c: var(--accentcert, #14213d); }
        .cert[data-theme="modern"] { --c: var(--accentcert, #0f766e); background: #f6fbfa; }
        .cert[data-theme="modern"] .cert-inner { border-width: 0; border-left: 1.6cqw solid var(--c); inset: 0; padding-left: 12cqw; align-items: flex-start; text-align: left; }
        .cert[data-theme="modern"] .cert-inner::before { display: none; }
        .cert[data-theme="modern"] .name { padding-left: 0; font-family: 'Cormorant Garamond', serif; font-weight: 700; font-size: 7.4cqw; }
        .cert[data-theme="modern"] .seal { display: none; }
        .cert[data-theme="minimal"] { --c: var(--accentcert, #111111); background: #fff; }
        .cert[data-theme="minimal"] .cert-inner { border-width: 0; }
        .cert[data-theme="minimal"] .cert-inner::before { inset: 0; border-width: .12cqw; opacity: 1; }
        .cert[data-theme="minimal"] .seal { background: #111; box-shadow: none; border: 0; }

        .note { margin-top: 14px; color: var(--muted); font-size: 13px; }

        @media (max-width: 920px) {
            .studio { grid-template-columns: 1fr; }
            .form { position: static; }
        }

        /* Cetak / simpan PDF: hanya sertifikat */
        @page { size: A4 landscape; margin: 0; }
        @media print {
            body { background: #fff; }
            .top, .hero, .form, .note, .studio > .stage > :not(.cert) { display: none !important; }
            .studio { display: block; padding: 0; max-width: none; }
            .stage { border: 0; padding: 0; background: none; }
            .cert { box-shadow: none; width: 297mm; height: 210mm; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <header class="top">
        <a href="/" class="brand">Sertifikat<i>ku</i></a>
        @if (Route::has('login'))
            <nav class="nav">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn primary">Daftar</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <section class="hero">
        <h1>Sertifikat yang rapi, jadi dalam semenit.</h1>
        <p>Isi nama, judul, dan tanggal. Pilih desain, lalu unduh sebagai PDF siap cetak.</p>
    </section>

    <main class="studio">
        <form class="form" onsubmit="return false" aria-label="Pengaturan sertifikat">
            <h2>Isi sertifikat</h2>

            <label>Judul sertifikat
                <input id="f-title" value="Sertifikat Penghargaan" maxlength="40">
            </label>
            <label>Nama penerima
                <input id="f-name" value="Aulia Rahmawati" maxlength="60">
            </label>
            <label>Keterangan
                <textarea id="f-desc" maxlength="220">Atas partisipasi dan prestasinya sebagai Peserta Terbaik dalam Workshop Desain Grafis 2026.</textarea>
            </label>
            <div class="row">
                <label>Tanggal
                    <input id="f-date" type="date" value="2026-11-16">
                </label>
                <label>Lokasi
                    <input id="f-place" value="Jakarta" maxlength="30">
                </label>
            </div>
            <div class="row">
                <label>Penandatangan
                    <input id="f-signer" value="Budi Santoso" maxlength="40">
                </label>
                <label>Jabatan
                    <input id="f-role" value="Ketua Panitia" maxlength="30">
                </label>
            </div>
            <div class="row">
                <label>Desain
                    <select id="f-theme">
                        <option value="klasik">Klasik</option>
                        <option value="modern">Modern</option>
                        <option value="minimal">Minimal</option>
                    </select>
                </label>
                <label>Warna utama
                    <input id="f-color" type="color" value="#14213d">
                </label>
            </div>

            <div class="actions">
                <button type="button" class="btn primary" onclick="window.print()">Unduh PDF</button>
            </div>
            <p class="hint">Di jendela cetak, pilih “Simpan sebagai PDF”.</p>
        </form>

        <div class="stage">
            <div class="cert" id="cert" data-theme="klasik">
                <div class="cert-inner">
                    <div class="kicker" id="o-title">SERTIFIKAT PENGHARGAAN</div>
                    <div class="sub">Diberikan kepada</div>
                    <div class="name" id="o-name">Aulia Rahmawati</div>
                    <div class="desc" id="o-desc"></div>
                    <div class="meta">
                        <div id="o-datePlace"></div>
                        <div class="seal">RESMI</div>
                        <div class="sign"><span id="o-role"></span><b id="o-signer"></b></div>
                    </div>
                </div>
            </div>
            <p class="note">Pratinjau berubah otomatis saat Anda mengetik.</p>
        </div>
    </main>

    <script>
        const $ = (id) => document.getElementById(id);
        const cert = $('cert');

        function formatTanggal(v) {
            if (!v) return '';
            return new Date(v + 'T00:00:00').toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        }

        function render() {
            $('o-title').textContent = $('f-title').value.toUpperCase();
            $('o-name').textContent = $('f-name').value || 'Nama Penerima';
            $('o-desc').textContent = $('f-desc').value;
            $('o-datePlace').textContent = [$('f-place').value, formatTanggal($('f-date').value)].filter(Boolean).join(', ');
            $('o-role').textContent = $('f-role').value;
            $('o-signer').textContent = $('f-signer').value;
            cert.dataset.theme = $('f-theme').value;
            cert.style.setProperty('--accentcert', $('f-color').value);
        }

        document.querySelectorAll('.form input, .form select, .form textarea').forEach((el) => {
            el.addEventListener('input', render);
        });
        render();
    </script>
</body>
</html>