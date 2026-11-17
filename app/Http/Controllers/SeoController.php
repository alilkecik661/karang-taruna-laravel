<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Berita;
use App\Models\Kegiatan;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $kegiatan = Kegiatan::published()->latest('updated_at')->get();
        $berita = Berita::published()->latest('updated_at')->get();
        $albums = Album::latest('updated_at')->get();

        $content = view('publik.sitemap', compact('kegiatan', 'berita', 'albums'))->render();

        return response($content, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
