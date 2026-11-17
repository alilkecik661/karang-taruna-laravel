<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<title>{{ isset($title) ? $title . ' | Panel Admin' : 'Panel Admin | ' . ($pengaturanGlobal['nama_organisasi'] ?? 'Karang Taruna 04') }}</title>
<meta name="robots" content="noindex, nofollow">
<link rel="icon" type="image/png" href="{{ asset('images/logo-karupat.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<header class="site-header">
  <div class="container nav">
    <a class="brand" href="{{ route('admin.dashboard') }}">
      <span class="logo">
        <img src="{{ asset('images/logo-karupat.png') }}" alt="Logo {{ $pengaturanGlobal['nama_organisasi'] ?? 'KARUPAT' }}">
      </span>
      <span class="brand-text">
        <strong>Panel Admin</strong>
        <small>{{ $pengaturanGlobal['nama_organisasi'] ?? 'KARUPAT · Karang Taruna 04' }}</small>
      </span>
    </a>
    <div class="row" style="gap:8px;align-items:center;flex-wrap:wrap">
      <span class="meta" style="font-size:0.85rem;display:inline-flex;align-items:center;gap:4px">
        👤 <strong>{{ auth()->user()->name }}</strong>
      </span>
      <a class="btn btn-ghost btn-sm" href="{{ route('beranda') }}" target="_blank" rel="noopener">Lihat Web</a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button class="btn btn-primary btn-sm" type="submit" title="Keluar dari akun {{ auth()->user()->name }}">Keluar</button>
      </form>
    </div>
  </div>
</header>

<div class="admin-shell">
  <aside class="admin-sidebar" aria-label="Menu Admin">
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('admin.kegiatan.index') }}" class="{{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">Kegiatan</a>
    <a href="{{ route('admin.berita.index') }}" class="{{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">Berita</a>
    <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">Galeri</a>
    <a href="{{ route('admin.pendaftaran.index') }}" class="{{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">Pendaftaran Anggota</a>
    <a href="{{ route('admin.pesan-kontak.index') }}" class="{{ request()->routeIs('admin.pesan-kontak.*') ? 'active' : '' }}">Pesan Kontak</a>
    @if(auth()->user()->isSuperAdmin())
      <hr style="border:0;border-top:1px solid var(--border);margin:8px 0">
      <a href="{{ route('admin.pengurus.index') }}" class="{{ request()->routeIs('admin.pengurus.*') ? 'active' : '' }}">Struktur Pengurus</a>
      <a href="{{ route('admin.bidang.index') }}" class="{{ request()->routeIs('admin.bidang.*') ? 'active' : '' }}">Bidang Program</a>
      <a href="{{ route('admin.banner.index') }}" class="{{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">Banner Beranda</a>
      <a href="{{ route('admin.pengguna.index') }}" class="{{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">Pengguna & Admin</a>
      <a href="{{ route('admin.pengaturan.edit') }}" class="{{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">Pengaturan Website</a>
    @endif
  </aside>

  <main class="admin-main">
    @if(session('sukses'))
      <div class="notice show" role="status" style="margin-bottom:20px">{{ session('sukses') }}</div>
    @endif
    @if(session('error'))
      <div class="alert-error" role="alert" style="margin-bottom:20px">{{ session('error') }}</div>
    @endif
    @if($errors->any())
      <div class="alert-error" role="alert" style="margin-bottom:20px">
        <strong>Periksa kembali input Anda:</strong>
        <ul class="list">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>
</div>

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
