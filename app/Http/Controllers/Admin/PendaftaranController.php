<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranAnggota;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PendaftaranController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', PendaftaranAnggota::class);

        $query = PendaftaranAnggota::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $pendaftaran = $query->paginate(15)->withQueryString();

        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    public function show(PendaftaranAnggota $pendaftaran): View
    {
        Gate::authorize('view', $pendaftaran);

        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function update(Request $request, PendaftaranAnggota $pendaftaran): RedirectResponse
    {
        Gate::authorize('update', $pendaftaran);

        $validated = $request->validate([
            'status' => ['required', 'in:baru,diproses,diterima,ditolak'],
            'catatan_admin' => ['nullable', 'string', 'max:2000'],
        ]);

        $pendaftaran->update($validated);

        return redirect()->route('admin.pendaftaran.show', $pendaftaran)->with('sukses', 'Status pendaftaran berhasil diperbarui.');
    }

    public function exportCsv(): StreamedResponse
    {
        Gate::authorize('export', PendaftaranAnggota::class);

        $filename = 'pendaftaran-anggota-' . now()->format('Y-m-d') . '.csv';
        $items = PendaftaranAnggota::orderBy('id')->get();

        return response()->streamDownload(function () use ($items) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM agar terbaca rapi di Microsoft Excel
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'ID',
                'Nama Lengkap',
                'Jenis Kelamin',
                'Tanggal Lahir',
                'Alamat',
                'No WhatsApp',
                'Email',
                'Bidang Minat',
                'Status',
                'Catatan Admin',
                'Tanggal Daftar',
            ]);

            foreach ($items as $row) {
                fputcsv($handle, [
                    $row->id,
                    $row->nama_lengkap,
                    $row->jenis_kelamin,
                    $row->tanggal_lahir?->format('Y-m-d'),
                    $row->alamat,
                    $row->no_whatsapp,
                    $row->email,
                    $row->bidang_minat,
                    $row->status,
                    $row->catatan_admin,
                    $row->created_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
