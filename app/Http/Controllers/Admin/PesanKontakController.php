<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesanKontak;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PesanKontakController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', PesanKontak::class);
        $pesan = PesanKontak::latest()->paginate(15);

        return view('admin.pesan-kontak.index', compact('pesan'));
    }

    public function show(PesanKontak $pesanKontak): View
    {
        Gate::authorize('view', $pesanKontak);

        if (! $pesanKontak->sudah_dibaca && Gate::allows('update', $pesanKontak)) {
            $pesanKontak->update(['sudah_dibaca' => true]);
        }

        return view('admin.pesan-kontak.show', ['pesan' => $pesanKontak]);
    }

    public function markAsRead(PesanKontak $pesanKontak): RedirectResponse
    {
        Gate::authorize('update', $pesanKontak);
        $pesanKontak->update(['sudah_dibaca' => true]);

        return redirect()->back()->with('sukses', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(PesanKontak $pesanKontak): RedirectResponse
    {
        Gate::authorize('delete', $pesanKontak);
        $pesanKontak->delete();

        return redirect()->route('admin.pesan-kontak.index')->with('sukses', 'Pesan kontak berhasil dihapus.');
    }
}
