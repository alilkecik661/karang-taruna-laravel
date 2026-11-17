@extends('layouts.app', ['title' => 'Halaman Tidak Ditemukan (404)'])

@section('content')
  <section>
    <div class="container">
      <div class="card" style="max-width:600px;margin-inline:auto;text-align:center;padding:40px 24px">
        <p class="eyebrow">Kesalahan 404</p>
        <h1>Halaman tidak ditemukan</h1>
        <p>Maaf, halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau alamat URL tidak tepat.</p>
        <div style="margin-top:20px">
          <a class="btn btn-primary" href="{{ route('beranda') }}">Kembali ke Beranda</a>
        </div>
      </div>
    </div>
  </section>
@endsection
