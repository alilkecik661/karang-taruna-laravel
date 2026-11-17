@extends('layouts.app', [
    'title' => 'Tentang Kami',
    'metaDescription' => 'Sejarah, visi misi, tujuan, dan struktur pengurus resmi Karang Taruna.'
])

@section('content')
  @php
    $misiLines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) ($pengaturan['misi'] ?? ''))));
  @endphp

  <section>
    <div class="container">
      <p class="eyebrow">Profil Organisasi</p>
      <h1>Tentang {{ $pengaturan['nama_organisasi'] ?? 'Karang Taruna' }}</h1>
      <p class="lead">{{ $pengaturan['sejarah'] ?? '' }}</p>

      <div class="grid">
        <div class="card">
          <h3>Visi</h3>
          <p>{{ $pengaturan['visi'] ?? '' }}</p>
        </div>
        <div class="card">
          <h3>Misi</h3>
          <ul class="list">
            @foreach($misiLines as $line)
              <li>{{ $line }}</li>
            @endforeach
          </ul>
        </div>
        <div class="card">
          <h3>Tujuan</h3>
          <p>{{ $pengaturan['tujuan'] ?? '' }}</p>
        </div>
      </div>

      <h2 class="sub">Bidang Program</h2>
      <div class="grid">
        @foreach($bidangList as $bidang)
          <div class="card">
            <h3>{{ $bidang->nama }}</h3>
            <p>{{ $bidang->deskripsi }}</p>
          </div>
        @endforeach
      </div>

      <h2 class="sub">Struktur Pengurus</h2>
      <div class="grid">
        @foreach($pengurus as $item)
          <x-kartu-pengurus :pengurus="$item" />
        @endforeach
      </div>
    </div>
  </section>
@endsection
