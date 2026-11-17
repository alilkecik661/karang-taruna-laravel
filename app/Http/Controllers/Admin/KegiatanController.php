<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Kegiatan::class);

        $query = Kegiatan::with(['bidang', 'creator'])->latest('tanggal_mulai');

        if (! $request->user()->isSuperAdmin()) {
            $query->where('created_by', $request->user()->id);
        }

        $kegiatan = $query->paginate(10);

        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function create(): View
    {
        Gate::authorize('create', Kegiatan::class);
        $bidangList = Bidang::orderBy('nama')->get();

        return view('admin.kegiatan.create', compact('bidangList'));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Kegiatan::class);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'bidang_id' => ['nullable', 'exists:bidang,id'],
            'deskripsi' => ['required', 'string'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'lokasi' => ['required', 'string', 'max:200'],
            'status' => ['required', 'in:draft,publish'],
            'gambar_sampul' => ['nullable', 'image', 'max:4096'],
        ]);

        $user = $request->user();
        if (! $user->isSuperAdmin() && $user->bidang_id !== null) {
            $validated['bidang_id'] = $user->bidang_id;
        }

        $validated['slug'] = $this->makeUniqueSlug($validated['judul']);
        $validated['created_by'] = $user->id;

        if ($request->hasFile('gambar_sampul')) {
            $validated['gambar_sampul'] = $this->imageService->uploadToWebp($request->file('gambar_sampul'), 'kegiatan');
        }

        Kegiatan::create($validated);

        return redirect()->route('admin.kegiatan.index')->with('sukses', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Kegiatan $kegiatan): View
    {
        Gate::authorize('update', $kegiatan);
        $bidangList = Bidang::orderBy('nama')->get();

        return view('admin.kegiatan.edit', compact('kegiatan', 'bidangList'));
    }

    public function update(Request $request, Kegiatan $kegiatan): RedirectResponse
    {
        Gate::authorize('update', $kegiatan);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'bidang_id' => ['nullable', 'exists:bidang,id'],
            'deskripsi' => ['required', 'string'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'lokasi' => ['required', 'string', 'max:200'],
            'status' => ['required', 'in:draft,publish'],
            'gambar_sampul' => ['nullable', 'image', 'max:4096'],
        ]);

        $user = $request->user();
        if (! $user->isSuperAdmin() && $user->bidang_id !== null) {
            $validated['bidang_id'] = $user->bidang_id;
        }

        if ($validated['judul'] !== $kegiatan->judul) {
            $validated['slug'] = $this->makeUniqueSlug($validated['judul'], $kegiatan->id);
        }

        if ($request->hasFile('gambar_sampul')) {
            $this->imageService->delete($kegiatan->gambar_sampul);
            $validated['gambar_sampul'] = $this->imageService->uploadToWebp($request->file('gambar_sampul'), 'kegiatan');
        }

        $kegiatan->update($validated);

        return redirect()->route('admin.kegiatan.index')->with('sukses', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan): RedirectResponse
    {
        Gate::authorize('delete', $kegiatan);

        $this->imageService->delete($kegiatan->gambar_sampul);
        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')->with('sukses', 'Kegiatan berhasil dihapus.');
    }

    private function makeUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $base = Str::slug($judul) ?: 'kegiatan';
        $slug = $base;
        $counter = 1;

        while (
            Kegiatan::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
