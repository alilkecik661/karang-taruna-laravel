@extends('layouts.admin', ['title' => 'Tambah Banner'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.banner.index') }}">← Kembali ke Banner</a></p>
  <h1>Tambah Banner Beranda</h1>

  <form class="form card" method="POST" action="{{ route('admin.banner.store') }}" enctype="multipart/form-data">
    @csrf
    <x-field-form id="judul" name="judul" label="Judul utama" :full="true" :required="true" />
    <x-field-form id="subjudul" name="subjudul" label="Subjudul (eyebrow)" />
    <x-field-form id="tautan" name="tautan" label="Tautan tombol" value="/daftar" />
    <x-field-form id="urutan" name="urutan" label="Urutan" type="number" value="1" :required="true" />
    <x-field-form id="gambar" name="gambar" label="Gambar banner (opsional)" type="file" />

    <div class="field full">
      <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer">
        <input type="checkbox" name="is_aktif" value="1" checked style="width:18px;min-height:18px">
        <span>Aktifkan banner ini</span>
      </label>
    </div>

    <div class="full">
      <button class="btn btn-primary" type="submit">Simpan Banner</button>
    </div>
  </form>
@endsection
