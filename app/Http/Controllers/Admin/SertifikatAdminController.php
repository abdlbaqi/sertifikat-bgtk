<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Sertifikat;
use App\Models\TemplateSertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SertifikatAdminController extends Controller
{
    /**
     * Tampilkan data sertifikat di panel admin
     */
    public function index(Request $request)
    {
        $kegiatanId = $request->get('kegiatan_id');
        $q = $request->get('q');

        $query = Sertifikat::with(['kegiatan.template'])->latest();

        if ($kegiatanId) {
            $query->where('kegiatan_id', $kegiatanId);
        }

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_peserta', 'LIKE', "%{$q}%")
                    ->orWhere('nomor_identitas', 'LIKE', "%{$q}%")
                    ->orWhere('nomor_sertifikat', 'LIKE', "%{$q}%")
                    ->orWhere('kode_verifikasi', 'LIKE', "%{$q}%");
            });
        }

        $sertifikat = $query->paginate(20)->withQueryString();
        $daftarKegiatan = Kegiatan::orderBy('nama_kegiatan')->get();

        return view('admin.sertifikat.index', compact('sertifikat', 'daftarKegiatan', 'kegiatanId', 'q'));
    }

    /**
     * Halaman Generator Sertifikat Masal (Input Nama Sekaligus Banyak)
     */
    public function generator(Request $request)
    {
        $daftarKegiatan = Kegiatan::with('template')->latest()->get();
        $daftarTemplate = TemplateSertifikat::where('status_aktif', true)->get();
        $selectedKegiatanId = $request->get('kegiatan_id');

        return view('admin.sertifikat.generator', compact('daftarKegiatan', 'daftarTemplate', 'selectedKegiatanId'));
    }

    /**
     * Proses Generate Sertifikat Sekaligus (Bulk Input / Import Masal)
     */
    public function prosesMasal(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'peran_default' => 'required|string',
            'data_teks' => 'nullable|string',
            'file_csv' => 'nullable|file|mimes:csv,txt|max:4096',
        ]);

        $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);

        // Kumpulkan baris dari textarea atau file
        $lines = [];

        if ($request->hasFile('file_csv')) {
            $content = file_get_contents($request->file('file_csv')->getRealPath());
            $lines = preg_split('/\r\n|\r|\n/', trim($content));
        } elseif (!empty($request->data_teks)) {
            $lines = preg_split('/\r\n|\r|\n/', trim($request->data_teks));
        }

        if (empty($lines)) {
            return back()->with('error', 'Silakan tempel daftar nama peserta atau unggah berkas CSV.');
        }

        $tahun = date('Y');
        $currentCount = Sertifikat::whereYear('created_at', $tahun)->count();
        $totalBerhasil = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Dukung pemisah: pipe (|), titik koma (;), atau tab (\t)
            $cols = [];
            if (str_contains($line, '|')) {
                $cols = array_map('trim', explode('|', $line));
            } elseif (str_contains($line, ';')) {
                $cols = array_map('trim', explode(';', $line));
            } elseif (str_contains($line, "\t")) {
                $cols = array_map('trim', explode("\t", $line));
            } else {
                // Baris hanya berisi nama peserta
                $cols = [$line];
            }

            $nama = $cols[0] ?? null;
            if (!$nama) continue;

            // Abaikan header jika ada
            if (in_array(strtolower($nama), ['nama', 'nama peserta', 'nama lengkap'])) continue;

            $nip = $cols[1] ?? null;
            $instansi = $cols[2] ?? null;
            $kabupaten = $cols[3] ?? null;

            $currentCount++;
            $nomorSertifikat = sprintf('%04d/BGTK-LPG/PP.01.07/%s', $currentCount, $tahun);
            $kodeVerifikasi = 'BGTK-' . strtoupper(Str::random(6));

            Sertifikat::create([
                'kegiatan_id' => $kegiatan->id,
                'nomor_sertifikat' => $nomorSertifikat,
                'kode_verifikasi' => $kodeVerifikasi,
                'nama_peserta' => $nama,
                'nomor_identitas' => $nip,
                'instansi' => $instansi,
                'kabupaten_kota' => $kabupaten,
                'peran' => $request->peran_default ?? 'Peserta',
                'status' => 'aktif',
            ]);

            $totalBerhasil++;
        }

        return redirect()->route('admin.sertifikat.index', ['kegiatan_id' => $kegiatan->id])
            ->with('sukses', "Berhasil membuat {$totalBerhasil} sertifikat sekaligus untuk kegiatan {$kegiatan->nama_kegiatan}!");
    }

    /**
     * Cetak Semua Sertifikat Sekaligus dalam 1 Dokumen Multi-Halaman (Batch Print)
     */
    public function cetakMasal($kegiatanId)
    {
        $kegiatan = Kegiatan::with(['template', 'materi', 'sertifikat' => function ($q) {
            $q->where('status', 'aktif')->orderBy('id');
        }])->findOrFail($kegiatanId);

        if ($kegiatan->sertifikat->isEmpty()) {
            return back()->with('error', 'Belum ada peserta di kegiatan ini untuk dicetak.');
        }

        return view('admin.sertifikat.cetak_masal', compact('kegiatan'));
    }

    /**
     * Form tambah satu sertifikat
     */
    public function create()
    {
        $daftarKegiatan = Kegiatan::where('status_terbit', true)->get();
        return view('admin.sertifikat.form', [
            'sertifikat' => new Sertifikat([
                'peran' => 'Peserta',
                'status' => 'aktif',
            ]),
            'daftarKegiatan' => $daftarKegiatan,
            'isEdit' => false,
        ]);
    }

    /**
     * Simpan satu sertifikat
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'nama_peserta' => 'required|string|max:255',
            'nomor_identitas' => 'nullable|string|max:50',
            'instansi' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'peran' => 'required|string|max:50',
            'nomor_sertifikat' => 'nullable|string|max:100|unique:sertifikat,nomor_sertifikat',
        ]);

        if (empty($validated['nomor_sertifikat'])) {
            $tahun = date('Y');
            $count = Sertifikat::whereYear('created_at', $tahun)->count() + 1;
            $validated['nomor_sertifikat'] = sprintf('%04d/BGTK-LPG/PP.01.07/%s', $count, $tahun);
        }

        $validated['kode_verifikasi'] = 'BGTK-' . strtoupper(Str::random(6));
        $validated['status'] = 'aktif';

        Sertifikat::create($validated);

        return redirect()->route('admin.sertifikat.index')->with('sukses', 'Sertifikat peserta baru berhasil dibuat!');
    }

    /**
     * Form edit sertifikat
     */
    public function edit(Sertifikat $sertifikat)
    {
        $daftarKegiatan = Kegiatan::orderBy('nama_kegiatan')->get();
        return view('admin.sertifikat.form', [
            'sertifikat' => $sertifikat,
            'daftarKegiatan' => $daftarKegiatan,
            'isEdit' => true,
        ]);
    }

    /**
     * Update sertifikat
     */
    public function update(Request $request, Sertifikat $sertifikat)
    {
        $validated = $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'nama_peserta' => 'required|string|max:255',
            'nomor_identitas' => 'nullable|string|max:50',
            'instansi' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'peran' => 'required|string|max:50',
            'nomor_sertifikat' => 'required|string|max:100|unique:sertifikat,nomor_sertifikat,' . $sertifikat->id,
            'status' => 'required|in:aktif,dicabut',
            'alasan_dicabut' => 'nullable|string',
        ]);

        $sertifikat->update($validated);

        return redirect()->route('admin.sertifikat.index')->with('sukses', 'Data sertifikat berhasil diperbarui!');
    }

    /**
     * Hapus sertifikat
     */
    public function destroy(Sertifikat $sertifikat)
    {
        $sertifikat->delete();
        return redirect()->route('admin.sertifikat.index')->with('sukses', 'Sertifikat berhasil dihapus.');
    }
}
