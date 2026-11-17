<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Pengurus;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PengurusController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(): View
    {
        Gate::authorize('viewAny', Pengurus::class);
        $pengurus = Pengurus::with('bidang')->orderBy('urutan')->paginate(15);

        return view('admin.pengurus.index', compact('pengurus'));
    }

    public function create(): View
    {
        Gate::authorize('create', Pengurus::class);
        $bidangList = Bidang::orderBy('nama')->get();

        return view('admin.pengurus.create', compact('bidangList'));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Pengurus::class);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:150'],
            'bidang_id' => ['nullable', 'exists:bidang,id'],
            'urutan' => ['required', 'integer', 'min:0'],
            'is_aktif' => ['nullable', 'boolean'],
            'foto' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->imageService->uploadToWebp($request->file('foto'), 'pengurus', 600);
        }

        Pengurus::create($validated);

        return redirect()->route('admin.pengurus.index')->with('sukses', 'Data pengurus berhasil ditambahkan.');
    }

    public function edit(Pengurus $penguru): View
    {
        Gate::authorize('update', $penguru);
        $pengurus = $penguru;
        $bidangList = Bidang::orderBy('nama')->get();

        return view('admin.pengurus.edit', compact('pengurus', 'bidangList'));
    }

    public function update(Request $request, Pengurus $penguru): RedirectResponse
    {
        Gate::authorize('update', $penguru);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:150'],
            'bidang_id' => ['nullable', 'exists:bidang,id'],
            'urutan' => ['required', 'integer', 'min:0'],
            'is_aktif' => ['nullable', 'boolean'],
            'foto' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['is_aktif'] = $request->boolean('is_aktif');

        if ($request->hasFile('foto')) {
            $this->imageService->delete($penguru->foto);
            $validated['foto'] = $this->imageService->uploadToWebp($request->file('foto'), 'pengurus', 600);
        }

        $penguru->update($validated);

        return redirect()->route('admin.pengurus.index')->with('sukses', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(Pengurus $penguru): RedirectResponse
    {
        Gate::authorize('delete', $penguru);

        $this->imageService->delete($penguru->foto);
        $penguru->delete();

        return redirect()->route('admin.pengurus.index')->with('sukses', 'Data pengurus berhasil dihapus.');
    }
}
