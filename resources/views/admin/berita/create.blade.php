@extends('layouts.admin', ['title' => 'Tulis Berita'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.berita.index') }}">← Kembali ke Berita</a></p>
  <h1>Tulis Berita Baru</h1>

  <form class="form card" method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
    @csrf
    <x-field-form id="judul" name="judul" label="Judul berita" :full="true" :required="true" />

    <x-field-form id="status" name="status" label="Status publikasi" type="select" :required="true">
      <option value="draft" @selected(old('status') === 'draft')>Draft</option>
      <option value="publish" @selected(old('status', 'publish') === 'publish')>Publish</option>
    </x-field-form>

    <div class="field" style="padding-top:28px">
      <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer">
        <input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned')) style="width:18px;min-height:18px">
        <span>Sematkan berita penting ini di bagian atas</span>
      </label>
    </div>

    <x-field-form id="gambar_sampul" name="gambar_sampul" label="Gambar sampul (opsional)" type="file" :full="true" />
    <x-field-form id="isi" name="isi" label="Isi berita" type="textarea" :full="true" :required="true" />

    <div class="full">
      <button class="btn btn-primary" type="submit">Simpan Berita</button>
    </div>
  </form>
@endsection
