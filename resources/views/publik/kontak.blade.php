@extends('layouts.app', [
    'title' => 'Hubungi Kami',
    'metaDescription' => 'Formulir kontak, alamat sekretariat, nomor WhatsApp, dan lokasi resmi Karang Taruna 04 (KARUPAT).'
])

@section('content')
  @php
    $waNumber = preg_replace('/[^0-9]/', '', (string) ($pengaturan['whatsapp'] ?? '6285215338228'));
    if (str_starts_with($waNumber, '0')) {
        $waNumber = '62' . substr($waNumber, 1);
    }
    $mapsQuery = urlencode($pengaturan['alamat'] ?? 'Wadassari RT 004/RW 002, Pondok Betung, Pondok Aren, Tangerang Selatan');
  @endphp

  <section>
    <div class="container split">
      <div>
        <p class="eyebrow">Kontak & Lokasi</p>
        <h1>Hubungi Kami</h1>
        <p class="lead" style="font-size:1.05rem;line-height:1.7">
          <strong>Sekretariat Karang Taruna 04 (KARUPAT):</strong><br>
          {{ $pengaturan['alamat'] ?? 'Wadassari RT 004/RW 002, Kel. Pondok Betung, Kec. Pondok Aren, Tangerang Selatan, Banten, 15221' }}
        </p>

        <ul class="contact-list" style="margin-top:20px;font-size:0.98rem">
          <li>
            <strong>WhatsApp / Telepon:</strong>
            <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" style="color:var(--primary);font-weight:600">
              {{ $pengaturan['telepon'] ?? '+62 852-1533-8228' }}
            </a>
          </li>
          <li>
            <strong>Instagram:</strong>
            <a href="{{ $pengaturan['instagram'] ?? 'https://www.instagram.com/karupat0402_?obrf=N285cXV4Zml6dmV0' }}" target="_blank" rel="noopener" style="color:#c5a059;font-weight:600">
              @karupat0402_
            </a>
          </li>
          <li>
            <strong>Email:</strong>
            <a href="mailto:{{ $pengaturan['email'] ?? 'karupat04@karangtaruna.or.id' }}" style="color:var(--primary)">
              {{ $pengaturan['email'] ?? 'karupat04@karangtaruna.or.id' }}
            </a>
          </li>
          <li>
            <strong>Jam Sekretariat:</strong>
            {{ $pengaturan['jam_sekretariat'] ?? 'Senin sampai Sabtu, 16.00 sampai 21.00 WIB' }}
          </li>
        </ul>

        <div class="hero-actions" style="margin-top:24px">
          <a class="btn btn-primary" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener">
            Chat via WhatsApp
          </a>
          @if(!empty($pengaturan['instagram']))
            <a class="btn btn-ghost" href="{{ $pengaturan['instagram'] }}" target="_blank" rel="noopener">
              Instagram @karupat0402_
            </a>
          @endif
          <a class="btn btn-ghost" href="https://maps.google.com/?q={{ $mapsQuery }}" target="_blank" rel="noopener">
            Buka di Google Maps
          </a>
        </div>
      </div>

      <div>
        @if(session('sukses'))
          <div class="notice show" role="status" style="margin-bottom:20px">{{ session('sukses') }}</div>
        @endif

        <form class="form" method="POST" action="{{ route('kontak.store') }}" data-validate="true" novalidate style="margin-top:0">
          @csrf
          <x-field-form id="nama" name="nama" label="Nama" autocomplete="name" :required="true" />
          <x-field-form id="email" name="email" label="Email" type="email" autocomplete="email" :required="true" />
          <x-field-form id="subjek" name="subjek" label="Subjek (opsional)" :full="true" />
          <x-field-form id="isi" name="isi" label="Pesan" type="textarea" :full="true" :required="true" />

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
    </div>

    <!-- Peta Lokasi Google Maps -->
    <div class="container" style="margin-top:48px">
      <div class="card" style="padding:16px;border-radius:18px;overflow:hidden">
        <div class="row" style="margin-bottom:12px;padding:4px 8px">
          <div>
            <h3 style="margin:0">Peta Lokasi Sekretariat KARUPAT</h3>
            <p class="meta" style="margin:2px 0 0">Pondok Aren, Pondok Betung, Wadassari RT 004/RW 002, Tangsel, Banten, 15221</p>
          </div>
          <a class="btn btn-ghost btn-sm" href="https://maps.google.com/?q={{ $mapsQuery }}" target="_blank" rel="noopener">
            Petunjuk Arah ↗
          </a>
        </div>
        <div style="width:100%;height:380px;border-radius:12px;overflow:hidden;border:1px solid var(--border)">
          <iframe
            src="https://maps.google.com/maps?q={{ $mapsQuery }}&t=&z=16&ie=UTF8&iwloc=&output=embed"
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
@endsection
