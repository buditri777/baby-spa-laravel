@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('content')

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-4">
    <div class="stat-card brand">
      <div class="stat-label">Data Anak</div>
      <div class="stat-value">{{ $children }}</div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="stat-card green">
      <div class="stat-label">Booking Mendatang</div>
      <div class="stat-value">{{ $upcoming }}</div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="stat-card purple">
      <div class="stat-label">Total Booking</div>
      <div class="stat-value">{{ $bookings->count() }}</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>Booking Terakhir</span>
    <a href="{{ route('parent.booking.create') }}" class="btn btn-sm btn-pink">
      <span class="iconify me-1" data-icon="tabler:plus"></span> Buat Booking
    </a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Anak</th>
            <th>Layanan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings as $b)
          <tr>
            <td>{{ $b->scheduled_at?->format('d M Y H:i') ?? '-' }}</td>
            <td>{{ $b->child?->name ?? '-' }}</td>
            <td>{{ $b->service?->name ?? '-' }}</td>
            <td>
              @php $s = $b->status; @endphp
              <span class="badge badge-{{ strtolower($s) }}">{{ $s }}</span>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted py-4">Belum ada booking.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer">
    <a href="{{ route('parent.booking.index') }}" class="btn btn-sm btn-outline-primary">
      Lihat Semua Booking
    </a>
  </div>
</div>

@endsection
