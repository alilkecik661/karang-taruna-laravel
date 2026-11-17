@extends('layouts.admin', ['title' => 'Tambah Kegiatan'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.kegiatan.index') }}">← Kembali ke Kegiatan</a></p>
  <h1>Tambah Kegiatan Baru</h1>

  <form class="form card" method="POST" action="{{ route('admin.kegiatan.store') }}" enctype="multipart/form-data">
    @csrf
    <x-field-form id="judul" name="judul" label="Judul kegiatan" :required="true" />
    <x-field-form id="lokasi" name="lokasi" label="Lokasi" :required="true" />
    <x-field-form id="tanggal_mulai" name="tanggal_mulai" label="Tanggal & jam mulai" type="datetime-local" :required="true" />
    <x-field-form id="tanggal_selesai" name="tanggal_selesai" label="Tanggal & jam selesai (opsional)" type="datetime-local" />

    <x-field-form id="bidang_id" name="bidang_id" label="Bidang program" type="select">
      <option value="">Umum / Semua Bidang</option>
      @foreach($bidangList as $b)
        <option value="{{ $b->id }}" @selected(old('bidang_id') == $b->id)>{{ $b->nama }}</option>
      @endforeach
    </x-field-form>

    <x-field-form id="status" name="status" label="Status publikasi" type="select" :required="true">
      <option value="draft" @selected(old('status') === 'draft')>Draft</option>
      <option value="publish" @selected(old('status', 'publish') === 'publish')>Publish</option>
    </x-field-form>

    <x-field-form id="gambar_sampul" name="gambar_sampul" label="Gambar sampul (otomatis dikonversi ke WebP)" type="file" :full="true" />
    <x-field-form id="deskripsi" name="deskripsi" label="Deskripsi lengkap" type="textarea" :full="true" :required="true" />

    <div class="full">
      <button class="btn btn-primary" type="submit">Simpan Kegiatan</button>
    </div>
  </form>
@endsection
