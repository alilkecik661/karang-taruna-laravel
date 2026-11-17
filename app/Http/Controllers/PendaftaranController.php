<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePendaftaranRequest;
use App\Mail\KonfirmasiPendaftaranAnggota;
use App\Mail\NotifikasiPendaftaranBaru;
use App\Models\Bidang;
use App\Models\PendaftaranAnggota;
use App\Models\Pengaturan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PendaftaranController extends Controller
{
    public function create(): View
    {
        $bidangList = Bidang::orderBy('nama')->get();

        return view('publik.daftar.create', compact('bidangList'));
    }

    public function store(StorePendaftaranRequest $request): RedirectResponse
    {
        // Honeypot: jika kolom jebakan spam terisi, hentikan diam-diam dan arahkan ke halaman berhasil
        if ($request->filled('website')) {
            return redirect()->route('daftar.berhasil');
        }

        $validated = $request->safe()->except(['website']);
        $validated['status'] = 'baru';

        $pendaftaran = PendaftaranAnggota::create($validated);

        $emailPengurus = Pengaturan::ambil('email', 'karangtaruna@example.com');
        if ($emailPengurus) {
            Mail::to($emailPengurus)->queue(new NotifikasiPendaftaranBaru($pendaftaran));
        }

        if (! empty($pendaftaran->email)) {
            Mail::to($pendaftaran->email)->queue(new KonfirmasiPendaftaranAnggota($pendaftaran));
        }

        return redirect()->route('daftar.berhasil')->with('pendaftar_nama', $pendaftaran->nama_lengkap);
    }

    public function berhasil(): View
    {
        $pengaturan = Pengaturan::semua();

        return view('publik.daftar.berhasil', compact('pengaturan'));
    }
}
