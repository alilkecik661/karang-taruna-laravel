<?php

namespace App\Providers;

use App\Models\Album;
use App\Models\Banner;
use App\Models\Berita;
use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Models\PendaftaranAnggota;
use App\Models\Pengaturan;
use App\Models\Pengurus;
use App\Models\PesanKontak;
use App\Policies\AlbumPolicy;
use App\Policies\BannerPolicy;
use App\Policies\BeritaPolicy;
use App\Policies\BidangPolicy;
use App\Policies\KegiatanPolicy;
use App\Policies\PendaftaranAnggotaPolicy;
use App\Policies\PengaturanPolicy;
use App\Policies\PengurusPolicy;
use App\Policies\PesanKontakPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            (isset($_SERVER['HTTP_HOST']) && (str_contains($_SERVER['HTTP_HOST'], 'trycloudflare.com') || str_contains($_SERVER['HTTP_HOST'], 'pinggy.io') || str_contains($_SERVER['HTTP_HOST'], 'localhost.run')))
        ) {
            URL::forceScheme('https');
        }

        Gate::policy(Kegiatan::class, KegiatanPolicy::class);
        Gate::policy(Berita::class, BeritaPolicy::class);
        Gate::policy(Album::class, AlbumPolicy::class);
        Gate::policy(Pengurus::class, PengurusPolicy::class);
        Gate::policy(Bidang::class, BidangPolicy::class);
        Gate::policy(Banner::class, BannerPolicy::class);
        Gate::policy(PendaftaranAnggota::class, PendaftaranAnggotaPolicy::class);
        Gate::policy(PesanKontak::class, PesanKontakPolicy::class);
        Gate::policy(Pengaturan::class, PengaturanPolicy::class);

        View::composer('*', function ($view) {
            if (! $view->offsetExists('pengaturanGlobal')) {
                $view->with('pengaturanGlobal', Pengaturan::semua());
            }
        });
    }
}
