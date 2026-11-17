@extends('layouts.app', [
    'title' => $album->judul,
    'metaDescription' => $album->deskripsi ?: 'Album foto dokumentasi kegiatan Karang Taruna.'
])

@section('content')
  <section>
    <div class="container">
      <p class="eyebrow"><a href="{{ route('galeri.index') }}" style="text-decoration:none">Galeri</a></p>
      <h1>{{ $album->judul }}</h1>
      @if($album->deskripsi)
        <p class="lead">{{ $album->deskripsi }}</p>
      @endif
      @if($album->kegiatan)
        <p class="meta" style="margin-top:8px">
          Terkait kegiatan: <a href="{{ route('kegiatan.show', $album->kegiatan->slug) }}">{{ $album->kegiatan->judul }}</a>
        </p>
      @endif

      <div class="gallery">
        @forelse($album->foto as $foto)
          @php
            $src = str_starts_with($foto->path, 'images/') ? asset($foto->path) : asset('storage/' . $foto->path);
          @endphp
          <div class="tile" role="button" tabindex="0" data-lightbox-src="{{ $src }}" data-lightbox-caption="{{ $foto->caption ?? $album->judul }}" aria-label="{{ $foto->caption ?? $album->judul }}">
            <img src="{{ $src }}" alt="{{ $foto->caption ?? $album->judul }}" loading="lazy">
          </div>
        @empty
          <p class="meta">Belum ada foto di dalam album ini.</p>
        @endforelse
      </div>
    </div>
  </section>

  <div id="lightbox" class="lightbox" aria-hidden="true" role="dialog" aria-label="Pratinjau foto">
    <div class="lightbox-inner">
      <img id="lightbox-img" src="" alt="">
      <div class="row">
        <p id="lightbox-caption" class="meta"></p>
        <button id="lightbox-close" type="button" class="btn btn-ghost btn-sm">Tutup</button>
      </div>
    </div>
  </div>
@endsection
