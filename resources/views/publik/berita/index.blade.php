@extends('layouts.app', [
    'title' => 'Berita dan Pengumuman',
    'metaDescription' => 'Artikel, berita kegiatan, dan pengumuman resmi Karang Taruna.'
])

@section('content')
  <section>
    <div class="container">
      <p class="eyebrow">Berita dan Pengumuman</p>
      <h1>Kabar Terbaru Karang Taruna</h1>
      <p class="lead">Ikuti perkembangan program, pengumuman resmi, dan artikel kegiatan pemuda.</p>

      <div class="grid">
        @forelse($berita as $item)
          <x-kartu-berita :berita="$item" />
        @empty
          <div class="card full">
            <h3>Belum ada berita</h3>
            <p>Pengumuman dan berita terbaru akan segera ditampilkan di halaman ini.</p>
          </div>
        @endforelse
      </div>

      <div class="pagination-wrap">
        {{ $berita->links() }}
      </div>
    </div>
  </section>
@endsection
