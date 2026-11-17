@extends('layouts.app', [
    'title' => 'Galeri Dokumentasi',
    'metaDescription' => 'Album dokumentasi kegiatan dan kebersamaan Karang Taruna.'
])

@section('content')
  <section>
    <div class="container">
      <p class="eyebrow">Galeri</p>
      <h1>Album Dokumentasi Kegiatan</h1>
      <p class="lead">Kumpulan momen kegiatan sosial, olahraga, pelatihan, dan kebersamaan pemuda.</p>

      <div class="grid">
        @forelse($albums as $album)
          @php
            $sampul = $album->foto->first();
            $src = $sampul
              ? (str_starts_with($sampul->path, 'images/') ? asset($sampul->path) : asset('storage/' . $sampul->path))
              : asset('images/sample-1.svg');
          @endphp
          <article class="card">
            <img class="card-cover" src="{{ $src }}" alt="Sampul album {{ $album->judul }}" loading="lazy">
            <div class="row">
              <span class="badge">{{ $album->foto_count }} Foto</span>
              @if($album->kegiatan)
                <span class="meta">{{ $album->kegiatan->judul }}</span>
              @endif
            </div>
            <h3><a href="{{ route('galeri.show', $album->slug) }}" style="text-decoration:none">{{ $album->judul }}</a></h3>
            <p>{{ \Illuminate\Support\Str::limit($album->deskripsi, 110) }}</p>
            <div style="margin-top:auto;padding-top:8px">
              <a class="btn btn-ghost btn-sm" href="{{ route('galeri.show', $album->slug) }}">Buka Album</a>
            </div>
          </article>
        @empty
          <div class="card full">
            <h3>Belum ada album galeri</h3>
            <p>Dokumentasi foto kegiatan akan segera diunggah.</p>
          </div>
        @endforelse
      </div>

      <div class="pagination-wrap">
        {{ $albums->links() }}
      </div>
    </div>
  </section>
@endsection
