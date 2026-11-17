<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\TemplateSertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KegiatanController extends Controller
{
    /**
     * Tampilkan daftar kegiatan pelatihan BGTK Lampung
     */
    public function index()
    {
        $kegiatan = Kegiatan::with(['template'])->withCount('sertifikat')->latest()->paginate(10);
        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    /**
     * Form tambah kegiatan baru
     */
    public function create()
    {
        $templates = TemplateSertifikat::where('status_aktif', true)->get();
        return view('admin.kegiatan.form', [
            'kegiatan' => new Kegiatan([
                'jenis_kegiatan' => 'Bimtek',
                'penyelenggara' => 'Balai Guru dan Tenaga Kependidikan Provinsi Lampung',
                'jabatan_penandatangan' => 'Kepala Balai Guru dan Tenaga Kependidikan Provinsi Lampung',
                'nama_penandatangan' => 'Dr. H. Ahmad Fauzan, M.Pd.',
                'nip_penandatangan' => '197508142000031002',
                'status_terbit' => true,
            ]),
            'templates' => $templates,
            'isEdit' => false,
        ]);
    }

    /**
     * Simpan kegiatan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'kode_kegiatan' => 'required|string|max:100|unique:kegiatan,kode_kegiatan',
            'jenis_kegiatan' => 'required|string',
            'template_id' => 'nullable|exists:template_sertifikat,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah_jam' => 'nullable|integer|min:1',
            'tanggal_sertifikat' => 'nullable|date',
            'nama_penandatangan' => 'nullable|string|max:255',
            'nip_penandatangan' => 'nullable|string|max:100',
            'jabatan_penandatangan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['nama_kegiatan']) . '-' . Str::random(4);
        $validated['status_terbit'] = $request->has('status_terbit');

        Kegiatan::create($validated);

        return redirect()->route('admin.kegiatan.index')->with('sukses', 'Kegiatan pelatihan baru berhasil ditambahkan!');
    }

    /**
     * Form edit kegiatan
     */
    public function edit(Kegiatan $kegiatan)
    {
        $templates = TemplateSertifikat::where('status_aktif', true)->get();
        return view('admin.kegiatan.form', [
            'kegiatan' => $kegiatan,
            'templates' => $templates,
            'isEdit' => true,
        ]);
    }

    /**
     * Update kegiatan
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'kode_kegiatan' => 'required|string|max:100|unique:kegiatan,kode_kegiatan,' . $kegiatan->id,
            'jenis_kegiatan' => 'required|string',
            'template_id' => 'nullable|exists:template_sertifikat,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah_jam' => 'nullable|integer|min:1',
            'tanggal_sertifikat' => 'nullable|date',
            'nama_penandatangan' => 'nullable|string|max:255',
            'nip_penandatangan' => 'nullable|string|max:100',
            'jabatan_penandatangan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['status_terbit'] = $request->has('status_terbit');

        $kegiatan->update($validated);

        return redirect()->route('admin.kegiatan.index')->with('sukses', 'Data kegiatan berhasil diperbarui!');
    }

    /**
     * Hapus kegiatan
     */
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();
        return redirect()->route('admin.kegiatan.index')->with('sukses', 'Kegiatan berhasil dihapus.');
    }
}

