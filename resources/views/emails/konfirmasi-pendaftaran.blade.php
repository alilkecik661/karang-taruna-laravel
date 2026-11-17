<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Konfirmasi Pendaftaran</title></head>
<body style="font-family:sans-serif;line-height:1.6;color:#1d2a22">
  <h2>Halo, {{ $pendaftaran->nama_lengkap }}!</h2>
  <p>Terima kasih telah mendaftar sebagai calon anggota <strong>Karang Taruna</strong>.</p>
  <p>Data pendaftaran Anda sudah kami terima dengan rincian:</p>
  <ul>
    <li><strong>Nama Lengkap:</strong> {{ $pendaftaran->nama_lengkap }}</li>
    <li><strong>Bidang Minat:</strong> {{ $pendaftaran->bidang_minat ?: 'Umum' }}</li>
    <li><strong>Nomor WhatsApp:</strong> {{ $pendaftaran->no_whatsapp }}</li>
  </ul>
  <p>Pengurus kami akan segera menghubungi Anda melalui WhatsApp atau email untuk informasi selanjutnya.</p>
  <p>Salam hangat,<br><strong>Pengurus Karang Taruna</strong></p>
</body>
</html>
