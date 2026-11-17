<?php

namespace Tests\Feature;

use App\Mail\KonfirmasiPendaftaranAnggota;
use App\Mail\NotifikasiPendaftaranBaru;
use App\Mail\NotifikasiPesanKontakBaru;
use App\Models\Album;
use App\Models\Berita;
use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Models\PendaftaranAnggota;
use App\Models\PesanKontak;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class KarangTarunaTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_membuat_satu_akun_admin_utama_dan_halaman_publik_tampil(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@karangtaruna.or.id',
            'role' => 'superadmin',
        ]);

        $this->get('/')->assertStatus(200)->assertSee('Karang Taruna');
        $this->get('/tentang')->assertStatus(200);
        $this->get('/kegiatan')->assertStatus(200);
        $this->get('/kegiatan/bakti-sosial-bersih-lingkungan')->assertStatus(200);
        $this->get('/berita')->assertStatus(200);
        $this->get('/berita/pendaftaran-anggota-baru-dibuka')->assertStatus(200);
        $this->get('/galeri')->assertStatus(200);
        $this->get('/galeri/dokumentasi-bakti-sosial')->assertStatus(200);
        $this->get('/daftar')->assertStatus(200);
        $this->get('/daftar/berhasil')->assertStatus(200);
        $this->get('/kontak')->assertStatus(200);
        $this->get('/kebijakan-privasi')->assertStatus(200);
        $this->get('/sitemap.xml')->assertStatus(200);
    }

    public function test_form_pendaftaran_valid_menyimpan_data_dan_mengirim_email(): void
    {
        Mail::fake();

        $response = $this->post('/daftar', [
            'nama_lengkap' => 'Budi Pemuda Contoh',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2002-08-17',
            'no_whatsapp' => '081234567891',
            'alamat' => 'Jl. Pemuda Desa No. 12, RT 03 RW 01',
            'email' => 'budi.contoh@example.com',
            'bidang_minat' => 'Olahraga',
            'website' => '',
        ]);

        $response->assertRedirect(route('daftar.berhasil'));
        $this->assertDatabaseHas('pendaftaran_anggota', [
            'nama_lengkap' => 'Budi Pemuda Contoh',
            'email' => 'budi.contoh@example.com',
            'status' => 'baru',
        ]);

        Mail::assertQueued(NotifikasiPendaftaranBaru::class);
        Mail::assertQueued(KonfirmasiPendaftaranAnggota::class);
    }

    public function test_form_pendaftaran_tidak_valid_ditolak(): void
    {
        $response = $this->post('/daftar', [
            'nama_lengkap' => 'AB',
            'jenis_kelamin' => '',
            'tanggal_lahir' => '',
            'no_whatsapp' => '12345',
            'alamat' => 'Pendek',
        ]);

        $response->assertSessionHasErrors([
            'nama_lengkap',
            'jenis_kelamin',
            'tanggal_lahir',
            'no_whatsapp',
            'alamat',
        ]);
        $this->assertDatabaseCount('pendaftaran_anggota', 0);
    }

    public function test_honeypot_pendaftaran_dan_kontak_menghentikan_spam_diam_diam(): void
    {
        Mail::fake();

        $this->post('/daftar', [
            'nama_lengkap' => 'Bot Spammer',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2000-01-01',
            'no_whatsapp' => '081234567899',
            'alamat' => 'Alamat palsu spammer yang panjang',
            'website' => 'https://spam-bot.example.com',
        ])->assertRedirect(route('daftar.berhasil'));

        $this->assertDatabaseCount('pendaftaran_anggota', 0);

        $this->post('/kontak', [
            'nama' => 'Bot Kontak',
            'email' => 'bot@example.com',
            'isi' => 'Pesan spam promosi otomatis dari bot.',
            'website' => 'https://spam-bot.example.com',
        ])->assertRedirect(route('kontak.create'));

        $this->assertDatabaseCount('pesan_kontak', 0);
        Mail::assertNothingQueued();
    }

    public function test_form_kontak_valid_menyimpan_pesan_dan_mengirim_notifikasi(): void
    {
        Mail::fake();

        $response = $this->post('/kontak', [
            'nama' => 'Siti Warga Contoh',
            'email' => 'siti.contoh@example.com',
            'subjek' => 'Dukungan Kegiatan Desa',
            'isi' => 'Terima kasih atas kegiatan kerja bakti minggu lalu di lingkungan kami.',
            'website' => '',
        ]);

        $response->assertRedirect(route('kontak.create'));
        $this->assertDatabaseHas('pesan_kontak', [
            'nama' => 'Siti Warga Contoh',
            'email' => 'siti.contoh@example.com',
            'sudah_dibaca' => false,
        ]);

        Mail::assertQueued(NotifikasiPesanKontakBaru::class);
    }

    public function test_hak_akses_pengurus_bidang_tidak_bisa_mengubah_milik_bidang_lain_atau_pengaturan(): void
    {
        $bidangOlahraga = Bidang::create(['nama' => 'Olahraga']);
        $bidangSosial = Bidang::create(['nama' => 'Sosial']);

        $superadmin = User::factory()->superadmin()->create();
        $pengurusOlahraga = User::factory()->create([
            'role' => 'pengurus',
            'bidang_id' => $bidangOlahraga->id,
        ]);
        $pengurusSosial = User::factory()->create([
            'role' => 'pengurus',
            'bidang_id' => $bidangSosial->id,
        ]);

        $kegiatanSosial = Kegiatan::factory()->create([
            'judul' => 'Kegiatan Sosial Warga',
            'slug' => 'kegiatan-sosial-warga',
            'bidang_id' => $bidangSosial->id,
            'created_by' => $pengurusSosial->id,
        ]);

        // Pengurus bidang Olahraga tidak boleh mengedit kegiatan milik pengurus bidang Sosial
        $this->actingAs($pengurusOlahraga)
            ->put(route('admin.kegiatan.update', $kegiatanSosial), [
                'judul' => 'Diubah Tanpa Izin',
                'deskripsi' => 'Deskripsi diubah',
                'tanggal_mulai' => now()->format('Y-m-d H:i:s'),
                'lokasi' => 'Balai',
                'status' => 'publish',
            ])
            ->assertStatus(403);

        // Pengurus bidang tidak boleh membuka atau mengubah pengaturan website
        $this->actingAs($pengurusOlahraga)
            ->get(route('admin.pengaturan.edit'))
            ->assertStatus(403);

        $this->actingAs($pengurusOlahraga)
            ->put(route('admin.pengaturan.update'), [
                'nama_organisasi' => 'Diubah Pengurus',
                'teks_logo' => 'KT',
                'alamat' => 'Alamat Baru',
            ])
            ->assertStatus(403);

        // Superadmin dapat mengubah pengaturan website dan mengekspor CSV pendaftar
        $this->actingAs($superadmin)
            ->put(route('admin.pengaturan.update'), [
                'nama_organisasi' => 'Karang Taruna Mandiri',
                'teks_logo' => 'KTM',
                'alamat' => 'Jl. Desa Mandiri No. 1',
            ])
            ->assertRedirect(route('admin.pengaturan.edit'));

        $this->assertDatabaseHas('pengaturan', [
            'kunci' => 'nama_organisasi',
            'nilai' => 'Karang Taruna Mandiri',
        ]);

        PendaftaranAnggota::factory()->create(['nama_lengkap' => 'Anggota Ekspor']);
        $this->actingAs($superadmin)
            ->get(route('admin.pendaftaran.export'))
            ->assertStatus(200);
    }
}
