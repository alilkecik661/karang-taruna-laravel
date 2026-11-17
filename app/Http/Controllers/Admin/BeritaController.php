<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BeritaController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Berita::class);

        $query = Berita::with('creator')->orderByDesc('is_pinned')->latest();

        if (! $request->user()->isSuperAdmin()) {
            $query->where('created_by', $request->user()->id);
        }

        $berita = $query->paginate(10);

        return view('admin.berita.index', compact('berita'));
    }

    public function create(): View
    {
        Gate::authorize('create', Berita::class);

        return view('admin.berita.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Berita::class);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'isi' => ['required', 'string'],
            'status' => ['required', 'in:draft,publish'],
            'is_pinned' => ['nullable', 'boolean'],
            'gambar_sampul' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['slug'] = $this->makeUniqueSlug($validated['judul']);
        $validated['is_pinned'] = $request->boolean('is_pinned');
        $validated['published_at'] = $validated['status'] === 'publish' ? now() : null;
        $validated['created_by'] = $request->user()->id;

        if ($request->hasFile('gambar_sampul')) {
            $validated['gambar_sampul'] = $this->imageService->uploadToWebp($request->file('gambar_sampul'), 'berita');
        }

        Berita::create($validated);

        return redirect()->route('admin.berita.index')->with('sukses', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $beritum): View
    {
        Gate::authorize('update', $beritum);
        $berita = $beritum;

        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $beritum): RedirectResponse
    {
        Gate::authorize('update', $beritum);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'isi' => ['required', 'string'],
            'status' => ['required', 'in:draft,publish'],
            'is_pinned' => ['nullable', 'boolean'],
            'gambar_sampul' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($validated['judul'] !== $beritum->judul) {
            $validated['slug'] = $this->makeUniqueSlug($validated['judul'], $beritum->id);
        }

        $validated['is_pinned'] = $request->boolean('is_pinned');
        if ($validated['status'] === 'publish' && ! $beritum->published_at) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('gambar_sampul')) {
            $this->imageService->delete($beritum->gambar_sampul);
            $validated['gambar_sampul'] = $this->imageService->uploadToWebp($request->file('gambar_sampul'), 'berita');
        }

        $beritum->update($validated);

        return redirect()->route('admin.berita.index')->with('sukses', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $beritum): RedirectResponse
    {
        Gate::authorize('delete', $beritum);

        $this->imageService->delete($beritum->gambar_sampul);
        $beritum->delete();

        return redirect()->route('admin.berita.index')->with('sukses', 'Berita berhasil dihapus.');
    }

    private function makeUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $base = Str::slug($judul) ?: 'berita';
        $slug = $base;
        $counter = 1;

        while (
            Berita::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
