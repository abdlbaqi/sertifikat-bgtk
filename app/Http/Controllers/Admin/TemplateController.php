<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemplateSertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    /**
     * Tampilkan daftar template sertifikat (CMS Template)
     */
    public function index()
    {
        $templates = TemplateSertifikat::withCount('kegiatan')->latest()->get();
        return view('admin.template.index', compact('templates'));
    }

    /**
     * Form tambah template baru
     */
    public function create()
    {
        return view('admin.template.form', [
            'template' => new TemplateSertifikat([
                'orientasi' => 'landscape',
                'font_nama' => 'Montserrat',
                'font_teks' => 'Plus Jakarta Sans',
                'warna_primer' => '#1e3a8a',
                'warna_teks' => '#1f2937',
                'tampilkan_garis_tepi' => true,
                'tampilkan_qr_code' => true,
                'status_aktif' => true,
            ]),
            'isEdit' => false,
        ]);
    }

    /**
     * Simpan template baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_template' => 'required|string|max:255',
            'orientasi' => 'required|in:landscape,portrait',
            'font_nama' => 'required|string',
            'font_teks' => 'required|string',
            'warna_primer' => 'required|string|max:7',
            'warna_teks' => 'required|string|max:7',
            'deskripsi' => 'nullable|string',
            'file_gambar_depan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_gambar_belakang' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $validated['kode_template'] = 'tpl-' . Str::slug($validated['nama_template']) . '-' . Str::random(4);
        $validated['tampilkan_garis_tepi'] = $request->has('tampilkan_garis_tepi');
        $validated['tampilkan_qr_code'] = $request->has('tampilkan_qr_code');
        $validated['status_aktif'] = $request->has('status_aktif');
        $validated['is_bawaan'] = false;

        // Upload Gambar Blanko Halaman Depan
        if ($request->hasFile('file_gambar_depan')) {
            $file = $request->file('file_gambar_depan');
            $filename = 'depan_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/templates'), $filename);
            $validated['file_gambar_depan'] = 'uploads/templates/' . $filename;
        }

        // Upload Gambar Blanko Halaman Belakang
        if ($request->hasFile('file_gambar_belakang')) {
            $file = $request->file('file_gambar_belakang');
            $filename = 'belakang_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/templates'), $filename);
            $validated['file_gambar_belakang'] = 'uploads/templates/' . $filename;
        }

        TemplateSertifikat::create($validated);

        return redirect()->route('admin.template.index')->with('sukses', 'Template sertifikat baru berhasil ditambahkan!');
    }

    /**
     * Form edit template
     */
    public function edit(TemplateSertifikat $template)
    {
        return view('admin.template.form', [
            'template' => $template,
            'isEdit' => true,
        ]);
    }

    /**
     * Update template di database
     */
    public function update(Request $request, TemplateSertifikat $template)
    {
        $validated = $request->validate([
            'nama_template' => 'required|string|max:255',
            'orientasi' => 'required|in:landscape,portrait',
            'font_nama' => 'required|string',
            'font_teks' => 'required|string',
            'warna_primer' => 'required|string|max:7',
            'warna_teks' => 'required|string|max:7',
            'deskripsi' => 'nullable|string',
            'file_gambar_depan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_gambar_belakang' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $validated['tampilkan_garis_tepi'] = $request->has('tampilkan_garis_tepi');
        $validated['tampilkan_qr_code'] = $request->has('tampilkan_qr_code');
        $validated['status_aktif'] = $request->has('status_aktif');

        // Hapus background jika diminta
        if ($request->has('hapus_gambar_depan')) {
            if ($template->file_gambar_depan && file_exists(public_path($template->file_gambar_depan))) {
                @unlink(public_path($template->file_gambar_depan));
            }
            $validated['file_gambar_depan'] = null;
        } elseif ($request->hasFile('file_gambar_depan')) {
            // Hapus file lama jika ada
            if ($template->file_gambar_depan && file_exists(public_path($template->file_gambar_depan))) {
                @unlink(public_path($template->file_gambar_depan));
            }
            $file = $request->file('file_gambar_depan');
            $filename = 'depan_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/templates'), $filename);
            $validated['file_gambar_depan'] = 'uploads/templates/' . $filename;
        }

        if ($request->has('hapus_gambar_belakang')) {
            if ($template->file_gambar_belakang && file_exists(public_path($template->file_gambar_belakang))) {
                @unlink(public_path($template->file_gambar_belakang));
            }
            $validated['file_gambar_belakang'] = null;
        } elseif ($request->hasFile('file_gambar_belakang')) {
            if ($template->file_gambar_belakang && file_exists(public_path($template->file_gambar_belakang))) {
                @unlink(public_path($template->file_gambar_belakang));
            }
            $file = $request->file('file_gambar_belakang');
            $filename = 'belakang_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/templates'), $filename);
            $validated['file_gambar_belakang'] = 'uploads/templates/' . $filename;
        }

        $template->update($validated);

        return redirect()->route('admin.template.index')->with('sukses', 'Pengaturan template sertifikat berhasil diperbarui!');
    }

    /**
     * Tampilkan Kanvas Editor Drag-and-Drop
     */
    public function canvas(TemplateSertifikat $template)
    {
        return view('admin.template.canvas', compact('template'));
    }

    /**
     * Simpan layout_json dari Kanvas Editor (AJAX)
     */
    public function saveCanvas(Request $request, TemplateSertifikat $template)
    {
        $request->validate([
            'layout_json' => 'required|string',
        ]);

        // Decode & re-encode to ensure valid JSON
        $decoded = json_decode($request->layout_json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['success' => false, 'message' => 'JSON tidak valid'], 422);
        }

        $template->update(['layout_json' => $decoded]);

        return response()->json(['success' => true, 'message' => 'Layout kanvas berhasil disimpan!']);
    }

    /**
     * Hapus template
     */
    public function destroy(TemplateSertifikat $template)
    {
        if ($template->is_bawaan) {
            return redirect()->back()->with('error', 'Template bawaan sistem tidak boleh dihapus.');
        }

        // Hapus file upload terkait
        if ($template->file_gambar_depan && file_exists(public_path($template->file_gambar_depan))) {
            @unlink(public_path($template->file_gambar_depan));
        }
        if ($template->file_gambar_belakang && file_exists(public_path($template->file_gambar_belakang))) {
            @unlink(public_path($template->file_gambar_belakang));
        }

        $template->delete();
        return redirect()->route('admin.template.index')->with('sukses', 'Template sertifikat berhasil dihapus.');
    }
}
