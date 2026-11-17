@extends('layouts.app', [
    'title' => 'Kegiatan',
    'metaDescription' => 'Daftar program kerja dan jadwal kegiatan Karang Taruna.'
])

@section('content')
  @php
    $daftarBulan = [
      1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
      5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
      9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
  @endphp

  <section>
    <div class="container">
      <p class="eyebrow">Program Kerja</p>
      <h1>Daftar Kegiatan</h1>
      <p class="lead">Ikuti berbagai kegiatan positif bersama pemuda dan masyarakat lingkungan kami.</p>

      <form method="GET" action="{{ route('kegiatan.index') }}" class="card" style="margin-top:24px">
        <div class="row">
          <div class="field" style="flex:1;min-width:180px">
            <label for="bidang">Filter Bidang</label>
            <select id="bidang" name="bidang">
              <option value="">Semua Bidang</option>
              @foreach($bidangList as $b)
                <option value="{{ $b->id }}" @selected((string) request('bidang') === (string) $b->id)>{{ $b->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="field" style="flex:1;min-width:180px">
            <label for="bulan">Filter Bulan</label>
            <select id="bulan" name="bulan">
              <option value="">Semua Bulan</option>
              @foreach($daftarBulan as $num => $namaBulan)
                <option value="{{ $num }}" @selected((string) request('bulan') === (string) $num)>{{ $namaBulan }}</option>
              @endforeach
            </select>
          </div>
          <div style="padding-top:24px;display:flex;gap:8px">
            <button class="btn btn-primary btn-sm" type="submit">Terapkan</button>
            @if(request()->filled('bidang') || request()->filled('bulan'))
              <a class="btn btn-ghost btn-sm" href="{{ route('kegiatan.index') }}">Reset</a>
            @endif
          </div>
        </div>
      </form>

      <div class="grid">
        @forelse($kegiatan as $item)
          <x-kartu-kegiatan :kegiatan="$item" />
        @empty
          <div class="card full">
            <h3>Belum ada kegiatan yang sesuai filter</h3>
            <p>Silakan pilih bulan atau bidang lain, atau kembali lagi nanti.</p>
          </div>
        @endforelse
      </div>

      <div class="pagination-wrap">
        {{ $kegiatan->links() }}
      </div>
    </div>
  </section>
@endsection
