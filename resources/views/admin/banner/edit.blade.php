@extends('layouts.admin', ['title' => 'Edit Banner'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.banner.index') }}">← Kembali ke Banner</a></p>
  <h1>Edit Banner Beranda</h1>

  <form class="form card" method="POST" action="{{ route('admin.banner.update', $banner) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <x-field-form id="judul" name="judul" label="Judul utama" :value="$banner->judul" :full="true" :required="true" />
    <x-field-form id="subjudul" name="subjudul" label="Subjudul (eyebrow)" :value="$banner->subjudul" />
    <x-field-form id="tautan" name="tautan" label="Tautan tombol" :value="$banner->tautan" />
    <x-field-form id="urutan" name="urutan" label="Urutan" type="number" :value="$banner->urutan" :required="true" />
    <x-field-form id="gambar" name="gambar" label="Ganti gambar banner (opsional)" type="file" />

    <div class="field full">
      <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer">
        <input type="checkbox" name="is_aktif" value="1" @checked($banner->is_aktif) style="width:18px;min-height:18px">
        <span>Aktifkan banner ini</span>
      </label>
    </div>

    <div class="full">
      <button class="btn btn-primary" type="submit">Perbarui Banner</button>
    </div>
  </form>
@endsection
