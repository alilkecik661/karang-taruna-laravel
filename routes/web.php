<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaranController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\Admin\PesanKontakController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PublikController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', [PublikController::class, 'beranda'])->name('beranda');
Route::get('/tentang', [PublikController::class, 'tentang'])->name('tentang');
Route::get('/kegiatan', [PublikController::class, 'kegiatanIndex'])->name('kegiatan.index');
Route::get('/kegiatan/{slug}', [PublikController::class, 'kegiatanShow'])->name('kegiatan.show');
Route::get('/berita', [PublikController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{slug}', [PublikController::class, 'beritaShow'])->name('berita.show');
Route::get('/galeri', [PublikController::class, 'galeriIndex'])->name('galeri.index');
Route::get('/galeri/{album}', [PublikController::class, 'galeriShow'])->name('galeri.show');

// Pendaftaran Anggota Online
Route::get('/daftar', [PendaftaranController::class, 'create'])->name('daftar.create');
Route::post('/daftar', [PendaftaranController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('daftar.store');
Route::get('/daftar/berhasil', [PendaftaranController::class, 'berhasil'])->name('daftar.berhasil');

// Kontak
Route::get('/kontak', [KontakController::class, 'create'])->name('kontak.create');
Route::post('/kontak', [KontakController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('kontak.store');

// Kebijakan Privasi (UU PDP No. 27 Tahun 2022) & Sitemap
Route::get('/kebijakan-privasi', [PublikController::class, 'kebijakanPrivasi'])->name('kebijakan-privasi');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');

// Autentikasi Pengurus / Admin
Route::get('/admin/login', fn() => redirect()->route('login'));
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Panel Admin
Route::middleware(['auth', 'role:superadmin,pengurus'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('kegiatan', KegiatanController::class)
            ->parameters(['kegiatan' => 'kegiatan'])
            ->except(['show']);

        Route::resource('berita', BeritaController::class)->except(['show']);

        Route::resource('galeri', GaleriController::class)->except(['show']);
        Route::post('/galeri/{galeri}/foto', [GaleriController::class, 'uploadFoto'])->name('galeri.foto.store');
        Route::delete('/foto/{foto}', [GaleriController::class, 'destroyFoto'])->name('galeri.foto.destroy');

        Route::resource('pengurus', PengurusController::class)->except(['show']);
        Route::resource('bidang', BidangController::class)
            ->parameters(['bidang' => 'bidang'])
            ->except(['show']);
        Route::resource('banner', BannerController::class)->except(['show']);

        Route::get('/pendaftaran/ekspor-csv', [AdminPendaftaranController::class, 'exportCsv'])->name('pendaftaran.export');
        Route::get('/pendaftaran', [AdminPendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('/pendaftaran/{pendaftaran}', [AdminPendaftaranController::class, 'show'])->name('pendaftaran.show');
        Route::patch('/pendaftaran/{pendaftaran}', [AdminPendaftaranController::class, 'update'])->name('pendaftaran.update');

        Route::get('/pesan-kontak', [PesanKontakController::class, 'index'])->name('pesan-kontak.index');
        Route::get('/pesan-kontak/{pesanKontak}', [PesanKontakController::class, 'show'])->name('pesan-kontak.show');
        Route::patch('/pesan-kontak/{pesanKontak}/tandai-dibaca', [PesanKontakController::class, 'markAsRead'])->name('pesan-kontak.read');
        Route::delete('/pesan-kontak/{pesanKontak}', [PesanKontakController::class, 'destroy'])->name('pesan-kontak.destroy');

        Route::get('/pengaturan', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
        Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

        Route::resource('pengguna', UserController::class)->except(['show']);
    });
