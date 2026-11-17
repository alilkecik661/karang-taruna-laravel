<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<title>{{ isset($title) ? $title . ' | ' . ($pengaturanGlobal['nama_organisasi'] ?? 'Karang Taruna 04 (KARUPAT)') : ($pengaturanGlobal['nama_organisasi'] ?? 'Karang Taruna 04 (KARUPAT)') . ' | Beranda' }}</title>
<meta name="description" content="{{ $metaDescription ?? ($pengaturanGlobal['deskripsi_singkat'] ?? 'Website resmi Karang Taruna 04 (KARUPAT): profil, kegiatan, berita, galeri, dan pendaftaran anggota baru.') }}">
<meta property="og:title" content="{{ isset($title) ? $title . ' | ' . ($pengaturanGlobal['nama_organisasi'] ?? 'Karang Taruna 04 (KARUPAT)') : ($pengaturanGlobal['nama_organisasi'] ?? 'Karang Taruna 04 (KARUPAT)') }}">
<meta property="og:description" content="{{ $metaDescription ?? ($pengaturanGlobal['deskripsi_singkat'] ?? 'Website resmi Karang Taruna 04 (KARUPAT).') }}">
<meta property="og:type" content="website">
<link rel="icon" type="image/png" href="{{ asset('images/logo-karupat.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<x-navbar />

<main>
  @yield('content')
</main>

<x-footer />

<x-tombol-whatsapp />

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
