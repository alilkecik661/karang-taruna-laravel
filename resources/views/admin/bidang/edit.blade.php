@extends('layouts.admin', ['title' => 'Edit Bidang'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.bidang.index') }}">← Kembali ke Bidang</a></p>
  <h1>Edit Bidang</h1>

  <form class="form card" method="POST" action="{{ route('admin.bidang.update', $bidang) }}">
    @csrf
    @method('PUT')
    <x-field-form id="nama" name="nama" label="Nama bidang" :value="$bidang->nama" :full="true" :required="true" />
    <x-field-form id="deskripsi" name="deskripsi" label="Deskripsi bidang" type="textarea" :value="$bidang->deskripsi" :full="true" />
    <div class="full">
      <button class="btn btn-primary" type="submit">Perbarui Bidang</button>
    </div>
  </form>
@endsection
