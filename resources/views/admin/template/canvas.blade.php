@extends('layouts.admin')

@section('title', 'Kanvas Editor — ' . $template->nama_template)

@push('styles')
<style>
/* =========================================
   KANVAS EDITOR — BGTK Certificate Studio
   ========================================= */

/* Layout */
.editor-wrap {
    display: flex;
    height: calc(100vh - 64px);
    overflow: hidden;
    background: #0f172a;
}

/* ---- LEFT SIDEBAR ---- */
.sidebar-panel {
    width: 280px;
    min-width: 240px;
    max-width: 320px;
    background: #1e293b;
    border-right: 1px solid #334155;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    flex-shrink: 0;
    resize: horizontal;
}
.sidebar-header {
    padding: 14px 16px;
    background: #0f172a;
    border-bottom: 1px solid #334155;
    display: flex;
    align-items: center;
    gap: 10px;
}
.sidebar-header h2 {
    font-size: 13px;
    font-weight: 700;
    color: #f8fafc;
    letter-spacing: .4px;
    flex: 1;
}
.sidebar-scroll {
    overflow-y: auto;
    flex: 1;
    padding: 12px;
}
.sidebar-scroll::-webkit-scrollbar { width: 4px; }
.sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
.sidebar-scroll::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }

/* Tabs */
.tab-bar {
    display: flex;
    background: #0f172a;
    border-bottom: 1px solid #334155;
}
.tab-btn {
    flex: 1;
    padding: 9px 4px;
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
    text-align: center;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all .2s;
    letter-spacing: .3px;
}
.tab-btn.active {
    color: #38bdf8;
    border-bottom-color: #38bdf8;
    background: #1e293b;
}
.tab-content { display: none; }
.tab-content.active { display: block; }

/* Element list */
.el-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 10px;
    border-radius: 8px;
    cursor: pointer;
    color: #94a3b8;
    font-size: 12px;
    font-weight: 500;
    transition: all .15s;
    border: 1px solid transparent;
    margin-bottom: 3px;
}
.el-item:hover { background: #334155; color: #f1f5f9; }
.el-item.active { background: #1e3a5f; color: #38bdf8; border-color: #1d4ed8; }
.el-item .el-icon { width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 12px; background: #334155; flex-shrink: 0; }
.el-item.active .el-icon { background: #1d4ed8; color: #fff; }
.el-item .el-vis { margin-left: auto; cursor: pointer; }

/* Properties panel */
.prop-label { font-size: 11px; color: #64748b; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; margin-bottom: 5px; margin-top: 12px; }
.prop-input {
    width: 100%;
    background: #0f172a;
    border: 1px solid #334155;
    border-radius: 7px;
    color: #f1f5f9;
    font-size: 12px;
    padding: 7px 10px;
    outline: none;
    transition: border .15s;
}
.prop-input:focus { border-color: #38bdf8; }
.prop-row { display: flex; gap: 8px; }
.prop-row .prop-input { flex: 1; }

/* ---- CENTER CANVAS AREA ---- */
.canvas-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #0f172a;
}
.canvas-toolbar {
    height: 44px;
    background: #1e293b;
    border-bottom: 1px solid #334155;
    display: flex;
    align-items: center;
    padding: 0 16px;
    gap: 8px;
    flex-shrink: 0;
}
.toolbar-btn {
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all .15s;
    border: 1px solid transparent;
    color: #94a3b8;
    background: transparent;
}
.toolbar-btn:hover { background: #334155; color: #f1f5f9; }
.toolbar-btn.primary { background: #2563eb; color: #fff; border-color: #2563eb; }
.toolbar-btn.primary:hover { background: #1d4ed8; }
.toolbar-btn.success { background: #16a34a; color: #fff; border-color: #16a34a; }
.toolbar-btn.success:hover { background: #15803d; }
.zoom-label { font-size: 11px; color: #64748b; margin-left: 8px; }
.save-status { font-size: 11px; color: #64748b; margin-left: auto; display: flex; align-items: center; gap: 5px; }
.save-dot { width: 7px; height: 7px; border-radius: 50%; background: #64748b; }
.save-dot.saved { background: #22c55e; }
.save-dot.saving { background: #f59e0b; animation: pulse 1s infinite; }

@keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: .4; } }

.canvas-scroll {
    flex: 1;
    overflow: auto;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 32px;
}
.canvas-scroll::-webkit-scrollbar { width: 8px; height: 8px; }
.canvas-scroll::-webkit-scrollbar-track { background: #0f172a; }
.canvas-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }

/* The actual certificate canvas */
#cert-canvas {
    position: relative;
    background: #fff;
    box-shadow: 0 20px 80px rgba(0,0,0,.8);
    transform-origin: top center;
    /* A4 Landscape: 297mm × 210mm → at 96dpi = 1123px × 794px; we scale down */
    width: 1123px;
    height: 794px;
    flex-shrink: 0;
    overflow: hidden;
    cursor: default;
    border-radius: 2px;
}
#cert-canvas.portrait {
    width: 794px;
    height: 1123px;
}

/* Canvas background image overlay */
#canvas-bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    pointer-events: none;
    z-index: 0;
}

/* Draggable elements on canvas */
.cert-el {
    position: absolute;
    cursor: grab;
    border: 1.5px solid transparent;
    border-radius: 3px;
    transition: border-color .1s;
    z-index: 10;
    box-sizing: border-box;
    min-width: 40px;
    min-height: 20px;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    flex-direction: column;
    padding: 4px 6px;
    user-select: none;
}
.cert-el:hover { border-color: rgba(56,189,248,.5); }
.cert-el.selected {
    border-color: #38bdf8 !important;
    z-index: 20;
}
.cert-el.selected::before {
    content: '';
    position: absolute;
    inset: -1px;
    border: 1.5px dashed #38bdf8;
    border-radius: 3px;
    pointer-events: none;
}
.cert-el:active { cursor: grabbing; }

/* Resize handles */
.resize-handle {
    position: absolute;
    width: 8px;
    height: 8px;
    background: #38bdf8;
    border: 1.5px solid #fff;
    border-radius: 2px;
    z-index: 30;
    cursor: nwse-resize;
}
.resize-handle.se { right: -4px; bottom: -4px; cursor: se-resize; }
.resize-handle.sw { left: -4px; bottom: -4px; cursor: sw-resize; }
.resize-handle.ne { right: -4px; top: -4px; cursor: ne-resize; }
.resize-handle.nw { left: -4px; top: -4px; cursor: nw-resize; }
.resize-handle.e  { right: -4px; top: 50%; transform: translateY(-50%); cursor: e-resize; }
.resize-handle.w  { left: -4px; top: 50%; transform: translateY(-50%); cursor: w-resize; }
.resize-handle.n  { top: -4px; left: 50%; transform: translateX(-50%); cursor: n-resize; }
.resize-handle.s  { bottom: -4px; left: 50%; transform: translateX(-50%); cursor: s-resize; }

/* ---- RIGHT PROPERTIES PANEL ---- */
.props-panel {
    width: 240px;
    min-width: 200px;
    background: #1e293b;
    border-left: 1px solid #334155;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    flex-shrink: 0;
}
.props-header {
    padding: 14px 16px;
    background: #0f172a;
    border-bottom: 1px solid #334155;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    letter-spacing: .4px;
}
.props-scroll { overflow-y: auto; flex: 1; padding: 12px; }
.props-scroll::-webkit-scrollbar { width: 4px; }
.props-scroll::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }

/* Text el styling */
.cert-el-inner {
    width: 100%;
    pointer-events: none;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cert-el.editing .cert-el-inner {
    pointer-events: all;
    outline: none;
}

/* Inline editing */
.cert-el[contenteditable="true"] {
    cursor: text;
    overflow: visible;
}

/* Grid snapping guide lines */
.guide-h, .guide-v {
    position: absolute;
    background: rgba(56,189,248,.6);
    pointer-events: none;
    z-index: 100;
}
.guide-h { width: 100%; height: 1px; left: 0; }
.guide-v { width: 1px; height: 100%; top: 0; }

/* Toast */
#toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    padding: 10px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #fff;
    z-index: 9999;
    transform: translateY(60px);
    opacity: 0;
    transition: all .3s cubic-bezier(.34,1.56,.64,1);
    pointer-events: none;
}
#toast.show { transform: translateY(0); opacity: 1; }
#toast.success { background: #16a34a; }
#toast.error { background: #dc2626; }
#toast.info { background: #2563eb; }

/* Ruler */
.ruler-h, .ruler-v {
    position: absolute;
    background: #1e293b;
    pointer-events: none;
    z-index: 5;
    overflow: hidden;
}

/* Selection box */
#sel-box {
    position: absolute;
    border: 1.5px dashed #38bdf8;
    background: rgba(56,189,248,.07);
    pointer-events: none;
    z-index: 50;
    display: none;
}
</style>
@endpush

@section('content')
<div class="editor-wrap" id="editor-wrap">

    <!-- =================== LEFT SIDEBAR: ELEMENTS =================== -->
    <div class="sidebar-panel" id="left-sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.template.index') }}" class="text-slate-400 hover:text-white transition-colors">
                <i class="fa fa-arrow-left text-xs"></i>
            </a>
            <h2>🎨 Studio Kanvas</h2>
            <span class="text-xs text-slate-500 truncate max-w-[80px]" title="{{ $template->nama_template }}">{{ Str::limit($template->nama_template, 12) }}</span>
        </div>

        <div class="tab-bar">
            <div class="tab-btn active" onclick="switchTab('elements')">Elemen</div>
            <div class="tab-btn" onclick="switchTab('layers')">Layer</div>
            <div class="tab-btn" onclick="switchTab('settings')">Pengaturan</div>
        </div>

        <!-- ELEMENTS TAB -->
        <div class="tab-content active sidebar-scroll" id="tab-elements">
            <div class="prop-label">Klik untuk memilih elemen</div>
            <div id="el-list">
                <!-- diisi JS -->
            </div>
        </div>

        <!-- LAYERS TAB -->
        <div class="tab-content sidebar-scroll" id="tab-layers">
            <div class="prop-label">Urutan Layer (atas = depan)</div>
            <div id="layer-list"></div>
        </div>

        <!-- SETTINGS TAB -->
        <div class="tab-content sidebar-scroll" id="tab-settings">
            <div class="prop-label">Template</div>
            <div class="text-xs text-slate-400 mb-2">{{ $template->nama_template }}</div>
            <div class="prop-label">Orientasi Kertas</div>
            <select id="set-orientasi" class="prop-input" onchange="setOrientasi(this.value)">
                <option value="landscape" {{ $template->orientasi === 'landscape' ? 'selected' : '' }}>Landscape (A4)</option>
                <option value="portrait" {{ $template->orientasi === 'portrait' ? 'selected' : '' }}>Portrait (A4)</option>
            </select>
            <div class="prop-label">Warna Primer</div>
            <input type="color" id="set-warna-primer" value="{{ $template->warna_primer ?? '#1e3a8a' }}" class="prop-input h-9" oninput="updateGlobalStyle()">
            <div class="prop-label">Warna Teks</div>
            <input type="color" id="set-warna-teks" value="{{ $template->warna_teks ?? '#1f2937' }}" class="prop-input h-9" oninput="updateGlobalStyle()">
            <div class="prop-label">Background Blanko</div>
            <div class="text-xs text-slate-500 mb-2">Upload di <a href="{{ route('admin.template.edit', $template) }}" class="text-sky-400 hover:underline">Edit Template</a></div>
            @if($template->file_gambar_depan)
            <div class="text-xs text-green-400"><i class="fa fa-check-circle mr-1"></i>Gambar blanko terpasang</div>
            @endif
            <div class="prop-label mt-4">Tampilkan Elemen</div>
            <label class="flex items-center gap-2 text-xs text-slate-400 mb-1 cursor-pointer">
                <input type="checkbox" id="set-qr" {{ $template->tampilkan_qr_code ? 'checked' : '' }} onchange="toggleElVisibility('qr_block', this.checked)">
                Kode QR
            </label>
            <label class="flex items-center gap-2 text-xs text-slate-400 mb-1 cursor-pointer">
                <input type="checkbox" id="set-garis" {{ $template->tampilkan_garis_tepi ? 'checked' : '' }} onchange="toggleElVisibility('divider', this.checked)">
                Garis Pembatas
            </label>
        </div>
    </div>

    <!-- =================== CENTER CANVAS =================== -->
    <div class="canvas-area">
        <div class="canvas-toolbar">
            <button class="toolbar-btn" onclick="zoomCanvas(-0.1)" title="Zoom Out"><i class="fa fa-minus"></i></button>
            <span class="zoom-label" id="zoom-label">75%</span>
            <button class="toolbar-btn" onclick="zoomCanvas(0.1)" title="Zoom In"><i class="fa fa-plus"></i></button>
            <button class="toolbar-btn" onclick="resetZoom()" title="Fit to Screen"><i class="fa fa-expand-arrows-alt"></i> Fit</button>
            <div style="width:1px;height:20px;background:#334155;margin:0 4px;"></div>
            <button class="toolbar-btn" onclick="undoAction()" title="Undo (Ctrl+Z)"><i class="fa fa-undo"></i></button>
            <button class="toolbar-btn" onclick="redoAction()" title="Redo (Ctrl+Y)"><i class="fa fa-redo"></i></button>
            <div style="width:1px;height:20px;background:#334155;margin:0 4px;"></div>
            <button class="toolbar-btn" onclick="alignSelected('center-h')" title="Center Horizontal"><i class="fa fa-align-center"></i></button>
            <button class="toolbar-btn" onclick="alignSelected('center-v')" title="Center Vertical"><i class="fa fa-arrows-alt-v"></i></button>
            <div style="width:1px;height:20px;background:#334155;margin:0 4px;"></div>
            <button class="toolbar-btn success" onclick="saveCanvas()" id="btn-save">
                <i class="fa fa-save"></i> Simpan Layout
            </button>
            <a href="{{ route('sertifikat.cetak', 'preview') }}" target="_blank" class="toolbar-btn primary">
                <i class="fa fa-print"></i> Preview Cetak
            </a>
            <div class="save-status">
                <div class="save-dot" id="save-dot"></div>
                <span id="save-label">Belum disimpan</span>
            </div>
        </div>

        <div class="canvas-scroll" id="canvas-scroll">
            <div id="canvas-wrapper" style="transform-origin: top center;">
                <div id="cert-canvas" class="{{ $template->orientasi === 'portrait' ? 'portrait' : '' }}">
                    <!-- Background image -->
                    @if($template->file_gambar_depan)
                    <img id="canvas-bg" src="{{ asset($template->file_gambar_depan) }}" alt="Blanko">
                    @else
                    <div id="canvas-bg" style="position:absolute;inset:0;background:linear-gradient(135deg,#f8fafc 0%,#e2e8f0 100%);z-index:0;"></div>
                    @endif

                    <!-- Selection box -->
                    <div id="sel-box"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- =================== RIGHT PROPERTIES PANEL =================== -->
    <div class="props-panel" id="right-panel">
        <div class="props-header">⚙️ Properti Elemen</div>
        <div class="props-scroll" id="props-content">
            <div class="text-xs text-slate-500 mt-4 text-center">
                <i class="fa fa-mouse-pointer text-2xl mb-2 block text-slate-600"></i>
                Pilih elemen di kanvas untuk mengatur propertinya
            </div>
        </div>
    </div>

</div>

<!-- Toast Notification -->
<div id="toast"></div>
@endsection

@push('scripts')
{{-- interact.js for drag + resize --}}
<script src="https://cdn.jsdelivr.net/npm/interactjs@1.10.27/dist/interact.min.js"></script>

<script>
/* ========================================================
   BGTK Certificate Studio — Canvas Editor v2.0
   Canva-style drag, resize, inline edit, auto-save
   ======================================================== */

// ---- CONFIG ----
const CANVAS_W = 1123; // px (A4 landscape at 96dpi)
const CANVAS_H = 794;
const CANVAS_W_P = 794; // portrait
const CANVAS_H_P = 1123;
const TEMPLATE_ID = {{ $template->id }};
const SAVE_URL = "{{ route('admin.template.saveCanvas', $template) }}";
const CSRF = "{{ csrf_token() }}";
const BG_IMAGE = @json($template->file_gambar_depan ? asset($template->file_gambar_depan) : null);
const WARNA_PRIMER = "{{ $template->warna_primer ?? '#1e3a8a' }}";
const WARNA_TEKS = "{{ $template->warna_teks ?? '#1f2937' }}";
const FONT_NAMA = "{{ $template->font_nama ?? 'Montserrat' }}";
const FONT_TEKS = "{{ $template->font_teks ?? 'Plus Jakarta Sans' }}";

// ---- STATE ----
let elements = {}; // { id: { x, y, w, h, fontSize, fontFamily, color, text, visible, zIndex, ... } }
let selectedId = null;
let zoomLevel = 0.75;
let undoStack = [];
let redoStack = [];
let isDirty = false;
let saveTimer = null;
let dragStartState = null;

// ---- DEFAULT ELEMENT DEFINITIONS ----
const defaultElements = {
    kop_logo: {
        label: 'Logo Instansi', icon: 'fa-image',
        x: 40, y: 24, w: 70, h: 70,
        type: 'image', visible: true, zIndex: 5,
        imgSrc: null, altText: 'LOGO',
        borderRadius: 0,
    },
    kop_instansi: {
        label: 'Nama Instansi', icon: 'fa-building',
        x: 120, y: 24, w: 480, h: 70,
        type: 'text', visible: true, zIndex: 5,
        text: 'PEMERINTAH PROVINSI LAMPUNG\nBALAI GURU PENGGERAK TEKNOLOGI DAN KEJURUAN',
        fontSize: 13, fontFamily: 'Montserrat', fontWeight: '700',
        color: WARNA_PRIMER, align: 'left', lineHeight: 1.4,
    },
    divider: {
        label: 'Garis Pembatas', icon: 'fa-minus',
        x: 40, y: 100, w: 1040, h: 4,
        type: 'shape', shape: 'line', visible: true, zIndex: 4,
        bgColor: '#c9a84c', borderRadius: 2,
    },
    judul: {
        label: 'Judul Sertifikat', icon: 'fa-certificate',
        x: 40, y: 120, w: 1040, h: 60,
        type: 'text', visible: true, zIndex: 5,
        text: 'SERTIFIKAT', fontSize: 42, fontFamily: FONT_NAMA,
        fontWeight: '800', color: WARNA_PRIMER, align: 'center',
        letterSpacing: 8,
    },
    subjudul: {
        label: 'Sub Judul', icon: 'fa-heading',
        x: 40, y: 180, w: 1040, h: 28,
        type: 'text', visible: true, zIndex: 5,
        text: 'KEIKUTSERTAAN', fontSize: 14, fontFamily: FONT_TEKS,
        fontWeight: '600', color: '#6b7280', align: 'center', letterSpacing: 4,
    },
    penerima_label: {
        label: 'Label Diberikan Kepada', icon: 'fa-tag',
        x: 40, y: 220, w: 1040, h: 24,
        type: 'text', visible: true, zIndex: 5,
        text: 'Diberikan kepada:', fontSize: 12, fontFamily: FONT_TEKS,
        fontWeight: '400', color: '#6b7280', align: 'center',
    },
    nama_peserta: {
        label: 'Nama Peserta', icon: 'fa-user',
        x: 40, y: 248, w: 1040, h: 56,
        type: 'text', visible: true, zIndex: 5,
        text: 'Nama Peserta Pelatihan', fontSize: 36, fontFamily: FONT_NAMA,
        fontWeight: '700', color: WARNA_PRIMER, align: 'center',
        isPlaceholder: true,
    },
    identitas: {
        label: 'Identitas Peserta', icon: 'fa-id-card',
        x: 40, y: 308, w: 1040, h: 24,
        type: 'text', visible: true, zIndex: 5,
        text: 'NIP. — | Instansi — | Kabupaten/Kota —',
        fontSize: 11, fontFamily: FONT_TEKS, fontWeight: '400',
        color: '#6b7280', align: 'center',
    },
    narasi: {
        label: 'Narasi / Body Teks', icon: 'fa-align-justify',
        x: 100, y: 342, w: 920, h: 68,
        type: 'text', visible: true, zIndex: 5,
        text: 'atas keikutsertaan dan partisipasi aktifnya dalam kegiatan Pelatihan / Bimbingan Teknis yang diselenggarakan oleh Balai Guru Penggerak Teknologi dan Kejuruan Provinsi Lampung.',
        fontSize: 11, fontFamily: FONT_TEKS, fontWeight: '400',
        color: WARNA_TEKS, align: 'center', lineHeight: 1.7,
    },
    nama_kegiatan: {
        label: 'Nama Kegiatan', icon: 'fa-graduation-cap',
        x: 100, y: 418, w: 920, h: 32,
        type: 'text', visible: true, zIndex: 5,
        text: '"Nama Kegiatan Pelatihan / Bimtek"', fontSize: 14,
        fontFamily: FONT_NAMA, fontWeight: '700', color: WARNA_PRIMER,
        align: 'center', isPlaceholder: true,
    },
    tanggal_kegiatan: {
        label: 'Tanggal Kegiatan', icon: 'fa-calendar',
        x: 100, y: 455, w: 920, h: 22,
        type: 'text', visible: true, zIndex: 5,
        text: 'Bandarlampung, Tanggal — Bulan — Tahun', fontSize: 11,
        fontFamily: FONT_TEKS, fontWeight: '400', color: '#6b7280', align: 'center',
    },
    ttd_block: {
        label: 'Blok TTD Pejabat', icon: 'fa-signature',
        x: 700, y: 490, w: 300, h: 100,
        type: 'text', visible: true, zIndex: 5,
        text: 'Kepala BGTK Provinsi Lampung\n\n\n\nNama Pejabat, M.Pd.\nNIP. 196XXXXXXXXXX',
        fontSize: 11, fontFamily: FONT_TEKS, fontWeight: '400',
        color: WARNA_TEKS, align: 'center',
    },
    ttd_foto: {
        label: 'Foto / Stempel TTD', icon: 'fa-stamp',
        x: 756, y: 505, w: 90, h: 70,
        type: 'image', visible: true, zIndex: 6,
        imgSrc: null, altText: 'TTD/STEMPEL',
        borderRadius: 0, opacity: 0.7,
    },
    qr_block: {
        label: 'QR Code Verifikasi', icon: 'fa-qrcode',
        x: 48, y: 500, w: 90, h: 90,
        type: 'qr', visible: {{ $template->tampilkan_qr_code ? 'true' : 'false' }}, zIndex: 5,
        text: 'QR', fontSize: 10, fontFamily: FONT_TEKS,
        color: '#374151', labelText: 'Scan untuk verifikasi',
    },
    nomor_sertifikat: {
        label: 'Nomor Sertifikat', icon: 'fa-hashtag',
        x: 100, y: 480, w: 500, h: 20,
        type: 'text', visible: true, zIndex: 5,
        text: 'No: 0001/BGTK-LPG/PP.01.07/2026', fontSize: 10,
        fontFamily: FONT_TEKS, fontWeight: '400', color: '#9ca3af', align: 'center',
    },
};

// Merge saved layout from DB with defaults
const savedLayout = @json($template->layout_json ?? null);
if (savedLayout && typeof savedLayout === 'object') {
    // Merge DB layout over defaults
    Object.keys(defaultElements).forEach(id => {
        elements[id] = Object.assign({}, defaultElements[id], savedLayout[id] || {});
    });
    // Add any extra elements saved in DB not in defaults
    Object.keys(savedLayout).forEach(id => {
        if (!elements[id]) elements[id] = savedLayout[id];
    });
} else {
    elements = JSON.parse(JSON.stringify(defaultElements));
}

// =========================================
//  RENDER ENGINE
// =========================================
const canvas = document.getElementById('cert-canvas');

function renderAll() {
    // Remove all existing cert-el divs
    canvas.querySelectorAll('.cert-el').forEach(el => el.remove());
    Object.keys(elements).forEach(id => renderEl(id));
    renderElementList();
    renderLayerList();
}

function renderEl(id) {
    const el = elements[id];
    if (!el) return;

    let div = document.createElement('div');
    div.className = 'cert-el' + (selectedId === id ? ' selected' : '');
    div.id = 'el-' + id;
    div.dataset.elId = id;
    div.style.left = el.x + 'px';
    div.style.top = el.y + 'px';
    div.style.width = el.w + 'px';
    div.style.height = el.h + 'px';
    div.style.zIndex = el.zIndex || 5;
    div.style.display = el.visible === false ? 'none' : 'flex';
    div.style.opacity = el.opacity !== undefined ? el.opacity : 1;

    // Inner content
    let inner = '';
    if (el.type === 'text') {
        const lines = (el.text || '').replace(/\\n/g, '\n').split('\n');
        inner = lines.map(l => `<div style="
            font-size:${el.fontSize || 12}px;
            font-family:'${el.fontFamily || FONT_TEKS}',sans-serif;
            font-weight:${el.fontWeight || '400'};
            color:${el.color || WARNA_TEKS};
            text-align:${el.align || 'left'};
            letter-spacing:${el.letterSpacing ? el.letterSpacing + 'px' : 'normal'};
            line-height:${el.lineHeight || 1.5};
            width:100%;
            white-space:pre-wrap;
            pointer-events:none;
        ">${l || '&nbsp;'}</div>`).join('');
    } else if (el.type === 'shape') {
        div.style.background = el.bgColor || WARNA_PRIMER;
        div.style.borderRadius = (el.borderRadius || 0) + 'px';
    } else if (el.type === 'image') {
        if (el.imgSrc) {
            inner = `<img src="${el.imgSrc}" style="width:100%;height:100%;object-fit:contain;border-radius:${el.borderRadius||0}px;pointer-events:none;" alt="${el.altText||''}">`;
        } else {
            div.style.border = '1.5px dashed #94a3b8';
            div.style.borderRadius = (el.borderRadius || 0) + 'px';
            inner = `<div style="width:100%;text-align:center;color:#64748b;font-size:11px;pointer-events:none;">
                <i class="fa fa-image" style="font-size:18px;display:block;margin-bottom:4px;"></i>${el.altText||'Gambar'}
            </div>`;
        }
    } else if (el.type === 'qr') {
        inner = `<div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;">
            <div style="width:70%;aspect-ratio:1;background:#f1f5f9;border:2px solid #94a3b8;border-radius:4px;display:flex;align-items:center;justify-content:center;">
                <i class="fa fa-qrcode" style="font-size:28px;color:#374151;"></i>
            </div>
            <div style="font-size:9px;color:#6b7280;margin-top:3px;text-align:center;">${el.labelText||'Scan untuk verifikasi'}</div>
        </div>`;
    }

    div.innerHTML = inner;

    // Resize handles (shown only when selected)
    if (selectedId === id) {
        ['nw','n','ne','w','e','sw','s','se'].forEach(pos => {
            const h = document.createElement('div');
            h.className = `resize-handle ${pos}`;
            h.dataset.handle = pos;
            div.appendChild(h);
        });
    }

    // Events
    div.addEventListener('click', (e) => {
        e.stopPropagation();
        selectEl(id);
    });
    div.addEventListener('dblclick', (e) => {
        e.stopPropagation();
        startInlineEdit(id);
    });

    canvas.appendChild(div);
    attachInteract(div, id);
}

// =========================================
//  INTERACT.JS — DRAG + RESIZE
// =========================================
function attachInteract(div, id) {
    interact(div)
        .draggable({
            listeners: {
                start(event) {
                    dragStartState = JSON.parse(JSON.stringify(elements[id]));
                    selectEl(id);
                },
                move(event) {
                    const el = elements[id];
                    el.x = Math.max(0, Math.min(getCanvasW() - el.w, Math.round(el.x + event.dx)));
                    el.y = Math.max(0, Math.min(getCanvasH() - el.h, Math.round(el.y + event.dy)));
                    const domEl = document.getElementById('el-' + id);
                    if (domEl) {
                        domEl.style.left = el.x + 'px';
                        domEl.style.top = el.y + 'px';
                    }
                    updatePropsPanel();
                    markDirty();
                },
                end(event) {
                    if (dragStartState) {
                        pushUndo(id, dragStartState);
                        dragStartState = null;
                    }
                    scheduleAutoSave();
                }
            },
            modifiers: [
                interact.modifiers.snap({
                    targets: [interact.snappers.grid({ x: 4, y: 4 })],
                    range: 8,
                    relativePoints: [{ x: 0, y: 0 }]
                }),
            ],
        })
        .resizable({
            edges: { left: '.resize-handle.w, .resize-handle.nw, .resize-handle.sw',
                     right: '.resize-handle.e, .resize-handle.ne, .resize-handle.se',
                     bottom: '.resize-handle.s, .resize-handle.sw, .resize-handle.se',
                     top: '.resize-handle.n, .resize-handle.nw, .resize-handle.ne' },
            listeners: {
                start(event) { dragStartState = JSON.parse(JSON.stringify(elements[id])); },
                move(event) {
                    const el = elements[id];
                    el.w = Math.max(30, Math.round(event.rect.width));
                    el.h = Math.max(16, Math.round(event.rect.height));
                    el.x = Math.max(0, Math.round(event.rect.left - canvas.getBoundingClientRect().left));
                    el.y = Math.max(0, Math.round(event.rect.top - canvas.getBoundingClientRect().top));
                    const domEl = document.getElementById('el-' + id);
                    if (domEl) {
                        domEl.style.width = el.w + 'px';
                        domEl.style.height = el.h + 'px';
                        domEl.style.left = el.x + 'px';
                        domEl.style.top = el.y + 'px';
                    }
                    updatePropsPanel();
                    markDirty();
                },
                end(event) {
                    if (dragStartState) { pushUndo(id, dragStartState); dragStartState = null; }
                    scheduleAutoSave();
                }
            },
            modifiers: [
                interact.modifiers.restrictSize({ min: { width: 30, height: 16 } })
            ],
        });
}

// =========================================
//  SELECTION
// =========================================
function selectEl(id) {
    selectedId = id;
    document.querySelectorAll('.cert-el').forEach(e => e.classList.remove('selected'));
    const domEl = document.getElementById('el-' + id);
    if (domEl) domEl.classList.add('selected');
    // Re-render to show resize handles
    const old = document.getElementById('el-' + id);
    if (old) old.remove();
    renderEl(id);
    updatePropsPanel();
    renderElementList();
}

canvas.addEventListener('click', (e) => {
    if (e.target === canvas || e.target.id === 'canvas-bg' || e.target.id === 'sel-box') {
        selectedId = null;
        document.querySelectorAll('.cert-el').forEach(e => e.classList.remove('selected'));
        canvas.querySelectorAll('.resize-handle').forEach(h => h.remove());
        updatePropsPanel();
        renderElementList();
    }
});

// =========================================
//  INLINE TEXT EDITING
// =========================================
function startInlineEdit(id) {
    const el = elements[id];
    if (el.type !== 'text') return;

    const domEl = document.getElementById('el-' + id);
    if (!domEl) return;

    // Replace inner with a contenteditable div
    domEl.innerHTML = `<div contenteditable="true" id="inline-edit-${id}" style="
        width:100%;height:100%;
        font-size:${el.fontSize||12}px;
        font-family:'${el.fontFamily||FONT_TEKS}',sans-serif;
        font-weight:${el.fontWeight||'400'};
        color:${el.color||WARNA_TEKS};
        text-align:${el.align||'left'};
        outline:2px solid #38bdf8;
        border-radius:3px;
        padding:2px 4px;
        box-sizing:border-box;
        white-space:pre-wrap;
        line-height:${el.lineHeight||1.5};
        pointer-events:all;
        cursor:text;
        min-height:16px;
        background:rgba(255,255,255,.92);
        overflow:hidden;
    ">${el.text||''}</div>`;

    const editor = document.getElementById(`inline-edit-${id}`);
    editor.focus();

    // Select all
    const range = document.createRange();
    range.selectNodeContents(editor);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);

    function finishEdit() {
        const newText = editor.innerText;
        if (newText !== el.text) {
            pushUndo(id, JSON.parse(JSON.stringify(el)));
            el.text = newText;
            markDirty();
            scheduleAutoSave();
        }
        // Re-render
        const old = document.getElementById('el-' + id);
        if (old) old.remove();
        renderEl(id);
        updatePropsPanel();
    }

    editor.addEventListener('blur', finishEdit);
    editor.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') { editor.blur(); }
    });
}

// =========================================
//  PROPERTIES PANEL
// =========================================
function updatePropsPanel() {
    const panel = document.getElementById('props-content');
    if (!selectedId || !elements[selectedId]) {
        panel.innerHTML = `<div class="text-xs text-slate-500 mt-4 text-center">
            <i class="fa fa-mouse-pointer text-2xl mb-2 block text-slate-600"></i>
            Pilih elemen di kanvas untuk mengatur propertinya
        </div>`;
        return;
    }
    const el = elements[selectedId];
    panel.innerHTML = buildPropsHTML(selectedId, el);
}

function buildPropsHTML(id, el) {
    return `
    <div class="prop-label">${el.label || id}</div>
    <div class="text-xs text-slate-500 mb-3">${el.type === 'text' ? 'Teks' : el.type === 'image' ? 'Gambar' : el.type === 'shape' ? 'Bentuk' : el.type}</div>

    <div class="prop-label">Posisi & Ukuran</div>
    <div class="prop-row">
        <div>
            <div style="font-size:10px;color:#64748b;margin-bottom:3px;">X (px)</div>
            <input type="number" class="prop-input" value="${Math.round(el.x)}" onchange="updateElProp('${id}','x',+this.value)" style="width:88px;">
        </div>
        <div>
            <div style="font-size:10px;color:#64748b;margin-bottom:3px;">Y (px)</div>
            <input type="number" class="prop-input" value="${Math.round(el.y)}" onchange="updateElProp('${id}','y',+this.value)" style="width:88px;">
        </div>
    </div>
    <div class="prop-row" style="margin-top:5px;">
        <div>
            <div style="font-size:10px;color:#64748b;margin-bottom:3px;">Lebar (px)</div>
            <input type="number" class="prop-input" value="${Math.round(el.w)}" onchange="updateElProp('${id}','w',+this.value)" style="width:88px;">
        </div>
        <div>
            <div style="font-size:10px;color:#64748b;margin-bottom:3px;">Tinggi (px)</div>
            <input type="number" class="prop-input" value="${Math.round(el.h)}" onchange="updateElProp('${id}','h',+this.value)" style="width:88px;">
        </div>
    </div>

    ${el.type === 'text' ? `
    <div class="prop-label">Teks</div>
    <textarea class="prop-input" rows="3" style="resize:vertical;" onchange="updateElProp('${id}','text',this.value)">${el.text||''}</textarea>

    <div class="prop-label">Font</div>
    <select class="prop-input" onchange="updateElProp('${id}','fontFamily',this.value)">
        ${['Montserrat','Plus Jakarta Sans','Cinzel','Playfair Display','Great Vibes','Georgia','Arial'].map(f =>
            `<option value="${f}" ${el.fontFamily===f?'selected':''}>${f}</option>`
        ).join('')}
    </select>
    <div class="prop-row" style="margin-top:5px;">
        <div>
            <div style="font-size:10px;color:#64748b;margin-bottom:3px;">Ukuran</div>
            <input type="number" class="prop-input" value="${el.fontSize||12}" min="6" max="120" onchange="updateElProp('${id}','fontSize',+this.value)" style="width:88px;">
        </div>
        <div>
            <div style="font-size:10px;color:#64748b;margin-bottom:3px;">Tebal</div>
            <select class="prop-input" onchange="updateElProp('${id}','fontWeight',this.value)" style="width:88px;">
                ${['300','400','500','600','700','800','900'].map(w =>
                    `<option value="${w}" ${el.fontWeight===w?'selected':''}>${w}</option>`
                ).join('')}
            </select>
        </div>
    </div>
    <div class="prop-label">Warna Teks</div>
    <input type="color" class="prop-input h-9" value="${el.color||'#1f2937'}" onchange="updateElProp('${id}','color',this.value)">
    <div class="prop-label">Perataan</div>
    <div style="display:flex;gap:4px;margin-bottom:8px;">
        ${['left','center','right','justify'].map(a =>
            `<button onclick="updateElProp('${id}','align','${a}')" style="flex:1;padding:4px;border-radius:5px;border:1px solid #334155;background:${el.align===a?'#1d4ed8':'#0f172a'};color:${el.align===a?'#fff':'#94a3b8'};font-size:11px;cursor:pointer;">
                <i class="fa fa-align-${a==='justify'?'justify':a}"></i>
            </button>`
        ).join('')}
    </div>
    <div class="prop-label">Letter Spacing</div>
    <input type="number" class="prop-input" value="${el.letterSpacing||0}" step="0.5" onchange="updateElProp('${id}','letterSpacing',+this.value)">
    <div class="prop-label">Line Height</div>
    <input type="number" class="prop-input" value="${el.lineHeight||1.5}" step="0.1" min="1" max="3" onchange="updateElProp('${id}','lineHeight',+this.value)">
    ` : ''}

    ${el.type === 'shape' ? `
    <div class="prop-label">Warna</div>
    <input type="color" class="prop-input h-9" value="${el.bgColor||WARNA_PRIMER}" onchange="updateElProp('${id}','bgColor',this.value)">
    <div class="prop-label">Border Radius</div>
    <input type="number" class="prop-input" value="${el.borderRadius||0}" min="0" max="100" onchange="updateElProp('${id}','borderRadius',+this.value)">
    ` : ''}

    ${el.type === 'image' ? `
    <div class="prop-label">URL Gambar</div>
    <input type="text" class="prop-input" placeholder="https://..." value="${el.imgSrc||''}" onchange="updateElProp('${id}','imgSrc',this.value)">
    <div class="prop-label">Border Radius</div>
    <input type="number" class="prop-input" value="${el.borderRadius||0}" min="0" max="200" onchange="updateElProp('${id}','borderRadius',+this.value)">
    ` : ''}

    <div class="prop-label">Transparansi</div>
    <input type="range" class="prop-input" value="${Math.round((el.opacity!==undefined?el.opacity:1)*100)}" min="0" max="100" oninput="updateElProp('${id}','opacity',+this.value/100);this.nextElementSibling.textContent=this.value+'%'">
    <span style="font-size:11px;color:#64748b;">${Math.round((el.opacity!==undefined?el.opacity:1)*100)}%</span>

    <div class="prop-label">Z-Index (Layer)</div>
    <input type="number" class="prop-input" value="${el.zIndex||5}" min="1" max="99" onchange="updateElProp('${id}','zIndex',+this.value)">

    <div class="prop-label">Visibilitas</div>
    <label style="display:flex;align-items:center;gap:8px;font-size:12px;color:#94a3b8;cursor:pointer;">
        <input type="checkbox" ${el.visible!==false?'checked':''} onchange="updateElProp('${id}','visible',this.checked)">
        Tampilkan elemen
    </label>

    <div style="margin-top:16px;display:flex;gap:6px;">
        <button onclick="duplicateEl('${id}')" class="toolbar-btn" style="flex:1;justify-content:center;">
            <i class="fa fa-copy"></i> Duplikat
        </button>
        <button onclick="deleteEl('${id}')" class="toolbar-btn" style="flex:1;justify-content:center;color:#f87171;border-color:#991b1b;">
            <i class="fa fa-trash"></i> Hapus
        </button>
    </div>`;
}

function updateElProp(id, prop, value) {
    if (!elements[id]) return;
    pushUndo(id, JSON.parse(JSON.stringify(elements[id])));
    elements[id][prop] = value;
    // Re-render
    const old = document.getElementById('el-' + id);
    if (old) old.remove();
    renderEl(id);
    if (selectedId === id) selectEl(id);
    markDirty();
    scheduleAutoSave();
}

// =========================================
//  ELEMENT LIST (LEFT SIDEBAR)
// =========================================
function renderElementList() {
    const list = document.getElementById('el-list');
    list.innerHTML = Object.keys(elements).map(id => {
        const el = elements[id];
        const isSelected = selectedId === id;
        return `<div class="el-item ${isSelected?'active':''}" onclick="selectEl('${id}')">
            <div class="el-icon"><i class="fa ${el.icon||'fa-square'}"></i></div>
            <span style="flex:1;truncate">${el.label||id}</span>
            <span class="el-vis" onclick="event.stopPropagation();toggleElVisibility('${id}',${el.visible===false?'true':'false'})" title="${el.visible!==false?'Sembunyikan':'Tampilkan'}">
                <i class="fa ${el.visible!==false?'fa-eye':'fa-eye-slash'}" style="color:${el.visible!==false?'#64748b':'#334155'};font-size:11px;"></i>
            </span>
        </div>`;
    }).join('');
}

function renderLayerList() {
    const list = document.getElementById('layer-list');
    // Sort by zIndex desc
    const sorted = Object.keys(elements).sort((a,b) => (elements[b].zIndex||5)-(elements[a].zIndex||5));
    list.innerHTML = sorted.map((id,i) => {
        const el = elements[id];
        return `<div class="el-item" onclick="selectEl('${id}')">
            <span style="font-size:10px;color:#475569;width:16px;text-align:center;">${el.zIndex||5}</span>
            <div class="el-icon"><i class="fa ${el.icon||'fa-square'}"></i></div>
            <span style="flex:1;">${el.label||id}</span>
        </div>`;
    }).join('');
}

// =========================================
//  VISIBILITY TOGGLE
// =========================================
function toggleElVisibility(id, show) {
    if (!elements[id]) return;
    elements[id].visible = show;
    const domEl = document.getElementById('el-' + id);
    if (domEl) domEl.style.display = show ? 'flex' : 'none';
    renderElementList();
    markDirty();
    scheduleAutoSave();
}

// =========================================
//  DUPLICATE & DELETE
// =========================================
function duplicateEl(id) {
    const src = elements[id];
    const newId = id + '_copy_' + Date.now().toString(36);
    elements[newId] = Object.assign({}, JSON.parse(JSON.stringify(src)), {
        x: src.x + 20, y: src.y + 20,
        label: (src.label || id) + ' (kopi)',
    });
    renderAll();
    selectEl(newId);
    markDirty();
    showToast('Elemen diduplikat!', 'info');
}

function deleteEl(id) {
    if (!confirm('Hapus elemen ini dari kanvas?')) return;
    delete elements[id];
    selectedId = null;
    renderAll();
    updatePropsPanel();
    markDirty();
    scheduleAutoSave();
    showToast('Elemen dihapus', 'info');
}

// =========================================
//  ZOOM
// =========================================
function zoomCanvas(delta) {
    zoomLevel = Math.max(0.2, Math.min(2, zoomLevel + delta));
    applyZoom();
}
function resetZoom() {
    const scrollW = document.getElementById('canvas-scroll').clientWidth;
    const canvasW = getCanvasW();
    zoomLevel = Math.min(1, (scrollW - 64) / canvasW);
    applyZoom();
}
function applyZoom() {
    const wrapper = document.getElementById('canvas-wrapper');
    wrapper.style.transform = `scale(${zoomLevel})`;
    wrapper.style.marginBottom = `${(getCanvasH() * zoomLevel) - getCanvasH() + 32}px`;
    document.getElementById('zoom-label').textContent = Math.round(zoomLevel * 100) + '%';
}
function getCanvasW() {
    return document.getElementById('cert-canvas').classList.contains('portrait') ? CANVAS_W_P : CANVAS_W;
}
function getCanvasH() {
    return document.getElementById('cert-canvas').classList.contains('portrait') ? CANVAS_H_P : CANVAS_H;
}

// =========================================
//  ORIENTATION
// =========================================
function setOrientasi(val) {
    const cv = document.getElementById('cert-canvas');
    if (val === 'portrait') cv.classList.add('portrait');
    else cv.classList.remove('portrait');
    resetZoom();
}

// =========================================
//  ALIGN
// =========================================
function alignSelected(mode) {
    if (!selectedId || !elements[selectedId]) return;
    const el = elements[selectedId];
    if (mode === 'center-h') el.x = Math.round((getCanvasW() - el.w) / 2);
    if (mode === 'center-v') el.y = Math.round((getCanvasH() - el.h) / 2);
    const domEl = document.getElementById('el-' + selectedId);
    if (domEl) {
        domEl.style.left = el.x + 'px';
        domEl.style.top = el.y + 'px';
    }
    updatePropsPanel();
    markDirty();
    scheduleAutoSave();
}

// =========================================
//  UNDO / REDO
// =========================================
function pushUndo(id, prevState) {
    undoStack.push({ id, state: prevState });
    if (undoStack.length > 50) undoStack.shift();
    redoStack = [];
}
function undoAction() {
    if (!undoStack.length) return;
    const {id, state} = undoStack.pop();
    if (elements[id]) redoStack.push({ id, state: JSON.parse(JSON.stringify(elements[id])) });
    elements[id] = state;
    const old = document.getElementById('el-' + id);
    if (old) old.remove();
    renderEl(id);
    if (selectedId === id) selectEl(id);
    markDirty();
}
function redoAction() {
    if (!redoStack.length) return;
    const {id, state} = redoStack.pop();
    if (elements[id]) undoStack.push({ id, state: JSON.parse(JSON.stringify(elements[id])) });
    elements[id] = state;
    const old = document.getElementById('el-' + id);
    if (old) old.remove();
    renderEl(id);
    if (selectedId === id) selectEl(id);
    markDirty();
}

// =========================================
//  DIRTY / AUTO-SAVE
// =========================================
function markDirty() {
    isDirty = true;
    document.getElementById('save-dot').className = 'save-dot saving';
    document.getElementById('save-label').textContent = 'Ada perubahan...';
}
function scheduleAutoSave() {
    clearTimeout(saveTimer);
    saveTimer = setTimeout(saveCanvas, 3000);
}

// =========================================
//  SAVE TO SERVER
// =========================================
async function saveCanvas() {
    clearTimeout(saveTimer);
    document.getElementById('save-dot').className = 'save-dot saving';
    document.getElementById('save-label').textContent = 'Menyimpan...';
    document.getElementById('btn-save').disabled = true;

    try {
        const resp = await fetch(SAVE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ layout_json: JSON.stringify(elements) })
        });
        const data = await resp.json();
        if (data.success) {
            isDirty = false;
            document.getElementById('save-dot').className = 'save-dot saved';
            document.getElementById('save-label').textContent = 'Tersimpan ✓';
            showToast('Layout berhasil disimpan!', 'success');
        } else {
            throw new Error(data.message || 'Gagal menyimpan');
        }
    } catch (err) {
        document.getElementById('save-dot').className = 'save-dot';
        document.getElementById('save-label').textContent = 'Gagal simpan!';
        showToast('Gagal menyimpan: ' + err.message, 'error');
    } finally {
        document.getElementById('btn-save').disabled = false;
    }
}

// =========================================
//  TOAST
// =========================================
function showToast(msg, type = 'info') {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = `show ${type}`;
    setTimeout(() => t.className = '', 3000);
}

// =========================================
//  TAB SWITCHING
// =========================================
function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach((b, i) => {
        const tabs = ['elements','layers','settings'];
        b.classList.toggle('active', tabs[i] === tab);
    });
    document.querySelectorAll('.tab-content').forEach(c => {
        c.classList.toggle('active', c.id === 'tab-' + tab);
    });
}

// =========================================
//  GLOBAL STYLE UPDATE
// =========================================
function updateGlobalStyle() {
    const primer = document.getElementById('set-warna-primer').value;
    const teks = document.getElementById('set-warna-teks').value;
    // Update all text elements that use the primer color
    // (Just update props panel, full re-render on save)
}

// =========================================
//  KEYBOARD SHORTCUTS
// =========================================
document.addEventListener('keydown', (e) => {
    // Ignore when inside an input
    if (['INPUT','TEXTAREA','SELECT'].includes(e.target.tagName)) return;
    if (e.ctrlKey && e.key === 'z') { e.preventDefault(); undoAction(); }
    if (e.ctrlKey && e.key === 'y') { e.preventDefault(); redoAction(); }
    if (e.ctrlKey && e.key === 's') { e.preventDefault(); saveCanvas(); }
    if (e.ctrlKey && e.key === 'd') { e.preventDefault(); if(selectedId) duplicateEl(selectedId); }
    if (e.key === 'Delete' || e.key === 'Backspace') {
        if (selectedId) { e.preventDefault(); deleteEl(selectedId); }
    }
    // Arrow keys to nudge
    if (selectedId && ['ArrowUp','ArrowDown','ArrowLeft','ArrowRight'].includes(e.key)) {
        e.preventDefault();
        const step = e.shiftKey ? 10 : 1;
        const el = elements[selectedId];
        if (e.key === 'ArrowUp') el.y = Math.max(0, el.y - step);
        if (e.key === 'ArrowDown') el.y = Math.min(getCanvasH()-el.h, el.y + step);
        if (e.key === 'ArrowLeft') el.x = Math.max(0, el.x - step);
        if (e.key === 'ArrowRight') el.x = Math.min(getCanvasW()-el.w, el.x + step);
        const domEl = document.getElementById('el-' + selectedId);
        if (domEl) { domEl.style.left = el.x + 'px'; domEl.style.top = el.y + 'px'; }
        updatePropsPanel();
        markDirty();
        scheduleAutoSave();
    }
    if (e.key === 'Escape') {
        selectedId = null;
        document.querySelectorAll('.cert-el').forEach(e => e.classList.remove('selected'));
        canvas.querySelectorAll('.resize-handle').forEach(h => h.remove());
        updatePropsPanel();
        renderElementList();
    }
});

// =========================================
//  INIT
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    renderAll();
    resetZoom();

    // Warn before leaving if dirty
    window.addEventListener('beforeunload', (e) => {
        if (isDirty) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    showToast('Kanvas Editor siap! Klik elemen untuk memilih, geser untuk memindahkan.', 'info');
});
</script>
@endpush

