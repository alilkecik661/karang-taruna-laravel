@extends('layouts.admin', ['title' => 'Struktur Pengurus'])

@section('content')
  <div class="row">
    <div>
      <p class="eyebrow">Organisasi</p>
      <h1>Struktur Pengurus</h1>
    </div>
    <a class="btn btn-primary btn-sm" href="{{ route('admin.pengurus.create') }}">+ Tambah Pengurus</a>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Urutan</th>
          <th>Nama</th>
          <th>Jabatan</th>
          <th>Bidang</th>
          <th>Aktif</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pengurus as $item)
          <tr>
            <td>{{ $item->urutan }}</td>
            <td><strong>{{ $item->nama }}</strong></td>
            <td>{{ $item->jabatan }}</td>
            <td>{{ $item->bidang?->nama ?? 'Pengurus Inti' }}</td>
            <td>{{ $item->is_aktif ? 'Ya' : 'Tidak' }}</td>
            <td class="row" style="justify-content:flex-start">
              <a class="btn btn-ghost btn-sm" href="{{ route('admin.pengurus.edit', $item) }}">Edit</a>
              <form method="POST" action="{{ route('admin.pengurus.destroy', $item) }}" onsubmit="return confirm('Hapus data pengurus ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="meta">Belum ada data pengurus.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
