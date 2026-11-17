@extends('layouts.admin', ['title' => 'Kelola Kegiatan'])

@section('content')
  <div class="row">
    <div>
      <p class="eyebrow">Manajemen Konten</p>
      <h1>Daftar Kegiatan</h1>
    </div>
    <a class="btn btn-primary btn-sm" href="{{ route('admin.kegiatan.create') }}">+ Tambah Kegiatan</a>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Bidang</th>
          <th>Tanggal Mulai</th>
          <th>Lokasi</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kegiatan as $item)
          <tr>
            <td><strong>{{ $item->judul }}</strong></td>
            <td>{{ $item->bidang?->nama ?? 'Umum' }}</td>
            <td>{{ $item->tanggal_mulai?->format('d M Y, H:i') }}</td>
            <td>{{ $item->lokasi }}</td>
            <td>
              <span class="badge {{ $item->status === 'publish' ? 'badge-success' : 'badge-muted' }}">
                {{ ucfirst($item->status) }}
              </span>
            </td>
            <td class="row" style="justify-content:flex-start">
              <a class="btn btn-ghost btn-sm" href="{{ route('admin.kegiatan.edit', $item) }}">Edit</a>
              <form method="POST" action="{{ route('admin.kegiatan.destroy', $item) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="meta">Belum ada data kegiatan.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">{{ $kegiatan->links() }}</div>
@endsection
