@extends('layouts.admin', ['title' => 'Pengaturan Website'])

@section('content')
  <p class="eyebrow">Konfigurasi Sistem</p>
  <h1>Pengaturan Website</h1>

  <form class="form card" method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <h3 class="full">Identitas & Beranda</h3>
    <x-field-form id="nama_organisasi" name="nama_organisasi" label="Nama organisasi" :value="$pengaturan['nama_organisasi'] ?? ''" :required="true" />
    <x-field-form id="teks_logo" name="teks_logo" label="Teks logo singkat" :value="$pengaturan['teks_logo'] ?? 'KT'" :required="true" />
    <x-field-form id="subjudul_organisasi" name="subjudul_organisasi" label="Subjudul beranda" :value="$pengaturan['subjudul_organisasi'] ?? ''" />
    <x-field-form id="judul_hero" name="judul_hero" label="Judul hero beranda" :value="$pengaturan['judul_hero'] ?? ''" />
    <x-field-form id="deskripsi_singkat" name="deskripsi_singkat" label="Deskripsi singkat beranda" type="textarea" :value="$pengaturan['deskripsi_singkat'] ?? ''" :full="true" />
    <x-field-form id="logo_file" name="logo_file" label="Unggah gambar logo (opsional)" type="file" :full="true" />

    <h3 class="full" style="margin-top:16px">Statistik Beranda</h3>
    <x-field-form id="stat_anggota" name="stat_anggota" label="Jumlah anggota aktif" :value="$pengaturan['stat_anggota'] ?? '120+'" />
    <x-field-form id="stat_kegiatan" name="stat_kegiatan" label="Jumlah kegiatan tahun ini" :value="$pengaturan['stat_kegiatan'] ?? '24'" />
    <x-field-form id="stat_bidang" name="stat_bidang" label="Jumlah bidang program" :value="$pengaturan['stat_bidang'] ?? '8'" />

    <h3 class="full" style="margin-top:16px">Profil, Visi, dan Misi</h3>
    <x-field-form id="sejarah" name="sejarah" label="Sejarah singkat" type="textarea" :value="$pengaturan['sejarah'] ?? ''" :full="true" />
    <x-field-form id="visi" name="visi" label="Visi" type="textarea" :value="$pengaturan['visi'] ?? ''" :full="true" />
    <x-field-form id="misi" name="misi" label="Misi (satu poin per baris)" type="textarea" :value="$pengaturan['misi'] ?? ''" :full="true" />
    <x-field-form id="tujuan" name="tujuan" label="Tujuan organisasi" type="textarea" :value="$pengaturan['tujuan'] ?? ''" :full="true" />

    <h3 class="full" style="margin-top:16px">Kontak & Media Sosial</h3>
    <x-field-form id="alamat" name="alamat" label="Alamat sekretariat" :value="$pengaturan['alamat'] ?? ''" :full="true" :required="true" />
    <x-field-form id="telepon" name="telepon" label="Nomor telepon" :value="$pengaturan['telepon'] ?? ''" />
    <x-field-form id="whatsapp" name="whatsapp" label="Nomor WhatsApp (awalan 62)" :value="$pengaturan['whatsapp'] ?? ''" />
    <x-field-form id="email" name="email" label="Email resmi" type="email" :value="$pengaturan['email'] ?? ''" />
    <x-field-form id="jam_sekretariat" name="jam_sekretariat" label="Jam operasional sekretariat" :value="$pengaturan['jam_sekretariat'] ?? ''" />
    <x-field-form id="instagram" name="instagram" label="Tautan Instagram" :value="$pengaturan['instagram'] ?? ''" />
    <x-field-form id="facebook" name="facebook" label="Tautan Facebook" :value="$pengaturan['facebook'] ?? ''" />
    <x-field-form id="youtube" name="youtube" label="Tautan YouTube" :value="$pengaturan['youtube'] ?? ''" />
    <x-field-form id="maps_embed" name="maps_embed" label="URL Embed / Iframe Google Maps" :value="$pengaturan['maps_embed'] ?? ''" :full="true" />

    <div class="full">
      <button class="btn btn-primary" type="submit">Simpan Pengaturan</button>
    </div>
  </form>
@endsection
