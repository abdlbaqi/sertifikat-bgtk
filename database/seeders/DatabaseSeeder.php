<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use App\Models\MateriKegiatan;
use App\Models\Sertifikat;
use App\Models\TemplateSertifikat;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin BGTK Lampung
        User::updateOrCreate(
            ['email' => 'admin@bgtklampung.go.id'],
            [
                'name' => 'Administrator BGTK Lampung',
                'password' => bcrypt('password123'),
            ]
        );

        // 2. Data Template Sertifikat (CMS Template)
        $templateEmas = TemplateSertifikat::updateOrCreate(
            ['kode_template' => 'tpl-emas-bgtk'],
            [
                'nama_template' => 'Template Emas Resmi BGTK Lampung',
                'orientasi' => 'landscape',
                'font_nama' => 'Montserrat',
                'font_teks' => 'Plus Jakarta Sans',
                'warna_primer' => '#1e3a8a', // Biru Dongker Kemendikbud
                'warna_teks' => '#1f2937',
                'tampilkan_garis_tepi' => true,
                'tampilkan_qr_code' => true,
                'posisi_elemen' => [
                    'nama_peserta' => ['font_size' => '32px', 'font_weight' => 'bold', 'color' => '#1e3a8a'],
                    'nomor_sertifikat' => ['font_size' => '14px', 'color' => '#4b5563'],
                    'qr_code' => ['posisi' => 'kiri_bawah', 'ukuran' => 90],
                    'tanda_tangan' => ['posisi' => 'kanan_bawah'],
                ],
                'status_aktif' => true,
                'is_bawaan' => true,
                'deskripsi' => 'Desain sertifikat kedinasan formal standar Kemendikbudristek dengan ornamen emas elegan untuk Bimtek dan Diklat resmi.',
            ]
        );

        $templateModern = TemplateSertifikat::updateOrCreate(
            ['kode_template' => 'tpl-modern-webinar'],
            [
                'nama_template' => 'Template Modern Webinar Guru',
                'orientasi' => 'landscape',
                'font_nama' => 'Playfair Display',
                'font_teks' => 'Inter',
                'warna_primer' => '#0f766e', // Teal / Tosca Modern
                'warna_teks' => '#111827',
                'tampilkan_garis_tepi' => true,
                'tampilkan_qr_code' => true,
                'posisi_elemen' => [
                    'nama_peserta' => ['font_size' => '30px', 'font_weight' => 'bold', 'color' => '#0f766e'],
                    'nomor_sertifikat' => ['font_size' => '14px', 'color' => '#374151'],
                ],
                'status_aktif' => true,
                'is_bawaan' => false,
                'deskripsi' => 'Desain sertifikat modern minimalis cocok untuk kegiatan seminar online, workshop singkat, dan webinar series BGTK Lampung.',
            ]
        );

        // 3. Data Kegiatan / Pelatihan BGTK Lampung
        $kegiatan = Kegiatan::updateOrCreate(
            ['kode_kegiatan' => 'BGTK-2026-BIMTEK-01'],
            [
                'template_id' => $templateEmas->id,
                'nama_kegiatan' => 'Bimbingan Teknis Implementasi Pembelajaran Berdiferensiasi Guru Penggerak',
                'slug' => 'bimtek-pembelajaran-berdiferensiasi-2026',
                'jenis_kegiatan' => 'Bimtek',
                'penyelenggara' => 'Balai Guru dan Tenaga Kependidikan Provinsi Lampung',
                'tanggal_mulai' => '2026-03-02',
                'tanggal_selesai' => '2026-03-05',
                'jumlah_jam' => 32,
                'tanggal_sertifikat' => '2026-03-05',
                'nama_penandatangan' => 'Dr. H. Ahmad Fauzan, M.Pd.',
                'nip_penandatangan' => '197508142000031002',
                'jabatan_penandatangan' => 'Kepala Balai Guru dan Tenaga Kependidikan Provinsi Lampung',
                'deskripsi' => 'Kegiatan peningkatan kompetensi guru dalam merancang dan mempraktikkan pembelajaran berdiferensiasi di satuan pendidikan wilayah Provinsi Lampung.',
                'status_terbit' => true,
            ]
        );

        // 4. Struktur Materi & JP (Halaman Belakang Sertifikat)
        $daftarMateri = [
            ['nama_materi' => 'Kebijakan Transformasi Pendidikan Ditjen GTK', 'jumlah_jam' => 4, 'urutan' => 1],
            ['nama_materi' => 'Konsep dan Prinsip Pembelajaran Berdiferensiasi', 'jumlah_jam' => 6, 'urutan' => 2],
            ['nama_materi' => 'Pemetaan Kebutuhan Belajar & Asesmen Awal Peserta Didik', 'jumlah_jam' => 8, 'urutan' => 3],
            ['nama_materi' => 'Pengembangan Modul Ajar dan Strategi Diferensiasi (Konten, Proses, Produk)', 'jumlah_jam' => 10, 'urutan' => 4],
            ['nama_materi' => 'Refleksi Praktik Baik dan Rencana Tindak Lanjut (RTL)', 'jumlah_jam' => 4, 'urutan' => 5],
        ];

        foreach ($daftarMateri as $materi) {
            MateriKegiatan::updateOrCreate(
                ['kegiatan_id' => $kegiatan->id, 'nama_materi' => $materi['nama_materi']],
                ['jumlah_jam' => $materi['jumlah_jam'], 'urutan' => $materi['urutan']]
            );
        }

        // 5. Data Sertifikat Peserta
        $daftarPeserta = [
            [
                'nama' => 'Siti Rahmawati, S.Pd., Gr.',
                'identitas' => '198804152011012009',
                'instansi' => 'SMAN 1 Bandar Lampung',
                'kabupaten_kota' => 'Kota Bandar Lampung',
                'email' => 'siti.rahmawati@guru.sma.belajar.id',
                'peran' => 'Peserta',
                'nomor_sertifikat' => '001/BGTK-LPG/PP.01.07/2026',
                'kode_verifikasi' => 'BGTK-7A8B9C',
            ],
            [
                'nama' => 'Budi Santoso, M.Pd.',
                'identitas' => '198207192008011015',
                'instansi' => 'SMPN 2 Kalianda',
                'kabupaten_kota' => 'Kabupaten Lampung Selatan',
                'email' => 'budi.santoso@guru.smp.belajar.id',
                'peran' => 'Peserta',
                'nomor_sertifikat' => '002/BGTK-LPG/PP.01.07/2026',
                'kode_verifikasi' => 'BGTK-4D5E6F',
            ],
            [
                'nama' => 'Dewi Anggraini, S.Pd.',
                'identitas' => '199203112019032014',
                'instansi' => 'SDN 1 Metro Pusat',
                'kabupaten_kota' => 'Kota Metro',
                'email' => 'dewi.anggraini@guru.sd.belajar.id',
                'peran' => 'Peserta',
                'nomor_sertifikat' => '003/BGTK-LPG/PP.01.07/2026',
                'kode_verifikasi' => 'BGTK-1X2Y3Z',
            ],
        ];

        foreach ($daftarPeserta as $p) {
            Sertifikat::updateOrCreate(
                ['nomor_sertifikat' => $p['nomor_sertifikat']],
                [
                    'kegiatan_id' => $kegiatan->id,
                    'kode_verifikasi' => $p['kode_verifikasi'],
                    'nama_peserta' => $p['nama'],
                    'nomor_identitas' => $p['identitas'],
                    'instansi' => $p['instansi'],
                    'kabupaten_kota' => $p['kabupaten_kota'],
                    'email' => $p['email'],
                    'peran' => $p['peran'],
                    'status' => 'aktif',
                ]
            );
        }
    }
}
