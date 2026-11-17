@php
  $logoUrl = asset('images/logo-karupat.png');
@endphp
<footer>
  <div class="container footer-grid">
    <div style="display:flex;gap:14px;align-items:center">
      <img src="{{ $logoUrl }}" alt="Logo {{ $pengaturanGlobal['nama_organisasi'] ?? 'KARUPAT' }}" style="width:68px;height:68px;object-fit:contain;flex-shrink:0" loading="lazy">
      <div>
        <strong>{{ $pengaturanGlobal['nama_organisasi'] ?? 'Karang Taruna 04 (KARUPAT)' }}</strong>
        <p class="meta">{{ $pengaturanGlobal['alamat'] ?? 'Sekretariat Karang Taruna 04' }}</p>
        @if(!empty($pengaturanGlobal['telepon']))
          <p class="meta">Telp/WA: {{ $pengaturanGlobal['telepon'] }}</p>
        @endif
      </div>
    </div>
    <div>
      <strong>Menu</strong>
      <p>
        <a href="{{ route('tentang') }}">Tentang</a> ·
        <a href="{{ route('kegiatan.index') }}">Kegiatan</a> ·
        <a href="{{ route('berita.index') }}">Berita</a> ·
        <a href="{{ route('galeri.index') }}">Galeri</a> ·
        <a href="{{ route('daftar.create') }}">Daftar</a> ·
        <a href="{{ route('kontak.create') }}">Kontak</a>
      </p>
    </div>
    <div>
      <strong>Ikuti kami</strong>
      <p>
        <a href="{{ $pengaturanGlobal['instagram'] ?? 'https://www.instagram.com/karupat0402_?obrf=N285cXV4Zml6dmV0' }}" target="_blank" rel="noopener">Instagram (@karupat0402_)</a> ·
        <a href="{{ $pengaturanGlobal['facebook'] ?? '#' }}" target="_blank" rel="noopener">Facebook</a> ·
        <a href="{{ $pengaturanGlobal['youtube'] ?? '#' }}" target="_blank" rel="noopener">YouTube</a>
      </p>
    </div>
  </div>
  <div class="container copy">
    © {{ date('Y') }} {{ $pengaturanGlobal['nama_organisasi'] ?? 'Karang Taruna 04 (KARUPAT)' }}. Seluruh hak cipta dilindungi. ·
    <a href="{{ route('kebijakan-privasi') }}">Kebijakan privasi</a> ·
    @auth
      <a href="{{ route('admin.dashboard') }}" style="font-weight:600">⚙️ Panel Admin</a>
    @else
      <a href="{{ route('login') }}">Login Pengurus</a>
    @endauth
  </div>
</footer>
