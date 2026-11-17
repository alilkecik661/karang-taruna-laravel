@extends('layouts.admin', ['title' => 'Tambah Akun'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.pengguna.index') }}">← Kembali ke Pengguna</a></p>
  <h1>Tambah Akun Pengurus / Admin</h1>

  <form class="form card" method="POST" action="{{ route('admin.pengguna.store') }}">
    @csrf
    <x-field-form id="name" name="name" label="Nama lengkap" :required="true" />
    <x-field-form id="email" name="email" label="Alamat email" type="email" :required="true" />
    <x-field-form id="password" name="password" label="Kata sandi (minimal 8 karakter)" type="password" :required="true" />

    <x-field-form id="role" name="role" label="Peran (role)" type="select" :required="true">
      <option value="pengurus">Pengurus Bidang</option>
      <option value="superadmin">Superadmin</option>
    </x-field-form>

    <x-field-form id="bidang_id" name="bidang_id" label="Bidang (khusus pengurus bidang)" type="select" :full="true">
      <option value="">Tanpa bidang spesifik</option>
      @foreach($bidangList as $b)
        <option value="{{ $b->id }}">{{ $b->nama }}</option>
      @endforeach
    </x-field-form>

    <div class="full">
      <button class="btn btn-primary" type="submit">Simpan Akun</button>
    </div>
  </form>
@endsection
