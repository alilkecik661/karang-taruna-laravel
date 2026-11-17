@props(['pengurus'])
<article class="card" style="flex-direction:row;align-items:center;gap:16px">
  <div class="avatar" aria-hidden="true">
    @if($pengurus->foto)
      <img src="{{ str_starts_with($pengurus->foto, 'images/') ? asset($pengurus->foto) : asset('storage/' . $pengurus->foto) }}" alt="Foto {{ $pengurus->nama }}" loading="lazy">
    @else
      {{ $pengurus->inisial }}
    @endif
  </div>
  <div>
    <span class="badge" style="margin-bottom:4px">No. {{ $pengurus->urutan }}</span>
    <h3 style="margin:2px 0">{{ $pengurus->nama }}</h3>
    <p class="meta">{{ $pengurus->jabatan }}</p>
  </div>
</article>
