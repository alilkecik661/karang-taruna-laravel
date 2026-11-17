@extends('layouts.admin', ['title' => 'Banner Beranda'])

@section('content')
  <div class="row">
    <div>
      <p class="eyebrow">Tampilan Beranda</p>
      <h1>Daftar Banner Beranda</h1>
    </div>
    <a class="btn btn-primary btn-sm" href="{{ route('admin.banner.create') }}">+ Tambah Banner</a>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Urutan</th>
          <th>Judul</th>
          <th>Subjudul</th>
          <th>Aktif</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($banners as $item)
          <tr>
            <td>{{ $item->urutan }}</td>
            <td><strong>{{ $item->judul }}</strong></td>
            <td>{{ $item->subjudul }}</td>
            <td>{{ $item->is_aktif ? 'Ya' : 'Tidak' }}</td>
            <td class="row" style="justify-content:flex-start">
              <a class="btn btn-ghost btn-sm" href="{{ route('admin.banner.edit', $item) }}">Edit</a>
              <form method="POST" action="{{ route('admin.banner.destroy', $item) }}" onsubmit="return confirm('Hapus banner ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="meta">Belum ada banner.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
