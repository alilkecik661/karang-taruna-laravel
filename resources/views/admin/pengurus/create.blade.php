@extends('layouts.admin', ['title' => 'Tambah Pengurus'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.pengurus.index') }}">← Kembali ke Struktur Pengurus</a></p>
  <h1>Tambah Pengurus Baru</h1>

  <form class="form card" method="POST" action="{{ route('admin.pengurus.store') }}" enctype="multipart/form-data">
    @csrf
    <x-field-form id="nama" name="nama" label="Nama lengkap" :required="true" />
    <x-field-form id="jabatan" name="jabatan" label="Jabatan" :required="true" />

    <x-field-form id="bidang_id" name="bidang_id" label="Bidang (opsional)" type="select">
      <option value="">Pengurus Inti</option>
      @foreach($bidangList as $b)
        <option value="{{ $b->id }}">{{ $b->nama }}</option>
      @endforeach
    </x-field-form>

    <x-field-form id="urutan" name="urutan" label="Urutan tampil" type="number" value="1" :required="true" />
    <x-field-form id="foto" name="foto" label="Foto profil (opsional)" type="file" :full="true" />

    <div class="field full">
      <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer">
        <input type="checkbox" name="is_aktif" value="1" checked style="width:18px;min-height:18px">
        <span>Tampilkan sebagai pengurus aktif</span>
      </label>
    </div>

    <div class="full">
      <button class="btn btn-primary" type="submit">Simpan Pengurus</button>
    </div>
  </form>
@endsection
