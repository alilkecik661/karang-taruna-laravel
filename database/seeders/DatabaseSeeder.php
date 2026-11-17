<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Banner;
use App\Models\Berita;
use App\Models\Bidang;
use App\Models\Foto;
use App\Models\Kegiatan;
use App\Models\Pengaturan;
use App\Models\Pengurus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database website Karang Taruna 04 (KARUPAT) beserta 1 akun Superadmin dan 18 Pengurus/Anggota.
     */
    public function run(): void
    {
        // 1. Buat Bidang Program & Seksi Kepengurusan
        $bidangList = [
            'Konsumsi' => 'Pengelolaan konsumsi dan logistik jamuan pada setiap kegiatan Karang Taruna 04.',
            'Dokumentasi' => 'Publikasi, fotografi, videografi, dan arsip dokumentasi kegiatan organisasi.',
            'Humas' => 'Hubungan masyarakat, komunikasi warga, serta kemitraan lingkungan.',
            'Perlengkapan' => 'Penyediaan sarana, prasarana, dan perlengkapan teknis kegiatan lapangan (Perlap).',
            'Sosial dan lingkungan' => 'Bakti sosial, kerja bakti bersih lingkungan, dan kepedulian warga.',
            'Olahraga' => 'Turnamen olahraga, kebugaran pemuda, dan kegiatan kepemudaan.',
        ];

        $bidangMap = [];
        foreach ($bidangList as $nama => $deskripsi) {
            $bidangMap[$nama] = Bidang::updateOrCreate(
                ['nama' => $nama],
                ['deskripsi' => $deskripsi]
            );
        }

        // 2. Buat 1 Akun Admin Utama (Superadmin)
        $admin = User::updateOrCreate(
            ['email' => 'admin@karangtaruna.or.id'],
            [
                'name' => 'Administrator Karang Taruna',
                'password' => Hash::make('AdminKT2026!'),
                'role' => 'superadmin',
                'bidang_id' => null,
                'email_verified_at' => now(),
            ]
        );

        // 3. Pengaturan Website Default
        foreach (Pengaturan::defaultValues() as $kunci => $nilai) {
            Pengaturan::updateOrCreate(
                ['kunci' => $kunci],
                ['nilai' => $nilai]
            );
        }

        // 4. Struktur Pengurus & Anggota KARUPAT (18 Anggota Resmi)
        Pengurus::query()->delete();

        $pengurusData = [
            ['nama' => 'Bobi', 'jabatan' => 'Ketua Karang Taruna', 'bidang_id' => null, 'urutan' => 1],
            ['nama' => 'Kevin', 'jabatan' => 'Wakil Ketua Kartar', 'bidang_id' => null, 'urutan' => 2],
            ['nama' => 'Kekey', 'jabatan' => 'Sekretaris 1', 'bidang_id' => null, 'urutan' => 3],
            ['nama' => 'Salma', 'jabatan' => 'Bendahara 1', 'bidang_id' => null, 'urutan' => 4],
            ['nama' => 'Naura', 'jabatan' => 'Bendahara 2', 'bidang_id' => null, 'urutan' => 5],
            ['nama' => 'Sany', 'jabatan' => 'Bendahara 3', 'bidang_id' => null, 'urutan' => 6],
            ['nama' => 'Ema', 'jabatan' => 'Konsumsi 1', 'bidang_id' => $bidangMap['Konsumsi']->id, 'urutan' => 7],
            ['nama' => 'Nasya', 'jabatan' => 'Konsumsi 2', 'bidang_id' => $bidangMap['Konsumsi']->id, 'urutan' => 8],
            ['nama' => 'Amira', 'jabatan' => 'Konsumsi 3', 'bidang_id' => $bidangMap['Konsumsi']->id, 'urutan' => 9],
            ['nama' => 'Kania', 'jabatan' => 'Dokumentasi 1', 'bidang_id' => $bidangMap['Dokumentasi']->id, 'urutan' => 10],
            ['nama' => 'Loly', 'jabatan' => 'Dokumentasi 2', 'bidang_id' => $bidangMap['Dokumentasi']->id, 'urutan' => 11],
            ['nama' => 'Pais', 'jabatan' => 'Humas 1', 'bidang_id' => $bidangMap['Humas']->id, 'urutan' => 12],
            ['nama' => 'Dapi', 'jabatan' => 'Humas 2', 'bidang_id' => $bidangMap['Humas']->id, 'urutan' => 13],
            ['nama' => 'Athar', 'jabatan' => 'Perlap 1', 'bidang_id' => $bidangMap['Perlengkapan']->id, 'urutan' => 14],
            ['nama' => 'Ian', 'jabatan' => 'Perlap 2', 'bidang_id' => $bidangMap['Perlengkapan']->id, 'urutan' => 15],
            ['nama' => 'Wildan', 'jabatan' => 'Perlap 3', 'bidang_id' => $bidangMap['Perlengkapan']->id, 'urutan' => 16],
            ['nama' => 'Pinsen', 'jabatan' => 'Perlap 4', 'bidang_id' => $bidangMap['Perlengkapan']->id, 'urutan' => 17],
            ['nama' => 'Ikhsan', 'jabatan' => 'Perlap 5', 'bidang_id' => $bidangMap['Perlengkapan']->id, 'urutan' => 18],
        ];

        foreach ($pengurusData as $item) {
            Pengurus::create(array_merge($item, ['is_aktif' => true]));
        }

        // 5. Kegiatan
        $kegiatan1 = Kegiatan::updateOrCreate(
            ['slug' => 'bakti-sosial-bersih-lingkungan'],
            [
                'judul' => 'Bakti Sosial Bersih Lingkungan',
                'bidang_id' => $bidangMap['Sosial dan lingkungan']->id,
                'deskripsi' => "Gotong royong membersihkan saluran air dan lingkungan setempat bersama warga dan pemuda Karang Taruna 04 (KARUPAT).\n\nKegiatan ini bertujuan menjaga kebersihan lingkungan menjelang musim penghujan sekaligus mempererat kebersamaan warga.",
                'tanggal_mulai' => '2026-11-20 07:00:00',
                'tanggal_selesai' => '2026-11-20 11:30:00',
                'lokasi' => 'Balai Desa',
                'status' => 'publish',
                'created_by' => $admin->id,
            ]
        );

        $kegiatan2 = Kegiatan::updateOrCreate(
            ['slug' => 'lomba-futsal-antar-rt'],
            [
                'judul' => 'Lomba Futsal Antar RT',
                'bidang_id' => $bidangMap['Olahraga']->id,
                'deskripsi' => "Turnamen persahabatan untuk pemuda dari seluruh RT di wilayah kami.\n\nMari junjung tinggi sportivitas dan perkuat silaturahmi antar pemuda lingkungan.",
                'tanggal_mulai' => '2026-12-05 08:00:00',
                'tanggal_selesai' => '2026-12-06 17:00:00',
                'lokasi' => 'Lapangan Serbaguna',
                'status' => 'publish',
                'created_by' => $admin->id,
            ]
        );

        $kegiatan3 = Kegiatan::updateOrCreate(
            ['slug' => 'pelatihan-digital-untuk-umkm'],
            [
                'judul' => 'Pelatihan Digital untuk UMKM',
                'bidang_id' => $bidangMap['Humas']->id,
                'deskripsi' => "Pelatihan pemasaran daring dasar bagi pelaku usaha kecil di sekitar lingkungan.\n\nPeserta akan mempelajari cara membuat foto produk menarik, mengelola katalog media sosial, serta melayani pembeli secara profesional.",
                'tanggal_mulai' => '2026-12-17 13:00:00',
                'tanggal_selesai' => '2026-12-17 16:30:00',
                'lokasi' => 'Aula Kelurahan',
                'status' => 'publish',
                'created_by' => $admin->id,
            ]
        );

        // 6. Berita
        Berita::updateOrCreate(
            ['slug' => 'pendaftaran-anggota-baru-dibuka'],
            [
                'judul' => 'Pendaftaran Anggota Baru Dibuka',
                'isi' => "Pemuda usia produktif di lingkungan kami dapat mendaftar secara online melalui formulir di website resmi Karang Taruna 04 (KARUPAT).\n\nMari bergabung dan berkontribusi bersama kepengurusan KARUPAT.",
                'is_pinned' => true,
                'status' => 'publish',
                'published_at' => '2026-11-11 08:00:00',
                'created_by' => $admin->id,
            ]
        );

        Berita::updateOrCreate(
            ['slug' => 'hasil-musyawarah-kerja'],
            [
                'judul' => 'Hasil Musyawarah Kerja',
                'isi' => "Musyawarah menyepakati tiga program prioritas untuk periode berjalan, yaitu program bersih lingkungan bulanan, pembinaan olahraga pemuda, serta pelatihan literasi digital bagi warga.",
                'is_pinned' => false,
                'status' => 'publish',
                'published_at' => '2026-11-02 10:00:00',
                'created_by' => $admin->id,
            ]
        );

        // 7. Album & Foto Galeri
        $album1 = Album::updateOrCreate(
            ['slug' => 'dokumentasi-bakti-sosial'],
            [
                'judul' => 'Dokumentasi Bakti Sosial',
                'deskripsi' => 'Rangkaian kegiatan kerja bakti dan kebersihan lingkungan bersama pemuda dan warga.',
                'kegiatan_id' => $kegiatan1->id,
                'created_by' => $admin->id,
            ]
        );

        $album2 = Album::updateOrCreate(
            ['slug' => 'musyawarah-kerja-dan-pelatihan'],
            [
                'judul' => 'Musyawarah Kerja dan Pelatihan',
                'deskripsi' => 'Dokumentasi rapat koordinasi pengurus serta pelatihan keterampilan pemuda.',
                'kegiatan_id' => $kegiatan3->id,
                'created_by' => $admin->id,
            ]
        );

        $sampleFotos1 = [
            ['path' => 'images/sample-1.svg', 'caption' => 'Kerja bakti membersihkan lingkungan warga (contoh)', 'urutan' => 1],
            ['path' => 'images/sample-2.svg', 'caption' => 'Koordinasi lapangan tim pemuda Karang Taruna (contoh)', 'urutan' => 2],
            ['path' => 'images/sample-3.svg', 'caption' => 'Penanaman pohon penghijauan di sekitar balai desa (contoh)', 'urutan' => 3],
        ];
        foreach ($sampleFotos1 as $f) {
            Foto::updateOrCreate(
                ['album_id' => $album1->id, 'urutan' => $f['urutan']],
                $f
            );
        }

        $sampleFotos2 = [
            ['path' => 'images/sample-4.svg', 'caption' => 'Diskusi program kerja tahunan Karang Taruna (contoh)', 'urutan' => 1],
            ['path' => 'images/sample-5.svg', 'caption' => 'Sesi materi pelatihan pemasaran digital UMKM (contoh)', 'urutan' => 2],
            ['path' => 'images/sample-6.svg', 'caption' => 'Foto bersama peserta dan pengurus kegiatan (contoh)', 'urutan' => 3],
        ];
        foreach ($sampleFotos2 as $f) {
            Foto::updateOrCreate(
                ['album_id' => $album2->id, 'urutan' => $f['urutan']],
                $f
            );
        }

        // 8. Banner Beranda
        Banner::updateOrCreate(
            ['urutan' => 1],
            [
                'judul' => 'Bersama pemuda, membangun lingkungan yang lebih berdaya',
                'subjudul' => 'KARUPAT · Karang Taruna 04',
                'tautan' => '/daftar',
                'is_aktif' => true,
            ]
        );
    }
}
