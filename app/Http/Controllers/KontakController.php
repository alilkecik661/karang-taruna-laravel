<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKontakRequest;
use App\Mail\NotifikasiPesanKontakBaru;
use App\Models\Pengaturan;
use App\Models\PesanKontak;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class KontakController extends Controller
{
    public function create(): View
    {
        $pengaturan = Pengaturan::semua();

        return view('publik.kontak', compact('pengaturan'));
    }

    public function store(StoreKontakRequest $request): RedirectResponse
    {
        // Honeypot: jika kolom jebakan spam terisi, hentikan diam-diam
        if ($request->filled('website')) {
            return redirect()->route('kontak.create')->with('sukses', 'Pesan Anda sudah kami terima. Kami akan membalas secepatnya.');
        }

        $validated = $request->safe()->except(['website']);
        $validated['sudah_dibaca'] = false;

        $pesan = PesanKontak::create($validated);

        $emailPengurus = Pengaturan::ambil('email', 'karangtaruna@example.com');
        if ($emailPengurus) {
            Mail::to($emailPengurus)->queue(new NotifikasiPesanKontakBaru($pesan));
        }

        return redirect()->route('kontak.create')->with('sukses', 'Pesan Anda sudah kami terima. Kami akan membalas secepatnya.');
    }
}
