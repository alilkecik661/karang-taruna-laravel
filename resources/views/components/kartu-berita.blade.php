@props(['berita'])
<article class="card">
  @if($berita->gambar_sampul)
    <img class="card-cover" src="{{ str_starts_with($berita->gambar_sampul, 'images/') ? asset($berita->gambar_sampul) : asset('storage/' . $berita->gambar_sampul) }}" alt="Sampul berita {{ $berita->judul }}" loading="lazy">
  @endif
  <div class="row">
    @if($berita->is_pinned)
      <span class="badge">Disematkan</span>
    @else
      <span></span>
    @endif
    <span class="meta">{{ ($berita->published_at ?? $berita->created_at)?->format('d M Y') }}</span>
  </div>
  <h3><a href="{{ route('berita.show', $berita->slug) }}" style="text-decoration:none">{{ $berita->judul }}</a></h3>
  <p>{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 130) }}</p>
  <div style="margin-top:auto;padding-top:8px">
    <a class="btn btn-ghost btn-sm" href="{{ route('berita.show', $berita->slug) }}">Baca Selengkapnya</a>
  </div>
</article>
