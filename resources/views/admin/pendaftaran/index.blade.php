@extends('layouts.admin', ['title' => 'Pendaftaran Anggota'])

@section('content')
  <div class="row">
    <div>
      <p class="eyebrow">Keanggotaan</p>
      <h1>Daftar Pendaftaran Anggota</h1>
    </div>
    @can('export', \App\Models\PendaftaranAnggota::class)
      <a class="btn btn-primary btn-sm" href="{{ route('admin.pendaftaran.export') }}">Ekspor ke CSV</a>
    @endcan
  </div>

  <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="card" style="margin-top:20px">
    <div class="row" style="justify-content:flex-start">
      <div class="field" style="min-width:220px">
        <label for="status">Filter Status</label>
        <select id="status" name="status">
          <option value="">Semua Status</option>
          <option value="baru" @selected(request('status') === 'baru')>Baru</option>
          <option value="diproses" @selected(request('status') === 'diproses')>Diproses</option>
          <option value="diterima" @selected(request('status') === 'diterima')>Diterima</option>
          <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
        </select>
      </div>
      <div style="padding-top:24px">
        <button class="btn btn-ghost btn-sm" type="submit">Filter</button>
      </div>
    </div>
  </form>

  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Nama Lengkap</th>
          <th>WhatsApp</th>
          <th>Bidang Minat</th>
          <th>Status</th>
          <th>Tanggal Daftar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pendaftaran as $item)
          <tr>
            <td><strong>{{ $item->nama_lengkap }}</strong></td>
            <td>{{ $item->no_whatsapp }}</td>
            <td>{{ $item->bidang_minat ?: '-' }}</td>
            <td><span class="badge">{{ ucfirst($item->status) }}</span></td>
            <td>{{ $item->created_at?->format('d M Y H:i') }}</td>
            <td><a class="btn btn-ghost btn-sm" href="{{ route('admin.pendaftaran.show', $item) }}">Detail & Status</a></td>
          </tr>
        @empty
          <tr><td colspan="6" class="meta">Belum ada data pendaftar.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">{{ $pendaftaran->links() }}</div>
@endsection
