<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(): View
    {
        Gate::authorize('viewAny', Banner::class);
        $banners = Banner::orderBy('urutan')->get();

        return view('admin.banner.index', compact('banners'));
    }

    public function create(): View
    {
        Gate::authorize('create', Banner::class);

        return view('admin.banner.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Banner::class);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'subjudul' => ['nullable', 'string', 'max:200'],
            'tautan' => ['nullable', 'string', 'max:255'],
            'urutan' => ['required', 'integer', 'min:0'],
            'is_aktif' => ['nullable', 'boolean'],
            'gambar' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->imageService->uploadToWebp($request->file('gambar'), 'banner', 1600);
        }

        Banner::create($validated);

        return redirect()->route('admin.banner.index')->with('sukses', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner): View
    {
        Gate::authorize('update', $banner);

        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        Gate::authorize('update', $banner);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'subjudul' => ['nullable', 'string', 'max:200'],
            'tautan' => ['nullable', 'string', 'max:255'],
            'urutan' => ['required', 'integer', 'min:0'],
            'is_aktif' => ['nullable', 'boolean'],
            'gambar' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['is_aktif'] = $request->boolean('is_aktif');

        if ($request->hasFile('gambar')) {
            $this->imageService->delete($banner->gambar);
            $validated['gambar'] = $this->imageService->uploadToWebp($request->file('gambar'), 'banner', 1600);
        }

        $banner->update($validated);

        return redirect()->route('admin.banner.index')->with('sukses', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        Gate::authorize('delete', $banner);

        $this->imageService->delete($banner->gambar);
        $banner->delete();

        return redirect()->route('admin.banner.index')->with('sukses', 'Banner berhasil dihapus.');
    }
}
