<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Foto;
use App\Models\Kegiatan;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GaleriController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Album::class);

        $query = Album::with(['kegiatan', 'creator'])->withCount('foto')->latest();

        if (! $request->user()->isSuperAdmin()) {
            $query->where('created_by', $request->user()->id);
        }

        $albums = $query->paginate(10);

        return view('admin.galeri.index', compact('albums'));
    }

    public function create(): View
    {
        Gate::authorize('create', Album::class);
        $kegiatanList = Kegiatan::orderByDesc('tanggal_mulai')->get();

        return view('admin.galeri.create', compact('kegiatanList'));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Album::class);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'deskripsi' => ['nullable', 'string'],
            'kegiatan_id' => ['nullable', 'exists:kegiatan,id'],
            'foto.*' => ['nullable', 'image', 'max:4096'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        $album = Album::create([
            'judul' => $validated['judul'],
            'slug' => $this->makeUniqueSlug($validated['judul']),
            'deskripsi' => $validated['deskripsi'] ?? null,
            'kegiatan_id' => $validated['kegiatan_id'] ?? null,
            'created_by' => $request->user()->id,
        ]);

        if ($request->hasFile('foto')) {
            $urutan = 1;
            foreach ($request->file('foto') as $file) {
                $path = $this->imageService->uploadToWebp($file, 'galeri');
                Foto::create([
                    'album_id' => $album->id,
                    'path' => $path,
                    'caption' => $validated['caption'] ?? $album->judul,
                    'urutan' => $urutan++,
                ]);
            }
        }

        return redirect()->route('admin.galeri.edit', $album)->with('sukses', 'Album galeri berhasil dibuat.');
    }

    public function edit(Album $galeri): View
    {
        Gate::authorize('update', $galeri);
        $galeri->load('foto');
        $kegiatanList = Kegiatan::orderByDesc('tanggal_mulai')->get();

        return view('admin.galeri.edit', [
            'album' => $galeri,
            'kegiatanList' => $kegiatanList,
        ]);
    }

    public function update(Request $request, Album $galeri): RedirectResponse
    {
        Gate::authorize('update', $galeri);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'deskripsi' => ['nullable', 'string'],
            'kegiatan_id' => ['nullable', 'exists:kegiatan,id'],
        ]);

        if ($validated['judul'] !== $galeri->judul) {
            $validated['slug'] = $this->makeUniqueSlug($validated['judul'], $galeri->id);
        }

        $galeri->update($validated);

        return redirect()->route('admin.galeri.edit', $galeri)->with('sukses', 'Album berhasil diperbarui.');
    }

    public function destroy(Album $galeri): RedirectResponse
    {
        Gate::authorize('delete', $galeri);

        foreach ($galeri->foto as $foto) {
            $this->imageService->delete($foto->path);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('sukses', 'Album beserta seluruh fotonya berhasil dihapus.');
    }

    public function uploadFoto(Request $request, Album $galeri): RedirectResponse
    {
        Gate::authorize('update', $galeri);

        $validated = $request->validate([
            'file_foto' => ['required', 'image', 'max:4096'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        $path = $this->imageService->uploadToWebp($request->file('file_foto'), 'galeri');
        $urutanTerakhir = (int) $galeri->foto()->max('urutan');

        Foto::create([
            'album_id' => $galeri->id,
            'path' => $path,
            'caption' => $validated['caption'] ?: $galeri->judul,
            'urutan' => $urutanTerakhir + 1,
        ]);

        return redirect()->route('admin.galeri.edit', $galeri)->with('sukses', 'Foto berhasil diunggah dan dikompresi.');
    }

    public function destroyFoto(Foto $foto): RedirectResponse
    {
        $album = $foto->album;
        Gate::authorize('update', $album);

        $this->imageService->delete($foto->path);
        $foto->delete();

        return redirect()->route('admin.galeri.edit', $album)->with('sukses', 'Foto berhasil dihapus.');
    }

    private function makeUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $base = Str::slug($judul) ?: 'album';
        $slug = $base;
        $counter = 1;

        while (
            Album::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
