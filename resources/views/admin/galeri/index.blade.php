@extends('layouts.admin', ['title' => 'Kelola Galeri'])

@section('content')
  <div class="row">
    <div>
      <p class="eyebrow">Manajemen Konten</p>
      <h1>Daftar Album Galeri</h1>
    </div>
    <a class="btn btn-primary btn-sm" href="{{ route('admin.galeri.create') }}">+ Buat Album</a>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Judul Album</th>
          <th>Kegiatan Terkait</th>
          <th>Jumlah Foto</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($albums as $album)
          <tr>
            <td><strong>{{ $album->judul }}</strong></td>
            <td>{{ $album->kegiatan?->judul ?? '-' }}</td>
            <td>{{ $album->foto_count }} foto</td>
            <td class="row" style="justify-content:flex-start">
              <a class="btn btn-ghost btn-sm" href="{{ route('admin.galeri.edit', $album) }}">Kelola Foto</a>
              <form method="POST" action="{{ route('admin.galeri.destroy', $album) }}" onsubmit="return confirm('Hapus album ini beserta seluruh fotonya?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="meta">Belum ada album galeri.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">{{ $albums->links() }}</div>
@endsection
