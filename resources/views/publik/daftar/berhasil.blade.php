@extends('layouts.app', [
    'title' => 'Pendaftaran Berhasil',
    'metaDescription' => 'Konfirmasi pendaftaran anggota baru Karang Taruna.'
])

@section('content')
  <section>
    <div class="container">
      <div class="card" style="max-width:680px;margin-inline:auto;padding:32px">
        <span class="badge badge-success" style="width:fit-content">Pendaftaran Diterima</span>
        <h1>Terima kasih telah mendaftar!</h1>
        <p>
          Halo <strong>{{ session('pendaftar_nama', 'Calon Anggota') }}</strong>, formulir pendaftaran anggota baru {{ $pengaturan['nama_organisasi'] ?? 'Karang Taruna' }} sudah kami terima dan tercatat di sistem kami.
        </p>
        <h3 style="margin-top:16px">Langkah selanjutnya:</h3>
        <ul class="list">
          <li>Pengurus akan memverifikasi data pendaftaran Anda.</li>
          <li>Kami akan menghubungi Anda melalui nomor WhatsApp atau alamat email yang telah didaftarkan.</li>
          <li>Jika Anda mengisi alamat email, salinan bukti pendaftaran juga telah dikirimkan ke email Anda.</li>
        </ul>
        <div class="hero-actions" style="margin-top:24px">
          <a class="btn btn-primary" href="{{ route('beranda') }}">Kembali ke Beranda</a>
          <a class="btn btn-ghost" href="{{ route('kegiatan.index') }}">Lihat Kegiatan Kami</a>
        </div>
      </div>
    </div>
  </section>
@endsection
