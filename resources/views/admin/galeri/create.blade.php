@extends('layouts.admin', ['title' => 'Buat Album Galeri'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.galeri.index') }}">← Kembali ke Galeri</a></p>
  <h1>Buat Album Galeri Baru</h1>

  <form class="form card" method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data">
    @csrf
    <x-field-form id="judul" name="judul" label="Judul album" :required="true" />

    <x-field-form id="kegiatan_id" name="kegiatan_id" label="Hubungkan dengan kegiatan (opsional)" type="select">
      <option value="">Tidak dihubungkan</option>
      @foreach($kegiatanList as $k)
        <option value="{{ $k->id }}">{{ $k->judul }}</option>
      @endforeach
    </x-field-form>

    <x-field-form id="deskripsi" name="deskripsi" label="Deskripsi album" type="textarea" :full="true" />

    <div class="field full">
      <label for="foto">Unggah foto awal (bisa pilih beberapa file, otomatis dikonversi ke WebP)</label>
      <input id="foto" type="file" name="foto[]" multiple accept="image/*">
    </div>

    <div class="full">
      <button class="btn btn-primary" type="submit">Buat Album</button>
    </div>
  </form>
@endsection
