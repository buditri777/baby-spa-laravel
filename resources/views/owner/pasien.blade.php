@extends('layouts.app')
@section('title','Pasien')
@section('page-title','Data Pasien')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Daftar Pasien</span>
  </div>
  <div class="card-body">
    <form class="row g-2 mb-3" method="GET">
      <div class="col-sm-6"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama anak / orang tua..." value="{{ request('search') }}"></div>
      <div class="col-sm-4"><input type="text" name="province" class="form-control form-control-sm" placeholder="Filter provinsi..." value="{{ request('province') }}"></div>
      <div class="col-sm-2"><button class="btn btn-sm btn-outline-secondary w-100">Filter</button></div>
    </form>
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Nama Anak</th><th>Orang Tua</th><th>Gender</th><th>Tgl Lahir</th><th>Wilayah</th><th>Total Booking</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($children as $c)
        <tr>
          <td>{{ $c->name }}</td>
          <td>{{ $c->parent?->name }}</td>
          <td>{{ $c->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
          <td>{{ $c->birth_date?->format('d M Y') }}</td>
          <td>{{ $c->parent?->city ?? $c->parent?->province ?? '-' }}</td>
          <td>{{ $c->bookings_count ?? $c->bookings?->count() ?? 0 }}</td>
          <td><a href="{{ route('owner.pasien.show',$c->id) }}" class="btn btn-xs btn-outline-primary"><i class="bx bx-show"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pasien.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $children->links() }}
  </div>
</div>
@endsection
@push('styles')<style>.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
