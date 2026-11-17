@extends('layouts.app', [
    'title' => $kegiatan->judul,
    'metaDescription' => \Illuminate\Support\Str::limit(strip_tags($kegiatan->deskripsi), 155)
])

@section('content')
  <section>
    <div class="container">
      <p class="eyebrow">
        <a href="{{ route('kegiatan.index') }}" style="text-decoration:none">Kegiatan</a>
        @if($kegiatan->bidang)
          · {{ $kegiatan->bidang->nama }}
        @endif
      </p>
      <h1>{{ $kegiatan->judul }}</h1>
      <p class="meta">
        Lokasi: <strong>{{ $kegiatan->lokasi }}</strong> ·
        Mulai: <strong>{{ $kegiatan->tanggal_mulai?->format('d M Y, H.i') }} WIB</strong>
        @if($kegiatan->tanggal_selesai)
          · Selesai: <strong>{{ $kegiatan->tanggal_selesai->format('d M Y, H.i') }} WIB</strong>
        @endif
      </p>

      @if($kegiatan->gambar_sampul)
        <img class="card-cover" style="max-height:420px;margin-top:24px" src="{{ str_starts_with($kegiatan->gambar_sampul, 'images/') ? asset($kegiatan->gambar_sampul) : asset('storage/' . $kegiatan->gambar_sampul) }}" alt="Sampul {{ $kegiatan->judul }}" loading="lazy">
      @endif

      <div class="card prose" style="margin-top:24px">
        {!! nl2br(e($kegiatan->deskripsi)) !!}
      </div>

      @if($kegiatan->album->isNotEmpty())
        <h2 class="sub">Dokumentasi Kegiatan</h2>
        @foreach($kegiatan->album as $album)
          <div class="gallery">
            @foreach($album->foto as $foto)
              @php
                $src = str_starts_with($foto->path, 'images/') ? asset($foto->path) : asset('storage/' . $foto->path);
              @endphp
              <div class="tile" role="button" tabindex="0" data-lightbox-src="{{ $src }}" data-lightbox-caption="{{ $foto->caption }}">
                <img src="{{ $src }}" alt="{{ $foto->caption ?? $kegiatan->judul }}" loading="lazy">
              </div>
            @endforeach
          </div>
        @endforeach
      @endif

      @if($kegiatanLain->isNotEmpty())
        <h2 class="sub">Kegiatan Lainnya</h2>
        <div class="grid">
          @foreach($kegiatanLain as $item)
            <x-kartu-kegiatan :kegiatan="$item" />
          @endforeach
        </div>
      @endif
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
