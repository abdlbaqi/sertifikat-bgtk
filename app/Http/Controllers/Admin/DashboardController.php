<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Sertifikat;
use App\Models\TemplateSertifikat;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Admin BGTK Lampung
     */
    public function index()
    {
        $totalSertifikat = Sertifikat::where('status', 'aktif')->count();
        $totalKegiatan = Kegiatan::count();
        $totalTemplate = TemplateSertifikat::count();
        $totalUnduh = Sertifikat::sum('jumlah_unduh');
        $totalJamPelajaran = Kegiatan::sum('jumlah_jam');

        $kegiatanTerbaru = Kegiatan::with(['template'])->withCount('sertifikat')->latest()->take(5)->get();
        $sertifikatTerbaru = Sertifikat::with(['kegiatan'])->latest()->take(5)->get();
        $templates = TemplateSertifikat::withCount('kegiatan')->latest()->take(3)->get();

        return view('admin.dashboard', compact(
            'totalSertifikat',
            'totalKegiatan',
            'totalTemplate',
            'totalUnduh',
            'totalJamPelajaran',
            'kegiatanTerbaru',
            'sertifikatTerbaru',
            'templates'
        ));
    }
}

