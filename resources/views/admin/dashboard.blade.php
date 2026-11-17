@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
  <div class="row">
    <div>
      <p class="eyebrow">Ringkasan Sistem</p>
      <h1>Dashboard Pengurus</h1>
    </div>
    <div class="row">
      <a class="btn btn-primary btn-sm" href="{{ route('admin.kegiatan.create') }}">+ Tambah Kegiatan</a>
      <a class="btn btn-ghost btn-sm" href="{{ route('admin.berita.create') }}">+ Tulis Berita</a>
    </div>
  </div>

  <div class="grid">
    <div class="card">
      <span class="meta">Pendaftar Baru</span>
      <strong style="font-size:2rem;color:var(--primary)">{{ $jumlahPendaftarBaru }}</strong>
      <a href="{{ route('admin.pendaftaran.index', ['status' => 'baru']) }}" class="meta">Lihat daftar pendaftar →</a>
    </div>
    <div class="card">
      <span class="meta">Pesan Belum Dibaca</span>
      <strong style="font-size:2rem;color:var(--primary)">{{ $jumlahPesanBelumDibaca }}</strong>
      <a href="{{ route('admin.pesan-kontak.index') }}" class="meta">Buka kotak masuk →</a>
    </div>
    <div class="card">
      <span class="meta">Kegiatan Mendatang</span>
      <strong style="font-size:2rem;color:var(--primary)">{{ $jumlahKegiatanMendatang }}</strong>
      <a href="{{ route('admin.kegiatan.index') }}" class="meta">Kelola kegiatan →</a>
    </div>
    <div class="card">
      <span class="meta">Berita Dipublikasikan</span>
      <strong style="font-size:2rem;color:var(--primary)">{{ $jumlahBeritaPublish }}</strong>
      <a href="{{ route('admin.berita.index') }}" class="meta">Kelola berita →</a>
    </div>
  </div>

  <div class="split" style="margin-top:32px">
    <div class="card">
      <div class="row">
        <h3>Pendaftar Anggota Terbaru</h3>
        <a href="{{ route('admin.pendaftaran.index') }}" class="meta">Semua</a>
      </div>
      <div class="table-wrap">
        <table class="data-table">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Minat</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pendaftarTerbaru as $p)
              <tr>
                <td>{{ $p->nama_lengkap }}</td>
                <td>{{ $p->bidang_minat ?: '-' }}</td>
                <td><span class="badge">{{ ucfirst($p->status) }}</span></td>
                <td><a href="{{ route('admin.pendaftaran.show', $p) }}">Detail</a></td>
              </tr>
            @empty
              <tr><td colspan="4" class="meta">Belum ada pendaftar.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <div class="row">
        <h3>Kegiatan Mendatang</h3>
        <a href="{{ route('admin.kegiatan.index') }}" class="meta">Semua</a>
      </div>
      <div class="table-wrap">
        <table class="data-table">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Tanggal</th>
              <th>Lokasi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($kegiatanMendatang as $k)
              <tr>
                <td>{{ $k->judul }}</td>
                <td>{{ $k->tanggal_mulai?->format('d M Y H:i') }}</td>
                <td>{{ $k->lokasi }}</td>
              </tr>
            @empty
              <tr><td colspan="3" class="meta">Belum ada kegiatan mendatang.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
