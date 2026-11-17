@extends('layouts.admin', ['title' => 'Bidang Program'])

@section('content')
  <div class="row">
    <div>
      <p class="eyebrow">Organisasi</p>
      <h1>Bidang Program</h1>
    </div>
    <a class="btn btn-primary btn-sm" href="{{ route('admin.bidang.create') }}">+ Tambah Bidang</a>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Nama Bidang</th>
          <th>Deskripsi</th>
          <th>Pengurus</th>
          <th>Kegiatan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($bidang as $item)
          <tr>
            <td><strong>{{ $item->nama }}</strong></td>
            <td>{{ $item->deskripsi }}</td>
            <td>{{ $item->pengurus_count }}</td>
            <td>{{ $item->kegiatan_count }}</td>
            <td class="row" style="justify-content:flex-start">
              <a class="btn btn-ghost btn-sm" href="{{ route('admin.bidang.edit', $item) }}">Edit</a>
              <form method="POST" action="{{ route('admin.bidang.destroy', $item) }}" onsubmit="return confirm('Hapus bidang ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="meta">Belum ada bidang program.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
