@extends('layouts.admin', ['title' => 'Baca Pesan Kontak'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.pesan-kontak.index') }}">← Kembali ke Pesan Kontak</a></p>
  <h1>{{ $pesan->subjek ?: 'Pesan dari ' . $pesan->nama }}</h1>

  <div class="card" style="margin-top:20px">
    <p class="meta">
      Dari: <strong>{{ $pesan->nama }}</strong> ({{ $pesan->email }}) ·
      Dikirim pada: {{ $pesan->created_at?->format('d M Y H:i') }}
    </p>
    <hr style="border:0;border-top:1px solid var(--border);margin:12px 0">
    <div class="prose">
      {!! nl2br(e($pesan->isi)) !!}
    </div>
    <div class="row" style="justify-content:flex-start;margin-top:20px">
      <a class="btn btn-primary btn-sm" href="mailto:{{ $pesan->email }}?subject=Re: {{ urlencode($pesan->subjek ?: 'Pesan Anda ke Karang Taruna') }}">Balas via Email</a>
      @can('delete', $pesan)
        <form method="POST" action="{{ route('admin.pesan-kontak.destroy', $pesan) }}" onsubmit="return confirm('Hapus pesan ini?')">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger btn-sm" type="submit">Hapus Pesan</button>
        </form>
      @endcan
    </div>
  </div>
@endsection
