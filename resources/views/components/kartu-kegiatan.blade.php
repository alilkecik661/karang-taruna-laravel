@props(['kegiatan'])
@php
  $bulanSingkat = [
    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
    5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
    9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
  ];
  $tgl = $kegiatan->tanggal_mulai;
  $namaBulan = $tgl ? ($bulanSingkat[(int) $tgl->format('n')] ?? $tgl->format('M')) : '-';
@endphp
<article class="card">
  @if($kegiatan->gambar_sampul)
    <img class="card-cover" src="{{ str_starts_with($kegiatan->gambar_sampul, 'images/') ? asset($kegiatan->gambar_sampul) : asset('storage/' . $kegiatan->gambar_sampul) }}" alt="Sampul kegiatan {{ $kegiatan->judul }}" loading="lazy">
  @endif
  <div class="row">
    <div class="date-chip">
      <b>{{ $tgl ? $tgl->format('d') : '--' }}</b>
      <span>{{ $namaBulan }}</span>
    </div>
    <span class="badge">{{ $kegiatan->bidang?->nama ?? 'Mendatang' }}</span>
  </div>
  <h3><a href="{{ route('kegiatan.show', $kegiatan->slug) }}" style="text-decoration:none">{{ $kegiatan->judul }}</a></h3>
  <p class="meta">{{ $kegiatan->lokasi }} · {{ $tgl ? $tgl->format('H.i') . ' WIB' : '' }}</p>
  <p>{{ \Illuminate\Support\Str::limit(strip_tags($kegiatan->deskripsi), 120) }}</p>
  <div style="margin-top:auto;padding-top:8px">
    <a class="btn btn-ghost btn-sm" href="{{ route('kegiatan.show', $kegiatan->slug) }}">Detail Kegiatan</a>
  </div>
</article>
