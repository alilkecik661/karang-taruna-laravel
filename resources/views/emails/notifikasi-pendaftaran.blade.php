<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Pendaftaran Anggota Baru</title></head>
<body style="font-family:sans-serif;line-height:1.6;color:#1d2a22">
  <h2>Pendaftaran Anggota Baru Karang Taruna</h2>
  <p>Terdapat calon anggota baru yang mendaftar melalui website:</p>
  <ul>
    <li><strong>Nama Lengkap:</strong> {{ $pendaftaran->nama_lengkap }}</li>
    <li><strong>Jenis Kelamin:</strong> {{ $pendaftaran->jenis_kelamin }}</li>
    <li><strong>Tanggal Lahir:</strong> {{ $pendaftaran->tanggal_lahir?->format('d-m-Y') }}</li>
    <li><strong>Nomor WhatsApp:</strong> {{ $pendaftaran->no_whatsapp }}</li>
    <li><strong>Email:</strong> {{ $pendaftaran->email ?: '-' }}</li>
    <li><strong>Bidang Minat:</strong> {{ $pendaftaran->bidang_minat ?: '-' }}</li>
    <li><strong>Alamat:</strong> {{ $pendaftaran->alamat }}</li>
  </ul>
  <p>Silakan buka Panel Admin untuk memproses pendaftaran ini.</p>
</body>
</html>
