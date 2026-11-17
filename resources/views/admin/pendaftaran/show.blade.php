@extends('layouts.admin', ['title' => 'Detail Pendaftaran'])

@section('content')
  <p class="eyebrow"><a href="{{ route('admin.pendaftaran.index') }}">← Kembali ke Pendaftaran</a></p>
  <h1>Detail Pendaftar: {{ $pendaftaran->nama_lengkap }}</h1>

  <div class="split" style="margin-top:24px">
    <div class="card">
      <h3>Data Calon Anggota</h3>
      <ul class="contact-list">
        <li><strong>Nama Lengkap:</strong> {{ $pendaftaran->nama_lengkap }}</li>
        <li><strong>Jenis Kelamin:</strong> {{ $pendaftaran->jenis_kelamin }}</li>
        <li><strong>Tanggal Lahir:</strong> {{ $pendaftaran->tanggal_lahir?->format('d M Y') }}</li>
        <li><strong>Nomor WhatsApp:</strong> {{ $pendaftaran->no_whatsapp }}</li>
        <li><strong>Email:</strong> {{ $pendaftaran->email ?: '-' }}</li>
        <li><strong>Bidang Minat:</strong> {{ $pendaftaran->bidang_minat ?: '-' }}</li>
        <li><strong>Alamat:</strong> {{ $pendaftaran->alamat }}</li>
        <li><strong>Tanggal Daftar:</strong> {{ $pendaftaran->created_at?->format('d M Y H:i') }}</li>
      </ul>
    </div>

    @can('update', $pendaftaran)
      <form class="form card" method="POST" action="{{ route('admin.pendaftaran.update', $pendaftaran) }}" style="margin-top:0">
        @csrf
        @method('PATCH')
        <h3 class="full">Ubah Status & Catatan Admin</h3>

        <x-field-form id="status" name="status" label="Status pendaftaran" type="select" :full="true" :required="true">
          <option value="baru" @selected($pendaftaran->status === 'baru')>Baru</option>
          <option value="diproses" @selected($pendaftaran->status === 'diproses')>Diproses</option>
          <option value="diterima" @selected($pendaftaran->status === 'diterima')>Diterima</option>
          <option value="ditolak" @selected($pendaftaran->status === 'ditolak')>Ditolak</option>
        </x-field-form>

        <x-field-form id="catatan_admin" name="catatan_admin" label="Catatan admin" type="textarea" :value="$pendaftaran->catatan_admin" :full="true" />

        <div class="full">
          <button class="btn btn-primary" type="submit">Simpan Status</button>
        </div>
      </form>
    @else
      <div class="card">
        <h3>Status Pendaftaran</h3>
        <p><span class="badge">{{ ucfirst($pendaftaran->status) }}</span></p>
        <p class="meta">Catatan: {{ $pendaftaran->catatan_admin ?: '-' }}</p>
      </div>
    @endcan
  </div>
@endsection
