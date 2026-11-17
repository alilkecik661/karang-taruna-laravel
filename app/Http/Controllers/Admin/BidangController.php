<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BidangController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Bidang::class);
        $bidang = Bidang::withCount(['pengurus', 'kegiatan'])->orderBy('nama')->get();

        return view('admin.bidang.index', compact('bidang'));
    }

    public function create(): View
    {
        Gate::authorize('create', Bidang::class);

        return view('admin.bidang.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Bidang::class);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150', 'unique:bidang,nama'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
        ]);

        Bidang::create($validated);

        return redirect()->route('admin.bidang.index')->with('sukses', 'Bidang berhasil ditambahkan.');
    }

    public function edit(Bidang $bidang): View
    {
        Gate::authorize('update', $bidang);

        return view('admin.bidang.edit', compact('bidang'));
    }

    public function update(Request $request, Bidang $bidang): RedirectResponse
    {
        Gate::authorize('update', $bidang);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150', 'unique:bidang,nama,' . $bidang->id],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
        ]);

        $bidang->update($validated);

        return redirect()->route('admin.bidang.index')->with('sukses', 'Bidang berhasil diperbarui.');
    }

    public function destroy(Bidang $bidang): RedirectResponse
    {
        Gate::authorize('delete', $bidang);
        $bidang->delete();

        return redirect()->route('admin.bidang.index')->with('sukses', 'Bidang berhasil dihapus.');
    }
}
