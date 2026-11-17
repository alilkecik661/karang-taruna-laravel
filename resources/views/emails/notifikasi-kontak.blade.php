<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Pesan Kontak Baru</title></head>
<body style="font-family:sans-serif;line-height:1.6;color:#1d2a22">
  <h2>Pesan Baru dari Formulir Kontak Website</h2>
  <ul>
    <li><strong>Nama:</strong> {{ $pesan->nama }}</li>
    <li><strong>Email:</strong> {{ $pesan->email }}</li>
    <li><strong>Subjek:</strong> {{ $pesan->subjek ?: '-' }}</li>
  </ul>
  <p><strong>Isi Pesan:</strong></p>
  <p>{{ $pesan->isi }}</p>
</body>
</html>
