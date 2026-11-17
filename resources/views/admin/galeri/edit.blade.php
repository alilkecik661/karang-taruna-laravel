@extends('layouts.admin', ['title' => 'Kelola Album Galeri'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.galeri.index') }}">← Kembali ke Galeri</a></p>
  <h1>Kelola Album: {{ $album->judul }}</h1>

  <div class="split" style="margin-top:20px">
    <form class="form card" method="POST" action="{{ route('admin.galeri.update', $album) }}" style="margin-top:0">
      @csrf
      @method('PUT')
      <h3 class="full">Informasi Album</h3>
      <x-field-form id="judul" name="judul" label="Judul album" :value="$album->judul" :full="true" :required="true" />

      <x-field-form id="kegiatan_id" name="kegiatan_id" label="Kegiatan terkait" type="select" :full="true">
        <option value="">Tidak dihubungkan</option>
        @foreach($kegiatanList as $k)
          <option value="{{ $k->id }}" @selected($album->kegiatan_id == $k->id)>{{ $k->judul }}</option>
        @endforeach
      </x-field-form>

      <x-field-form id="deskripsi" name="deskripsi" label="Deskripsi" type="textarea" :value="$album->deskripsi" :full="true" />

      <div class="full">
        <button class="btn btn-primary btn-sm" type="submit">Simpan Perubahan</button>
      </div>
    </form>

    <form class="form card" method="POST" action="{{ route('admin.galeri.foto.store', $album) }}" enctype="multipart/form-data" style="margin-top:0">
      @csrf
      <h3 class="full">Unggah Foto ke Album</h3>
      <x-field-form id="file_foto" name="file_foto" label="Pilih file foto (JPG/PNG/WebP)" type="file" :full="true" :required="true" />
      <x-field-form id="caption" name="caption" label="Keterangan foto (caption)" :full="true" />
      <div class="full">
        <button class="btn btn-primary btn-sm" type="submit">Unggah & Kompres WebP</button>
      </div>
    </form>
  </div>

  <h2 class="sub">Daftar Foto dalam Album ({{ $album->foto->count() }})</h2>
  <div class="grid">
    @forelse($album->foto as $foto)
      @php
        $src = str_starts_with($foto->path, 'images/') ? asset($foto->path) : asset('storage/' . $foto->path);
      @endphp
      <div class="card">
        <img class="card-cover" src="{{ $src }}" alt="{{ $foto->caption }}">
        <p>{{ $foto->caption ?: 'Tanpa keterangan' }}</p>
        <form method="POST" action="{{ route('admin.galeri.foto.destroy', $foto) }}" onsubmit="return confirm('Hapus foto ini?')">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger btn-sm" type="submit">Hapus Foto</button>
        </form>
      </div>
    @empty
      <p class="meta">Belum ada foto di album ini.</p>
    @endforelse
  </div>
@endsection
