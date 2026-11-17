<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function edit(): View
    {
        Gate::authorize('viewAny', Pengaturan::class);
        $pengaturan = Pengaturan::semua();

        return view('admin.pengaturan.edit', compact('pengaturan'));
    }

    public function update(Request $request): RedirectResponse
    {
        Gate::authorize('update', Pengaturan::class);

        $validated = $request->validate([
            'nama_organisasi' => ['required', 'string', 'max:150'],
            'teks_logo' => ['required', 'string', 'max:10'],
            'subjudul_organisasi' => ['nullable', 'string', 'max:200'],
            'judul_hero' => ['nullable', 'string', 'max:250'],
            'deskripsi_singkat' => ['nullable', 'string', 'max:1000'],
            'sejarah' => ['nullable', 'string'],
            'visi' => ['nullable', 'string'],
            'misi' => ['nullable', 'string'],
            'tujuan' => ['nullable', 'string'],
            'alamat' => ['required', 'string', 'max:500'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'jam_sekretariat' => ['nullable', 'string', 'max:150'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'maps_embed' => ['nullable', 'string', 'max:1000'],
            'stat_anggota' => ['nullable', 'string', 'max:30'],
            'stat_kegiatan' => ['nullable', 'string', 'max:30'],
            'stat_bidang' => ['nullable', 'string', 'max:30'],
            'logo_file' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo_file')) {
            $oldLogo = Pengaturan::ambil('logo');
            $this->imageService->delete($oldLogo);
            $logoPath = $this->imageService->uploadToWebp($request->file('logo_file'), 'identitas', 400);
            Pengaturan::updateOrCreate(['kunci' => 'logo'], ['nilai' => $logoPath]);
        }

        unset($validated['logo_file']);

        foreach ($validated as $kunci => $nilai) {
            Pengaturan::updateOrCreate(
                ['kunci' => $kunci],
                ['nilai' => (string) ($nilai ?? '')]
            );
        }

        return redirect()->route('admin.pengaturan.edit')->with('sukses', 'Pengaturan website berhasil disimpan.');
    }
}
