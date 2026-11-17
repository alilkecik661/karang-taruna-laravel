@extends('layouts.app', ['title' => 'Terjadi Gangguan Server (500)'])

@section('content')
  <section>
    <div class="container">
      <div class="card" style="max-width:600px;margin-inline:auto;text-align:center;padding:40px 24px">
        <p class="eyebrow">Kesalahan 500</p>
        <h1>Terjadi kendala pada sistem</h1>
        <p>Maaf, permintaan Anda belum dapat diproses saat ini. Silakan muat ulang halaman beberapa saat lagi.</p>
        <div style="margin-top:20px">
          <a class="btn btn-primary" href="{{ url('/') }}">Kembali ke Beranda</a>
        </div>
      </div>
    </div>
  </section>
@endsection
