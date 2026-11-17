@extends('layouts.admin', ['title' => 'Pesan Kontak'])

@section('content')
  <p class="eyebrow">Komunikasi Warga</p>
  <h1>Kotak Masuk Pesan Kontak</h1>

  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Pengirim</th>
          <th>Email</th>
          <th>Subjek</th>
          <th>Status</th>
          <th>Waktu</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pesan as $item)
          <tr>
            <td><strong>{{ $item->nama }}</strong></td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->subjek ?: '(Tanpa Subjek)' }}</td>
            <td>
              <span class="badge {{ $item->sudah_dibaca ? 'badge-muted' : 'badge' }}">
                {{ $item->sudah_dibaca ? 'Sudah Dibaca' : 'Belum Dibaca' }}
              </span>
            </td>
            <td>{{ $item->created_at?->format('d M Y H:i') }}</td>
            <td class="row" style="justify-content:flex-start">
              <a class="btn btn-ghost btn-sm" href="{{ route('admin.pesan-kontak.show', $item) }}">Buka</a>
              @if(!$item->sudah_dibaca)
                <form method="POST" action="{{ route('admin.pesan-kontak.read', $item) }}">
                  @csrf
                  @method('PATCH')
                  <button class="btn btn-primary btn-sm" type="submit">Tandai Dibaca</button>
                </form>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="meta">Belum ada pesan masuk.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">{{ $pesan->links() }}</div>
@endsection
