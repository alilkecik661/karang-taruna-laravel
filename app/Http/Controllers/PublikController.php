<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Banner;
use App\Models\Berita;
use App\Models\Bidang;
use App\Models\Foto;
use App\Models\Kegiatan;
use App\Models\Pengaturan;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublikController extends Controller
{
    public function beranda(): View
    {
        $pengaturan = Pengaturan::semua();
        $banners = Banner::aktif()->get();
        $pengurus = Pengurus::with('bidang')->where('is_aktif', true)->orderBy('urutan')->get();
        $kegiatan = Kegiatan::with('bidang')->published()->orderBy('tanggal_mulai', 'asc')->take(3)->get();
        $berita = Berita::published()
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();
        $fotoGaleri = Foto::with('album')->orderBy('urutan')->take(6)->get();
        $bidangList = Bidang::orderBy('nama')->get();

        return view('publik.beranda', compact(
            'pengaturan',
            'banners',
            'pengurus',
            'kegiatan',
            'berita',
            'fotoGaleri',
            'bidangList'
        ));
    }

    public function tentang(): View
    {
        $pengaturan = Pengaturan::semua();
        $pengurus = Pengurus::with('bidang')->where('is_aktif', true)->orderBy('urutan')->get();
        $bidangList = Bidang::orderBy('nama')->get();

        return view('publik.tentang', compact('pengaturan', 'pengurus', 'bidangList'));
    }

    public function kegiatanIndex(Request $request): View
    {
        $query = Kegiatan::with('bidang')->published();

        if ($request->filled('bidang')) {
            $query->where('bidang_id', (int) $request->input('bidang'));
        }

        if ($request->filled('bulan')) {
            $bulan = (int) $request->input('bulan');
            if ($bulan >= 1 && $bulan <= 12) {
                $query->whereMonth('tanggal_mulai', $bulan);
            }
        }

        $kegiatan = $query->orderBy('tanggal_mulai', 'asc')->paginate(9)->withQueryString();
        $bidangList = Bidang::orderBy('nama')->get();

        return view('publik.kegiatan.index', compact('kegiatan', 'bidangList'));
    }

    public function kegiatanShow(string $slug): View
    {
        $kegiatan = Kegiatan::with(['bidang', 'album.foto', 'creator'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $kegiatanLain = Kegiatan::published()
            ->where('id', '!=', $kegiatan->id)
            ->orderBy('tanggal_mulai', 'asc')
            ->take(3)
            ->get();

        return view('publik.kegiatan.show', compact('kegiatan', 'kegiatanLain'));
    }

    public function beritaIndex(): View
    {
        $berita = Berita::with('creator')
            ->published()
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('publik.berita.index', compact('berita'));
    }

    public function beritaShow(string $slug): View
    {
        $berita = Berita::with('creator')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $beritaLain = Berita::published()
            ->where('id', '!=', $berita->id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('publik.berita.show', compact('berita', 'beritaLain'));
    }

    public function galeriIndex(): View
    {
        $albums = Album::with(['foto', 'kegiatan'])
            ->withCount('foto')
            ->latest()
            ->paginate(9);

        return view('publik.galeri.index', compact('albums'));
    }

    public function galeriShow(string $albumSlug): View
    {
        $album = Album::with(['foto', 'kegiatan'])
            ->where('slug', $albumSlug)
            ->orWhere('id', is_numeric($albumSlug) ? (int) $albumSlug : 0)
            ->firstOrFail();

        return view('publik.galeri.show', compact('album'));
    }

    public function kebijakanPrivasi(): View
    {
        $pengaturan = Pengaturan::semua();

        return view('publik.kebijakan-privasi', compact('pengaturan'));
    }
}
