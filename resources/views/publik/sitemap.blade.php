{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url><loc>{{ route('beranda') }}</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>
  <url><loc>{{ route('tentang') }}</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
  <url><loc>{{ route('kegiatan.index') }}</loc><changefreq>weekly</changefreq><priority>0.9</priority></url>
  <url><loc>{{ route('berita.index') }}</loc><changefreq>weekly</changefreq><priority>0.9</priority></url>
  <url><loc>{{ route('galeri.index') }}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
  <url><loc>{{ route('daftar.create') }}</loc><changefreq>monthly</changefreq><priority>0.9</priority></url>
  <url><loc>{{ route('kontak.create') }}</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>
  @foreach($kegiatan as $item)
    <url>
      <loc>{{ route('kegiatan.show', $item->slug) }}</loc>
      <lastmod>{{ $item->updated_at?->toAtomString() }}</lastmod>
      <priority>0.8</priority>
    </url>
  @endforeach
  @foreach($berita as $item)
    <url>
      <loc>{{ route('berita.show', $item->slug) }}</loc>
      <lastmod>{{ $item->updated_at?->toAtomString() }}</lastmod>
      <priority>0.8</priority>
    </url>
  @endforeach
  @foreach($albums as $album)
    <url>
      <loc>{{ route('galeri.show', $album->slug) }}</loc>
      <lastmod>{{ $album->updated_at?->toAtomString() }}</lastmod>
      <priority>0.7</priority>
    </url>
  @endforeach
</urlset>
