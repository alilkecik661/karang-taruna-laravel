@extends('layouts.app', [
    'title' => 'Kebijakan Privasi',
    'metaDescription' => 'Kebijakan pelindungan data pribadi anggota dan pengunjung website Karang Taruna sesuai UU No. 27 Tahun 2022.'
])

@section('content')
  <section>
    <div class="container">
      <p class="eyebrow">Pelindungan Data Pribadi</p>
      <h1>Kebijakan Privasi</h1>
      <div class="card prose" style="margin-top:24px">
        <p>
          <strong>{{ $pengaturan['nama_organisasi'] ?? 'Karang Taruna' }}</strong> berkomitmen melindungi data pribadi calon anggota, anggota, dan masyarakat sesuai dengan <strong>Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi (UU PDP)</strong>.
        </p>
        <h3>1. Data yang Kami Kumpulkan</h3>
        <p>
          Melalui formulir pendaftaran anggota dan formulir kontak, kami hanya mengumpulkan informasi dasar yang diperlukan untuk keperluan administrasi keanggotaan dan komunikasi organisasi, yaitu: nama lengkap, jenis kelamin, tanggal lahir, alamat tempat tinggal, nomor WhatsApp, alamat email, serta bidang minat kegiatan. Kami tidak meminta Nomor Induk Kependudukan (NIK) atau data sensitif lainnya melalui formulir publik.
        </p>
        <h3>2. Tujuan Penggunaan Data</h3>
        <p>
          Data yang dikumpulkan semata-mata digunakan untuk verifikasi calon anggota baru, koordinasi kegiatan Karang Taruna, serta menanggapi pesan atau pertanyaan yang dikirimkan melalui halaman kontak.
        </p>
        <h3>3. Keamanan dan Pembatasan Akses</h3>
        <p>
          Data pendaftaran dan pesan hanya dapat diakses oleh pengurus resmi yang berwenang di dalam panel administrasi Karang Taruna dan tidak diperjualbelikan atau diserahkan kepada pihak ketiga tanpa persetujuan pemilik data.
        </p>
        <h3>4. Hak Pemilik Data</h3>
        <p>
          Anda berhak meminta pembaruan, koreksi, atau penghapusan data pribadi Anda dengan menghubungi sekretariat kami di <strong>{{ $pengaturan['email'] ?? 'karangtaruna@example.com' }}</strong> atau melalui nomor telepon/WhatsApp resmi organisasi.
        </p>
      </div>
    </div>
  </section>
@endsection
