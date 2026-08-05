@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('content')

<div class="row g-3 mb-4">
  <div class="col-sm-4">
    <div class="card text-center h-100">
      <div class="card-body py-4">
        <div class="display-6 fw-bold text-pink">{{ $children }}</div>
        <div class="text-muted small mt-1">Data Anak</div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card text-center h-100">
      <div class="card-body py-4">
        <div class="display-6 fw-bold text-pink">{{ $upcoming }}</div>
        <div class="text-muted small mt-1">Booking Mendatang</div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card text-center h-100">
      <div class="card-body py-4">
        <div class="display-6 fw-bold text-pink">{{ $bookings->count() }}</div>
        <div class="text-muted small mt-1">Total Booking</div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Booking Terakhir</span>
    <a href="{{ route('parent.booking.create') }}" class="btn btn-sm btn-pink">+ Buat Booking</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
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
              <span class="badge bg-{{ match($b->status) {
                'CONFIRMED'=>'success','REQUESTED'=>'warning','CANCELLED'=>'danger',default=>'secondary'
              } }}">{{ $b->status }}</span>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted py-3">Belum ada booking.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
