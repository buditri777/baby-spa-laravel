@extends('layouts.app')
@section('title','Data Pasien')
@section('page-title','Data Pasien')
@section('content')

<div class="page-header">
  <h4>Data Pasien</h4>
  <p class="page-sub">Daftar seluruh anak dan orang tua terdaftar.</p>
</div>

<div class="card">
  <div class="card-header">
    <form class="row g-2 align-items-center" method="GET">
      <div class="col-sm-5">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Cari nama anak / orang tua…" value="{{ request('search') }}">
      </div>
      <div class="col-sm-4">
        <input type="text" name="province" class="form-control form-control-sm"
               placeholder="Filter provinsi…" value="{{ request('province') }}">
      </div>
      <div class="col-sm-3">
        <button class="btn btn-sm btn-outline-secondary w-100">
          <span class="iconify me-1" data-icon="tabler:filter"></span>Filter
        </button>
      </div>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Nama Anak</th>
          <th>Orang Tua</th>
          <th>Gender</th>
          <th>Tgl Lahir</th>
          <th>Wilayah</th>
          <th>Booking</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($children as $c)
      <tr>
        <td class="fw-semibold">{{ $c->name }}</td>
        <td class="text-muted">{{ $c->parent?->name }}</td>
        <td>
          <span class="badge {{ $c->gender === 'L' ? 'badge-confirmed' : 'badge-pending' }}">
            {{ $c->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
          </span>
        </td>
        <td class="text-muted small">{{ $c->birth_date?->format('d M Y') }}</td>
        <td class="text-muted small">{{ $c->parent?->city ?? $c->parent?->province ?? '—' }}</td>
        <td>
          <span class="badge badge-confirmed">{{ $c->bookings_count ?? $c->bookings?->count() ?? 0 }} sesi</span>
        </td>
        <td class="text-end">
          <a href="{{ route('owner.pasien.show',$c->id) }}" class="btn btn-xs btn-outline-primary">
            <span class="iconify" data-icon="tabler:eye"></span>
          </a>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:users-group"></span>
        Belum ada data pasien.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($children->hasPages())
  <div class="card-body pt-0 pb-3">{{ $children->links() }}</div>
  @endif
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
