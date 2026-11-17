@extends('layouts.admin', ['title' => 'Pengguna & Admin'])

@section('content')
  <div class="row">
    <div>
      <p class="eyebrow">Hak Akses</p>
      <h1>Daftar Akun Pengurus & Admin</h1>
    </div>
    <a class="btn btn-primary btn-sm" href="{{ route('admin.pengguna.create') }}">+ Tambah Akun</a>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Bidang</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $u)
          <tr>
            <td><strong>{{ $u->name }}</strong></td>
            <td>{{ $u->email }}</td>
            <td><span class="badge">{{ $u->role }}</span></td>
            <td>{{ $u->bidang?->nama ?? 'Semua Bidang' }}</td>
            <td class="row" style="justify-content:flex-start">
              <a class="btn btn-ghost btn-sm" href="{{ route('admin.pengguna.edit', $u) }}">Edit</a>
              @if($u->id !== auth()->id())
                <form method="POST" action="{{ route('admin.pengguna.destroy', $u) }}" onsubmit="return confirm('Hapus akun ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
