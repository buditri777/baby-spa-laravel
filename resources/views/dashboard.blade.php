@extends("layouts.app")
@section("title","Dashboard")
@section("page-title","Dashboard")
@section("content")
@php $user = auth()->user(); @endphp

@if($user->role === "PARENT")
{{-- ── PARENT DASHBOARD ── --}}
<div class="page-header">
  <h4>Halo, {{ explode(' ', $user->name)[0] }} 👋</h4>
  <p class="page-sub">Pantau tumbuh kembang si kecil dan jadwal sesi berikutnya.</p>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card brand">
      <div class="stat-label">Anak Terdaftar</div>
      <div class="stat-value">{{ $children ?? 0 }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card green">
      <div class="stat-label">Booking Terakhir</div>
      <div class="stat-value">{{ ($recentBookings ?? collect())->count() }}</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex align-items-center gap-2">
    <span class="iconify text-primary" data-icon="tabler:calendar-check"></span>
    Booking Terbaru
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Anak</th><th>Layanan</th><th>Tanggal</th><th>Status</th></tr></thead>
      <tbody>
      @forelse($recentBookings ?? [] as $b)
      <tr>
        <td class="fw-semibold">{{ $b->child?->name }}</td>
        <td>{{ $b->service?->name }}</td>
        <td class="text-muted">{{ $b->scheduled_date?->format("d M Y") }} {{ $b->scheduled_time }}</td>
        <td>
          @php
            $st = $b->status;
            $map = ['COMPLETED'=>['Selesai','badge-completed'],'CANCELLED'=>['Dibatalkan','badge-cancelled'],'CONFIRMED'=>['Terjadwal','badge-confirmed'],'NO_SHOW'=>['Tidak Hadir','badge-noshow']];
            [$stLabel,$stClass] = $map[$st] ?? [$st,'badge-pending'];
          @endphp
          <span class="badge {{ $stClass }}">{{ $stLabel }}</span>
        </td>
      </tr>
      @empty
      <tr><td colspan="4" class="text-center text-muted py-4">
        <span class="iconify fs-4 d-block mb-1" data-icon="tabler:calendar-off"></span>
        Belum ada booking.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>

@elseif($user->role === "THERAPIST")
{{-- ── THERAPIST DASHBOARD ── --}}
<div class="page-header">
  <h4>Halo, {{ explode(' ', $user->name)[0] }} 👋</h4>
  <p class="page-sub">Jadwal sesi hari ini.</p>
</div>

<div class="card">
  <div class="card-header d-flex align-items-center gap-2">
    <span class="iconify text-primary" data-icon="tabler:calendar-event"></span>
    Jadwal Hari Ini
  </div>
  <div class="card-body">
    @forelse($todayBookings ?? [] as $b)
    <div class="d-flex align-items-center justify-content-between p-3 rounded mb-2" style="background:var(--brand-muted);border:1px solid var(--brand-light)">
      <div>
        <div class="fw-semibold">{{ $b->scheduled_time }} — {{ $b->child?->name }}</div>
        <div class="small text-muted">{{ $b->service?->name }}</div>
      </div>
      <a href="{{ route("therapist.sesi",$b->id) }}" class="btn btn-sm btn-pink">
        <span class="iconify me-1" data-icon="tabler:player-play"></span>Sesi
      </a>
    </div>
    @empty
    <div class="text-center text-muted py-4">
      <span class="iconify fs-3 d-block mb-2" data-icon="tabler:sun"></span>
      Tidak ada jadwal hari ini.
    </div>
    @endforelse
  </div>
</div>

@else
{{-- ── OWNER / ADMIN / STAFF DASHBOARD ── --}}
<div class="page-header">
  <h4>Halo, {{ explode(' ', $user->name)[0] }} 👋</h4>
  <p class="page-sub">Ringkasan operasional Sofia Baby Spa hari ini.</p>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card brand">
      <div class="stat-label">Booking Hari Ini</div>
      <div class="stat-value">{{ $bookingsToday ?? 0 }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card green">
      <div class="stat-label">Pendapatan Bulan Ini</div>
      <div class="stat-value" style="font-size:1.15rem">Rp{{ number_format($revenueMonth ?? 0,0,",",".") }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card purple">
      <div class="stat-label">Total Pasien</div>
      <div class="stat-value">{{ $totalPatients ?? 0 }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card teal">
      <div class="stat-label">Terapis Aktif</div>
      <div class="stat-value">{{ $totalTherapists ?? 0 }}</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex align-items-center gap-2">
    <span class="iconify text-primary" data-icon="tabler:list-check"></span>
    Booking Terbaru
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Anak</th><th>Layanan</th><th>Terapis</th><th>Tanggal</th><th>Status</th></tr></thead>
      <tbody>
      @forelse($recentBookings ?? [] as $b)
      <tr>
        <td class="fw-semibold">{{ $b->child?->name }}</td>
        <td>{{ $b->service?->name }}</td>
        <td>{{ $b->therapist?->name ?? "—" }}</td>
        <td class="text-muted small">{{ $b->scheduled_date?->format("d M Y") }} {{ $b->scheduled_time }}</td>
        <td>
          @php
            $st = $b->status;
            $map = ['COMPLETED'=>['Selesai','badge-completed'],'CANCELLED'=>['Dibatalkan','badge-cancelled'],'CONFIRMED'=>['Terjadwal','badge-confirmed'],'NO_SHOW'=>['Tidak Hadir','badge-noshow']];
            [$stLabel,$stClass] = $map[$st] ?? [$st,'badge-pending'];
          @endphp
          <span class="badge {{ $stClass }}">{{ $stLabel }}</span>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="text-center text-muted py-4">
        <span class="iconify fs-4 d-block mb-1" data-icon="tabler:calendar-off"></span>
        Belum ada booking.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endif
@endsection
