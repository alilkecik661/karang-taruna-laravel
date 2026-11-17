@extends('layouts.admin', ['title' => 'Edit Akun'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.pengguna.index') }}">← Kembali ke Pengguna</a></p>
  <h1>Edit Akun: {{ $user->name }}</h1>

  <form class="form card" method="POST" action="{{ route('admin.pengguna.update', $user) }}">
    @csrf
    @method('PUT')
    <x-field-form id="name" name="name" label="Nama lengkap" :value="$user->name" :required="true" />
    <x-field-form id="email" name="email" label="Alamat email" type="email" :value="$user->email" :required="true" />
    <x-field-form id="password" name="password" label="Kata sandi baru (kosongkan jika tidak diubah)" type="password" />

    <x-field-form id="role" name="role" label="Peran (role)" type="select" :required="true">
      <option value="pengurus" @selected($user->role === 'pengurus')>Pengurus Bidang</option>
      <option value="superadmin" @selected($user->role === 'superadmin')>Superadmin</option>
    </x-field-form>

    <x-field-form id="bidang_id" name="bidang_id" label="Bidang (khusus pengurus bidang)" type="select" :full="true">
      <option value="">Tanpa bidang spesifik</option>
      @foreach($bidangList as $b)
        <option value="{{ $b->id }}" @selected($user->bidang_id == $b->id)>{{ $b->nama }}</option>
      @endforeach
    </x-field-form>

    <div class="full">
      <button class="btn btn-primary" type="submit">Perbarui Akun</button>
    </div>
  </form>
@endsection
