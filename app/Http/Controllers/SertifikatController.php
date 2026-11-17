<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Sertifikat;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    /**
     * Halaman Beranda & Pencarian Sertifikat Publik BGTK Lampung
     */
    public function index(Request $request)
    {
        $kataKunci = trim($request->get('q', ''));
        $hasilPencarian = null;

        if (!empty($kataKunci)) {
            $hasilPencarian = Sertifikat::with(['kegiatan.template'])
                ->where(function ($query) use ($kataKunci) {
                    $query->where('nomor_sertifikat', 'LIKE', "%{$kataKunci}%")
                          ->orWhere('nomor_identitas', 'LIKE', "%{$kataKunci}%")
                          ->orWhere('nama_peserta', 'LIKE', "%{$kataKunci}%")
                          ->orWhere('kode_verifikasi', 'LIKE', "%{$kataKunci}%");
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        // Statistik ringkas BGTK Lampung
        $totalSertifikat = Sertifikat::where('status', 'aktif')->count();
        $totalKegiatan = Kegiatan::where('status_terbit', true)->count();
        $totalJamPelajaran = Kegiatan::where('status_terbit', true)->sum('jumlah_jam');

        // Daftar kegiatan terbaru
        $kegiatanTerbaru = Kegiatan::where('status_terbit', true)
            ->withCount('sertifikat')
            ->latest('tanggal_mulai')
            ->take(6)
            ->get();

        return view('sertifikat.beranda', compact(
            'kataKunci',
            'hasilPencarian',
            'totalSertifikat',
            'totalKegiatan',
            'totalJamPelajaran',
            'kegiatanTerbaru'
        ));
    }

    /**
     * Halaman Verifikasi Keaslian Sertifikat (Akses via QR Code atau URL Validasi)
     */
    public function verifikasi(string $kode)
    {
        $sertifikat = Sertifikat::with(['kegiatan.materi', 'kegiatan.template'])
            ->where('kode_verifikasi', $kode)
            ->orWhere('nomor_sertifikat', $kode)
            ->first();

        if (!$sertifikat) {
            return response()->view('sertifikat.tidak_ditemukan', [
                'kode' => $kode,
            ], 404);
        }

        return view('sertifikat.verifikasi', compact('sertifikat'));
    }

    /**
     * Tampilan Preview & Cetak Sertifikat Digital Resmi (A4 Landscape Print Ready)
     */
    public function cetak(string $kode)
    {
        $sertifikat = Sertifikat::with(['kegiatan.materi', 'kegiatan.template'])
            ->where('kode_verifikasi', $kode)
            ->orWhere('nomor_sertifikat', $kode)
            ->firstOrFail();

        // Tambah hitungan unduhan
        $sertifikat->increment('jumlah_unduh');

        return view('sertifikat.cetak', compact('sertifikat'));
    }
}
