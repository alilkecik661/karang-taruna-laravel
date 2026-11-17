@extends('layouts.admin', ['title' => 'Kelola Berita'])

@section('content')
  <div class="row">
    <div>
      <p class="eyebrow">Manajemen Konten</p>
      <h1>Daftar Berita & Pengumuman</h1>
    </div>
    <a class="btn btn-primary btn-sm" href="{{ route('admin.berita.create') }}">+ Tulis Berita</a>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Disematkan</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($berita as $item)
          <tr>
            <td><strong>{{ $item->judul }}</strong></td>
            <td>{{ $item->is_pinned ? 'Ya' : 'Tidak' }}</td>
            <td>
              <span class="badge {{ $item->status === 'publish' ? 'badge-success' : 'badge-muted' }}">
                {{ ucfirst($item->status) }}
              </span>
            </td>
            <td>{{ ($item->published_at ?? $item->created_at)?->format('d M Y') }}</td>
            <td class="row" style="justify-content:flex-start">
              <a class="btn btn-ghost btn-sm" href="{{ route('admin.berita.edit', $item) }}">Edit</a>
              <form method="POST" action="{{ route('admin.berita.destroy', $item) }}" onsubmit="return confirm('Hapus berita ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="meta">Belum ada berita.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">{{ $berita->links() }}</div>
@endsection
