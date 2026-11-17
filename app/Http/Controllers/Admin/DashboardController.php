<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kegiatan;
use App\Models\PendaftaranAnggota;
use App\Models\PesanKontak;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $jumlahPendaftarBaru = PendaftaranAnggota::where('status', 'baru')->count();
        $jumlahPesanBelumDibaca = PesanKontak::where('sudah_dibaca', false)->count();
        $jumlahKegiatanMendatang = Kegiatan::where('tanggal_mulai', '>=', now())->count();
        $jumlahBeritaPublish = Berita::where('status', 'publish')->count();

        $pendaftarTerbaru = PendaftaranAnggota::latest()->take(5)->get();
        $pesanTerbaru = PesanKontak::latest()->take(5)->get();
        $kegiatanMendatang = Kegiatan::with('bidang')
            ->where('tanggal_mulai', '>=', now()->subDay())
            ->orderBy('tanggal_mulai')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'jumlahPendaftarBaru',
            'jumlahPesanBelumDibaca',
            'jumlahKegiatanMendatang',
            'jumlahBeritaPublish',
            'pendaftarTerbaru',
            'pesanTerbaru',
            'kegiatanMendatang'
        ));
    }
}
