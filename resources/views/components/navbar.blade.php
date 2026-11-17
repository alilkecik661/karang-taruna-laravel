@php
  $logoUrl = asset('images/logo-karupat.png');
@endphp
<header class="site-header">
  <div class="container nav">
    <a class="brand" href="{{ route('beranda') }}">
      <span class="logo">
        <img src="{{ $logoUrl }}" alt="Logo {{ $pengaturanGlobal['nama_organisasi'] ?? 'KARUPAT Karang Taruna 04' }}">
      </span>
      <span class="brand-text">
        <strong>Karang Taruna 04</strong>
        <small>KARUPAT</small>
      </span>
    </a>

    <div class="only-mobile-inline" style="gap:8px">
      @auth
        <a href="{{ route('admin.dashboard') }}" style="display:inline-flex;align-items:center;gap:4px;padding:6px 12px;background:var(--primary);color:#fff;border-radius:20px;font-size:0.8rem;text-decoration:none;font-weight:600">
          ⚙️ Admin
        </a>
      @endauth

      <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="menu" aria-label="Buka menu">
        <svg width="22" height="22" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3 6h18v2H3zM3 11h18v2H3zM3 16h18v2H3z"/></svg>
      </button>
    </div>

    <nav id="menu" class="menu" aria-label="Menu utama">
      <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>
      <a href="{{ route('kegiatan.index') }}" class="{{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">Kegiatan</a>
      <a href="{{ route('berita.index') }}" class="{{ request()->routeIs('berita.*') ? 'active' : '' }}">Berita</a>
      <a href="{{ route('galeri.index') }}" class="{{ request()->routeIs('galeri.*') ? 'active' : '' }}">Galeri</a>
      <a href="{{ route('kontak.create') }}" class="{{ request()->routeIs('kontak.*') ? 'active' : '' }}">Kontak</a>
      <a href="{{ route('daftar.create') }}" class="only-mobile {{ request()->routeIs('daftar.*') ? 'active' : '' }}">Daftar Anggota</a>

      @auth
        <hr class="only-mobile" style="border:0;border-top:1px solid var(--border);margin:8px 0;width:100%">
        <a href="{{ route('admin.dashboard') }}" class="only-mobile {{ request()->routeIs('admin.*') ? 'active' : '' }}" style="font-weight:700;color:var(--primary)">
          ⚙️ Panel Admin ({{ auth()->user()->name }})
        </a>
      @endauth
    </nav>

    <div class="nav-cta" style="gap:8px">
      @auth
        <a class="btn btn-ghost btn-sm" href="{{ route('admin.dashboard') }}">⚙️ Panel Admin</a>
      @endauth
      <a class="btn btn-primary btn-sm" href="{{ route('daftar.create') }}">Daftar Anggota</a>
    </div>
  </div>
</header>
