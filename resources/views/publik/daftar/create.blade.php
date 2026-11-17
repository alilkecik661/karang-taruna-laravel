@extends('layouts.app', [
    'title' => 'Daftar Anggota Baru',
    'metaDescription' => 'Formulir pendaftaran anggota baru Karang Taruna secara online.'
])

@section('content')
  <section>
    <div class="container">
      <p class="eyebrow">Pendaftaran Anggota</p>
      <h1>Daftar Jadi Anggota Karang Taruna</h1>
      <p class="lead">Isi data berikut dengan benar. Pengurus akan menghubungi Anda melalui WhatsApp atau email untuk konfirmasi keanggotaan.</p>

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
          <p class="meta" style="margin-bottom:14px">
            Data pribadi Anda dilindungi sesuai UU Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi. Baca <a href="{{ route('kebijakan-privasi') }}">Kebijakan Privasi</a> kami.
          </p>
          <button class="btn btn-primary" type="submit">Kirim Pendaftaran</button>
        </div>
      </form>
    </div>
  </section>
@endsection
