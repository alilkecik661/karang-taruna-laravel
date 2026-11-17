@extends('layouts.admin', ['title' => 'Edit Kegiatan'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.kegiatan.index') }}">← Kembali ke Kegiatan</a></p>
  <h1>Edit Kegiatan</h1>

  <form class="form card" method="POST" action="{{ route('admin.kegiatan.update', $kegiatan) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <x-field-form id="judul" name="judul" label="Judul kegiatan" :value="$kegiatan->judul" :required="true" />
    <x-field-form id="lokasi" name="lokasi" label="Lokasi" :value="$kegiatan->lokasi" :required="true" />
    <x-field-form id="tanggal_mulai" name="tanggal_mulai" label="Tanggal & jam mulai" type="datetime-local" :value="$kegiatan->tanggal_mulai?->format('Y-m-d\TH:i')" :required="true" />
    <x-field-form id="tanggal_selesai" name="tanggal_selesai" label="Tanggal & jam selesai (opsional)" type="datetime-local" :value="$kegiatan->tanggal_selesai?->format('Y-m-d\TH:i')" />

    <x-field-form id="bidang_id" name="bidang_id" label="Bidang program" type="select">
      <option value="">Umum / Semua Bidang</option>
      @foreach($bidangList as $b)
        <option value="{{ $b->id }}" @selected(old('bidang_id', $kegiatan->bidang_id) == $b->id)>{{ $b->nama }}</option>
      @endforeach
    </x-field-form>

    <x-field-form id="status" name="status" label="Status publikasi" type="select" :required="true">
      <option value="draft" @selected(old('status', $kegiatan->status) === 'draft')>Draft</option>
      <option value="publish" @selected(old('status', $kegiatan->status) === 'publish')>Publish</option>
    </x-field-form>

    <x-field-form id="gambar_sampul" name="gambar_sampul" label="Ganti gambar sampul (opsional)" type="file" :full="true" />
    <x-field-form id="deskripsi" name="deskripsi" label="Deskripsi lengkap" type="textarea" :value="$kegiatan->deskripsi" :full="true" :required="true" />

    <div class="full">
      <button class="btn btn-primary" type="submit">Perbarui Kegiatan</button>
    </div>
  </form>
@endsection
