@extends('layouts.app', [
    'title' => 'Beranda',
    'metaDescription' => $pengaturan['deskripsi_singkat'] ?? 'Website resmi Karang Taruna 04 (KARUPAT): profil, kegiatan, berita, galeri, dan pendaftaran anggota baru.'
])

@section('content')
  @php
    $bannerUtama = $banners->first();
    $misiLines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) ($pengaturan['misi'] ?? ''))));
    $waNumber = preg_replace('/[^0-9]/', '', (string) ($pengaturan['whatsapp'] ?? '6281234567890'));
    if (str_starts_with($waNumber, '0')) {
        $waNumber = '62' . substr($waNumber, 1);
    }
    $logoUrl = asset('images/logo-karupat.png');
  @endphp

  <section class="hero" id="beranda">
    <div class="container">
      <div class="hero-grid">
        <div class="hero-copy">
          <p class="eyebrow">{{ $bannerUtama?->subjudul ?? ($pengaturan['subjudul_organisasi'] ?? 'KARUPAT · Karang Taruna 04') }}</p>
          <h1>{{ $bannerUtama?->judul ?? ($pengaturan['judul_hero'] ?? 'Bersama pemuda, membangun lingkungan yang lebih berdaya') }}</h1>
          <p class="lead">{{ $pengaturan['deskripsi_singkat'] ?? 'Wadah kreativitas, kepedulian sosial, dan kepemimpinan bagi pemuda di lingkungan kami.' }}</p>
          <div class="hero-actions">
            <a class="btn btn-primary" href="{{ route('daftar.create') }}">Daftar Jadi Anggota</a>
            <a class="btn btn-ghost" href="{{ route('kegiatan.index') }}">Lihat Kegiatan</a>
          </div>
        </div>
        <div class="hero-emblem-wrap">
          <div class="hero-emblem">
            <img src="{{ $logoUrl }}" alt="Logo Resmi {{ $pengaturan['nama_organisasi'] ?? 'KARUPAT Karang Taruna 04' }}">
          </div>
        </div>
      </div>

      <div class="stats">
        <div class="stat"><strong>{{ $pengurus->count() ?: ($pengaturan['stat_anggota'] ?? '18') }}</strong>Pengurus & Anggota</div>
        <div class="stat"><strong>{{ $pengaturan['stat_kegiatan'] ?? '24' }}</strong>Kegiatan tahun ini</div>
        <div class="stat"><strong>{{ $pengaturan['stat_bidang'] ?? '6' }}</strong>Bidang program</div>
      </div>
    </div>
  </section>

  <section id="tentang">
    <div class="container">
      <div class="row">
        <div>
          <p class="eyebrow">Tentang Kami</p>
          <h2>Visi, misi, dan kepengurusan</h2>
        </div>
        <a class="btn btn-ghost btn-sm" href="{{ route('tentang') }}">Profil Lengkap</a>
      </div>
      <div class="grid">
        <div class="card">
          <h3>Visi</h3>
          <p>{{ $pengaturan['visi'] ?? 'Pemuda yang mandiri, peduli, dan berkontribusi bagi kemajuan desa.' }}</p>
        </div>
        <div class="card">
          <h3>Misi</h3>
          <ul class="list">
            @forelse($misiLines as $misi)
              <li>{{ $misi }}</li>
            @empty
              <li>Mengembangkan kepemimpinan dan keterampilan pemuda.</li>
              <li>Menggerakkan kegiatan sosial dan lingkungan.</li>
              <li>Membangun kemitraan dengan warga dan pemerintah setempat.</li>
            @endforelse
          </ul>
        </div>
      </div>

      <h3 class="sub">Daftar Pengurus & Anggota KARUPAT ({{ $pengurus->count() }} Orang)</h3>
      <div class="grid">
        @foreach($pengurus as $item)
          <x-kartu-pengurus :pengurus="$item" />
        @endforeach
      </div>
    </div>
  </section>

  <section id="kegiatan" class="alt">
    <div class="container">
      <div class="row">
        <div>
          <p class="eyebrow">Kegiatan</p>
          <h2>Program kerja terdekat</h2>
        </div>
        <a class="btn btn-ghost btn-sm" href="{{ route('kegiatan.index') }}">Semua Kegiatan</a>
      </div>
      <div class="grid">
        @forelse($kegiatan as $item)
          <x-kartu-kegiatan :kegiatan="$item" />
        @empty
          <p class="meta">Belum ada jadwal kegiatan terbaru.</p>
        @endforelse
      </div>
    </div>
  </section>

  <section id="berita">
    <div class="container">
      <div class="row">
        <div>
          <p class="eyebrow">Berita dan Pengumuman</p>
          <h2>Kabar terbaru</h2>
        </div>
        <a class="btn btn-ghost btn-sm" href="{{ route('berita.index') }}">Semua Berita</a>
      </div>
      <div class="grid">
        @forelse($berita as $item)
          <x-kartu-berita :berita="$item" />
        @empty
          <p class="meta">Belum ada berita dipublikasikan.</p>
        @endforelse
      </div>
    </div>
  </section>

  <section id="galeri" class="alt">
    <div class="container">
      <div class="row">
        <div>
          <p class="eyebrow">Galeri</p>
          <h2>Dokumentasi kegiatan</h2>
        </div>
        <a class="btn btn-ghost btn-sm" href="{{ route('galeri.index') }}">Buka Semua Album</a>
      </div>
      <div class="gallery">
        @forelse($fotoGaleri as $foto)
          @php
            $src = str_starts_with($foto->path, 'images/') ? asset($foto->path) : asset('storage/' . $foto->path);
          @endphp
          <div class="tile" role="button" tabindex="0" data-lightbox-src="{{ $src }}" data-lightbox-caption="{{ $foto->caption ?? 'Dokumentasi kegiatan' }}" aria-label="{{ $foto->caption ?? 'Foto dokumentasi kegiatan' }}">
            <img src="{{ $src }}" alt="{{ $foto->caption ?? 'Foto dokumentasi kegiatan' }}" loading="lazy">
          </div>
        @empty
          <div class="tile" role="img" aria-label="Foto dokumentasi kegiatan (contoh)"></div>
          <div class="tile" role="img" aria-label="Foto dokumentasi kegiatan (contoh)"></div>
          <div class="tile" role="img" aria-label="Foto dokumentasi kegiatan (contoh)"></div>
        @endforelse
      </div>
    </div>
  </section>

  <section id="daftar">
    <div class="container">
      <p class="eyebrow">Pendaftaran Anggota</p>
      <h2>Daftar jadi anggota Karang Taruna</h2>
      <p class="lead">Isi data berikut. Pengurus akan menghubungi Anda melalui WhatsApp atau email.</p>

      <form class="form" method="POST" action="{{ route('daftar.store') }}" data-validate="true" novalidate>
        @csrf
        <x-field-form id="nama_lengkap" name="nama_lengkap" label="Nama lengkap" autocomplete="name" :required="true" />
        <x-field-form id="tanggal_lahir" name="tanggal_lahir" label="Tanggal lahir" type="date" :required="true" />

        <x-field-form id="jenis_kelamin" name="jenis_kelamin" label="Jenis kelamin" type="select" :required="true">
          <option value="">Pilih</option>
          <option value="Laki-laki" @selected(old('jenis_kelamin') === 'Laki-laki')>Laki-laki</option>
          <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
        </x-field-form>

        <x-field-form id="no_whatsapp" name="no_whatsapp" label="Nomor WhatsApp" type="tel" placeholder="08xxxxxxxxxx" :required="true" />
        <x-field-form id="alamat" name="alamat" label="Alamat lengkap" type="textarea" :full="true" :required="true" />
        <x-field-form id="email" name="email" label="Email (opsional)" type="email" autocomplete="email" />

        <x-field-form id="bidang_minat" name="bidang_minat" label="Bidang minat" type="select">
          <option value="">Pilih bidang</option>
          @foreach($bidangList as $bidang)
            <option value="{{ $bidang->nama }}" @selected(old('bidang_minat') === $bidang->nama)>{{ $bidang->nama }}</option>
          @endforeach
        </x-field-form>

        <div class="hp" aria-hidden="true">
          <label>Kosongkan kolom ini<input name="website" tabindex="-1" autocomplete="off"></label>
        </div>

        <div class="full">
          <p class="meta" style="margin-bottom:12px">
            Dengan mengirim formulir ini, Anda menyetujui pemrosesan data sesuai <a href="{{ route('kebijakan-privasi') }}">Kebijakan Privasi</a> kami (UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi).
          </p>
          <button class="btn btn-primary" type="submit">Kirim Pendaftaran</button>
        </div>
      </form>
    </div>
  </section>

  <section id="kontak" class="alt">
    <div class="container split">
      <div>
        <p class="eyebrow">Kontak & Lokasi</p>
        <h2>Hubungi kami</h2>
        <p class="lead" style="font-size:1.02rem;line-height:1.7">
          <strong>Sekretariat Karang Taruna 04 (KARUPAT):</strong><br>
          {{ $pengaturan['alamat'] ?? 'Wadassari RT 004/RW 002, Kel. Pondok Betung, Kec. Pondok Aren, Tangerang Selatan, Banten, 15221' }}
        </p>
        <ul class="contact-list" style="margin-top:16px">
          <li><strong>WhatsApp / Telepon:</strong> <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" style="font-weight:600">{{ $pengaturan['telepon'] ?? '+62 852-1533-8228' }}</a></li>
          <li><strong>Instagram:</strong> <a href="{{ $pengaturan['instagram'] ?? 'https://www.instagram.com/karupat0402_?obrf=N285cXV4Zml6dmV0' }}" target="_blank" rel="noopener" style="color:#c5a059;font-weight:600">@karupat0402_</a></li>
          <li><strong>Email:</strong> {{ $pengaturan['email'] ?? 'karupat04@karangtaruna.or.id' }}</li>
          <li><strong>Jam sekretariat:</strong> {{ $pengaturan['jam_sekretariat'] ?? 'Senin sampai Sabtu, 16.00 sampai 21.00 WIB' }}</li>
        </ul>
        <div class="hero-actions" style="margin-top:20px">
          <a class="btn btn-primary" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener">Chat via WhatsApp</a>
          @if(!empty($pengaturan['instagram']))
            <a class="btn btn-ghost" href="{{ $pengaturan['instagram'] }}" target="_blank" rel="noopener">Instagram</a>
          @endif
        </div>
      </div>

      <form class="form" method="POST" action="{{ route('kontak.store') }}" data-validate="true" novalidate style="margin-top:0">
        @csrf
        <x-field-form id="nama-k" name="nama" label="Nama" autocomplete="name" :required="true" />
        <x-field-form id="email-k" name="email" label="Email" type="email" autocomplete="email" :required="true" />
        <x-field-form id="subjek-k" name="subjek" label="Subjek (opsional)" :full="true" />
        <x-field-form id="isi-k" name="isi" label="Pesan" type="textarea" :full="true" :required="true" />

        <div class="hp" aria-hidden="true">
          <label>Kosongkan kolom ini<input name="website" tabindex="-1" autocomplete="off"></label>
        </div>

        <div class="full">
          <p class="meta" style="margin-bottom:12px">
            Data Anda dilindungi sesuai <a href="{{ route('kebijakan-privasi') }}">Kebijakan Privasi</a>.
          </p>
          <button class="btn btn-primary" type="submit">Kirim Pesan</button>
        </div>
      </form>
    </div>

    <!-- Peta Lokasi Google Maps -->
    <div class="container" style="margin-top:40px">
      <div class="card" style="padding:14px;border-radius:18px;overflow:hidden">
        <div class="row" style="margin-bottom:10px;padding:4px 6px">
          <div>
            <h3 style="margin:0">Peta Lokasi Sekretariat KARUPAT</h3>
            <p class="meta" style="margin:2px 0 0">Pondok Aren, Pondok Betung, Wadassari RT 004/RW 002, Tangsel, Banten, 15221</p>
          </div>
          <a class="btn btn-ghost btn-sm" href="https://maps.google.com/?q={{ urlencode($pengaturan['alamat'] ?? 'Wadassari RT 004/RW 002, Pondok Betung, Pondok Aren, Tangerang Selatan') }}" target="_blank" rel="noopener">
            Petunjuk Arah ↗
          </a>
        </div>
        <div style="width:100%;height:320px;border-radius:12px;overflow:hidden;border:1px solid var(--border)">
          <iframe
            src="https://maps.google.com/maps?q={{ urlencode($pengaturan['alamat'] ?? 'Wadassari RT 004/RW 002, Pondok Betung, Pondok Aren, Tangerang Selatan') }}&t=&z=16&ie=UTF8&iwloc=&output=embed"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Peta Lokasi Karang Taruna 04 Wadassari Pondok Betung">
          </iframe>
        </div>
      </div>
    </div>
  </section>

  <div id="lightbox" class="lightbox" aria-hidden="true" role="dialog" aria-label="Pratinjau foto">
    <div class="lightbox-inner">
      <img id="lightbox-img" src="" alt="">
      <div class="row">
        <p id="lightbox-caption" class="meta"></p>
        <button id="lightbox-close" type="button" class="btn btn-ghost btn-sm">Tutup</button>
      </div>
    </div>
  </div>
@endsection
