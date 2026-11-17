@extends('layouts.app', [
    'title' => $berita->judul,
    'metaDescription' => \Illuminate\Support\Str::limit(strip_tags($berita->isi), 155)
])

@section('content')
  <section>
    <div class="container">
      <p class="eyebrow"><a href="{{ route('berita.index') }}" style="text-decoration:none">Berita</a></p>
      <h1>{{ $berita->judul }}</h1>
      <div class="row" style="justify-content:flex-start;margin-bottom:16px">
        @if($berita->is_pinned)
          <span class="badge">Disematkan</span>
        @endif
        <span class="meta">Dipublikasikan pada {{ ($berita->published_at ?? $berita->created_at)?->format('d M Y') }}</span>
        @if($berita->creator)
          <span class="meta">· Oleh {{ $berita->creator->name }}</span>
        @endif
      </div>

      @if($berita->gambar_sampul)
        <img class="card-cover" style="max-height:420px;margin-top:20px" src="{{ str_starts_with($berita->gambar_sampul, 'images/') ? asset($berita->gambar_sampul) : asset('storage/' . $berita->gambar_sampul) }}" alt="Sampul {{ $berita->judul }}" loading="lazy">
      @endif

      <article class="card prose" style="margin-top:24px">
        {!! nl2br(e($berita->isi)) !!}
      </article>

      @if($beritaLain->isNotEmpty())
        <h2 class="sub">Berita Lainnya</h2>
        <div class="grid">
          @foreach($beritaLain as $item)
            <x-kartu-berita :berita="$item" />
          @endforeach
        </div>
      @endif
    </div>
  </section>
@endsection
