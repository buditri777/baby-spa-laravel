@extends("layouts.app")
@section("title","Dashboard")
@section("page-title","Dashboard")
@section("content")
@php $user = auth()->user(); @endphp

@if($user->role === "PARENT")
<div class="row g-3 mb-3">
  <div class="col-6 col-md-3"><div class="stat-card bg-primary"><div class="small">Anak Terdaftar</div><div class="fs-5 fw-bold">{{ $children ?? 0 }}</div></div></div>
  <div class="col-6 col-md-3"><div class="stat-card bg-success"><div class="small">Booking Terakhir</div><div class="fs-5 fw-bold">{{ ($recentBookings ?? collect())->count() }}</div></div></div>
</div>
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Booking Terbaru</div>
  <div class="table-responsive">
    <table class="table table-sm align-middle mb-0">
      <thead class="table-light"><tr><th>Anak</th><th>Layanan</th><th>Tanggal</th><th>Status</th></tr></thead>
      <tbody>
      @forelse($recentBookings ?? [] as $b)
      <tr>
        <td>{{ $b->child?->name }}</td>
        <td>{{ $b->service?->name }}</td>
        <td>{{ $b->scheduled_date?->format("d M Y") }} {{ $b->scheduled_time }}</td>
        <td><span class="badge bg-{{ $b->status==="COMPLETED"?"success":($b->status==="CANCELLED"?"danger":"primary") }}">{{ $b->status }}</span></td>
      </tr>
      @empty
      <tr><td colspan="4" class="text-center text-muted py-3">Belum ada booking.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>

@elseif($user->role === "THERAPIST")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Jadwal Hari Ini</div>
  <div class="card-body">
    @forelse($todayBookings ?? [] as $b)
    <div class="card mb-2 border-primary">
      <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
        <div>
          <div class="fw-semibold">{{ $b->scheduled_time }} — {{ $b->child?->name }}</div>
          <div class="small text-muted">{{ $b->service?->name }}</div>
        </div>
        <a href="{{ route("therapist.sesi",$b->id) }}" class="btn btn-sm btn-pink">Sesi</a>
      </div>
    </div>
    @empty
    <p class="text-muted text-center py-3">Tidak ada jadwal hari ini.</p>
    @endforelse
  </div>
</div>

@else
<div class="row g-3 mb-3">
  <div class="col-6 col-md-3"><div class="stat-card bg-primary"><div class="small">Booking Hari Ini</div><div class="fs-5 fw-bold">{{ $bookingsToday ?? 0 }}</div></div></div>
  <div class="col-6 col-md-3"><div class="stat-card bg-success"><div class="small">Pendapatan Bulan Ini</div><div class="fs-6 fw-bold">Rp{{ number_format($revenueMonth ?? 0,0,",",".") }}</div></div></div>
  <div class="col-6 col-md-3"><div class="stat-card" style="background:#e83e8c"><div class="small">Total Pasien</div><div class="fs-5 fw-bold">{{ $totalPatients ?? 0 }}</div></div></div>
  <div class="col-6 col-md-3"><div class="stat-card" style="background:#6f42c1"><div class="small">Terapis Aktif</div><div class="fs-5 fw-bold">{{ $totalTherapists ?? 0 }}</div></div></div>
</div>
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Booking Terbaru</div>
  <div class="table-responsive">
    <table class="table table-sm align-middle mb-0">
      <thead class="table-light"><tr><th>Anak</th><th>Layanan</th><th>Terapis</th><th>Tanggal</th><th>Status</th></tr></thead>
      <tbody>
      @forelse($recentBookings ?? [] as $b)
      <tr>
        <td>{{ $b->child?->name }}</td>
        <td>{{ $b->service?->name }}</td>
        <td>{{ $b->therapist?->name ?? "-" }}</td>
        <td>{{ $b->scheduled_date?->format("d M Y") }} {{ $b->scheduled_time }}</td>
        <td><span class="badge bg-{{ $b->status==="COMPLETED"?"success":($b->status==="CANCELLED"?"danger":"primary") }}">{{ $b->status }}</span></td>
      </tr>
      @empty
      <tr><td colspan="5" class="text-center text-muted py-3">Belum ada booking.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endif
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
