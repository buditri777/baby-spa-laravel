@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('content')
<div class="row g-4 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card" style="background:linear-gradient(135deg,#e83e8c,#f472b6)">
      <div class="small text-white-50">Booking Hari Ini</div>
      <div class="fs-3 fw-bold">{{ $bookingsToday ?? 0 }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">
      <div class="small text-white-50">Pendapatan Bulan Ini</div>
      <div class="fs-5 fw-bold">Rp {{ number_format($revenueMonth ?? 0,0,',','.') }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card" style="background:linear-gradient(135deg,#0891b2,#67e8f9)">
      <div class="small text-white-50">Total Pasien</div>
      <div class="fs-3 fw-bold">{{ $totalPatients ?? 0 }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card" style="background:linear-gradient(135deg,#059669,#6ee7b7)">
      <div class="small text-white-50">Terapis Aktif</div>
      <div class="fs-3 fw-bold">{{ $totalTherapists ?? 0 }}</div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Booking Terbaru</div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light"><tr>
              <th>Anak</th><th>Layanan</th><th>Terapis</th><th>Waktu</th><th>Status</th>
            </tr></thead>
            <tbody>
              @forelse($recentBookings ?? [] as $b)
              <tr>
                <td>{{ $b->child?->name }}</td>
                <td>{{ $b->service?->name }}</td>
                <td>{{ $b->therapist?->name }}</td>
                <td>{{ \Carbon\Carbon::parse($b->scheduled_at)->format('d M H:i') }}</td>
                <td><span class="badge bg-{{ match($b->status){ 'COMPLETED'=>'success','CANCELLED'=>'danger','NO_SHOW'=>'warning',default=>'primary'} }}">{{ $b->status }}</span></td>
              </tr>
              @empty
              <tr><td colspan="5" class="text-center text-muted py-4">Belum ada booking</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Aksi Cepat</div>
      <div class="card-body d-grid gap-2">
        @if(auth()->user()->role === 'PARENT')
          <a href="{{ route('booking.create') }}" class="btn btn-primary btn-sm">+ Buat Booking</a>
          <a href="{{ route('anak.index') }}" class="btn btn-outline-secondary btn-sm">Data Anak</a>
          <a href="{{ route('konsultasi.create') }}" class="btn btn-outline-secondary btn-sm">Tanya Terapis</a>
        @else
          <a href="{{ route('owner.booking.create') }}" class="btn btn-primary btn-sm">+ Booking Baru</a>
          <a href="{{ route('owner.walk-in.index') }}" class="btn btn-outline-secondary btn-sm">Walk-in</a>
          <a href="{{ route('owner.pasien.index') }}" class="btn btn-outline-secondary btn-sm">Lihat Pasien</a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
