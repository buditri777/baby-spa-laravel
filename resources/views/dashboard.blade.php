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

{{-- HERO: Pendapatan Harian + Tren 7 Hari --}}
<div class="row g-3 mb-4">
  <div class="col-lg-5">
    <div class="card border-0 h-100" style="background:linear-gradient(135deg,#c2185b 0%,#e91e63 100%)">
      <div class="card-body text-white">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="small fw-semibold text-uppercase" style="opacity:.8;letter-spacing:.5px">Pendapatan Hari Ini</span>
          <span class="iconify fs-4" style="opacity:.75" data-icon="tabler:wallet"></span>
        </div>
        <div class="fw-bold" style="font-size:2rem;line-height:1.1">
          Rp{{ number_format($todayRevenue ?? 0, 0, ',', '.') }}
        </div>
        <div class="d-flex gap-3 mt-3 small" style="opacity:.9">
          <span><span class="iconify me-1" data-icon="tabler:receipt"></span>{{ $todayPaidCount ?? 0 }} transaksi</span>
          <span><span class="iconify me-1" data-icon="tabler:spa"></span>{{ $todaySessions ?? 0 }} sesi</span>
          <span><span class="iconify me-1" data-icon="tabler:calendar-check"></span>{{ $bookingsToday ?? 0 }} booking</span>
        </div>
        <a href="{{ route('owner.laporan.pendapatan') }}" class="btn btn-light btn-sm mt-3">
          <span class="iconify me-1" data-icon="tabler:chart-line"></span> Lihat Laporan
        </a>
      </div>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center gap-2">
        <span class="iconify text-primary" data-icon="tabler:chart-bar"></span>
        Tren Pendapatan 7 Hari
      </div>
      <div class="card-body">
        <div class="d-flex align-items-end justify-content-between gap-2" style="height:110px">
          @foreach($trend ?? [] as $i => $t)
          @php $h = $trendMax > 0 ? max(3, round(($t['total'] / $trendMax) * 100)) : 3; $isToday = $i === count($trend)-1; @endphp
          <div class="d-flex flex-column align-items-center flex-grow-1" style="height:100%">
            <div class="flex-grow-1 d-flex align-items-end w-100 justify-content-center">
              <div title="Rp{{ number_format($t['total'],0,',','.') }}"
                   style="width:70%;height:{{ $h }}%;background:{{ $isToday ? '#c2185b' : '#fce4ec' }};border-radius:6px 6px 0 0;transition:height .3s"></div>
            </div>
            <div class="text-muted mt-1" style="font-size:11px">{{ $t['label'] }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Stat cards --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card brand">
      <div class="stat-label">Booking Hari Ini</div>
      <div class="stat-value">{{ $bookingsToday ?? 0 }}</div>
      <div class="small mt-1" style="opacity:.8">Aktif / selesai</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card teal">
      <div class="stat-label">Terapis Aktif</div>
      <div class="stat-value">{{ $totalTherapists ?? 0 }}</div>
      <div class="small mt-1" style="opacity:.8">Standby praktik</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card purple">
      <div class="stat-label">Pasien Terdaftar</div>
      <div class="stat-value">{{ $totalPatients ?? 0 }}</div>
      <div class="small mt-1" style="opacity:.8">Anak aktif</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card green position-relative">
      <div class="stat-label">Pasien Baru</div>
      <div class="stat-value">{{ $newPatients ?? 0 }}</div>
      <div class="small mt-1" style="opacity:.8">7 hari terakhir</div>
      @if(($newPatients ?? 0) > 0)
      <span class="badge bg-danger position-absolute" style="top:10px;right:10px">BARU</span>
      @endif
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card brand" style="background:linear-gradient(135deg,#1976d2,#1565c0)">
      <div class="stat-label">Revenue Bulan Ini</div>
      <div class="stat-value" style="font-size:1.1rem">Rp{{ number_format($revenueMonth ?? 0,0,',','.') }}</div>
      <div class="small mt-1" style="opacity:.8">Cash + Transfer + QRIS</div>
    </div>
  </div>
</div>

{{-- Pasien Baru 7 hari --}}
@if(($recentNewPatients ?? collect())->count() > 0)
<div class="card mb-4">
  <div class="card-header d-flex align-items-center justify-content-between">
    <span class="d-flex align-items-center gap-2">
      <span class="iconify text-primary" data-icon="tabler:user-plus"></span>
      Pasien Baru (7 Hari Terakhir)
    </span>
    <a href="{{ route('owner.pasien.index') }}" class="small text-primary text-decoration-none">Lihat Semua →</a>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th style="width:40px">#</th><th>Anak</th><th>Orang Tua</th><th>Sumber</th><th>Daftar</th></tr></thead>
      <tbody>
      @foreach($recentNewPatients as $i => $c)
      @php $isToday = $c->created_at->isToday(); @endphp
      <tr>
        <td class="text-muted small">{{ $i+1 }}</td>
        <td>
          <span class="fw-semibold">{{ $c->name }}</span>
          @if($isToday)<span class="badge bg-danger ms-1">BARU</span>@endif
        </td>
        <td class="small">
          {{ $c->parent?->name }}
          <div class="text-muted" style="font-size:11px">{{ $c->parent?->phone }}</div>
        </td>
        <td>
          <span class="badge badge-confirmed">
            {{ $c->parent?->referral_source === 'WALK_IN' ? 'Walk-in' : ($c->parent?->referral_source ?? 'App') }}
          </span>
        </td>
        <td class="small text-muted">{{ $c->created_at->locale('id')->isoFormat('D MMM Y') }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

{{-- Booking Terbaru --}}
<div class="card mb-4">
  <div class="card-header d-flex align-items-center gap-2">
    <span class="iconify text-primary" data-icon="tabler:list-check"></span>
    Booking Terbaru
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Anak</th><th>Layanan</th><th>Terapis</th><th>Tanggal</th><th>Status</th></tr></thead>
      <tbody>
      @forelse($recentBookings ?? [] as $b)
      @php
        $st  = $b->status;
        $map = ['COMPLETED'=>['Selesai','badge-completed'],'CANCELLED'=>['Dibatalkan','badge-cancelled'],'CONFIRMED'=>['Terjadwal','badge-confirmed'],'REQUESTED'=>['Permintaan','badge-pending'],'NO_SHOW'=>['Tidak Hadir','badge-noshow']];
        [$stLabel,$stClass] = $map[$st] ?? [$st,'badge-pending'];
      @endphp
      <tr>
        <td class="fw-semibold">{{ $b->child?->name }}</td>
        <td>{{ $b->service?->name }}</td>
        <td>{{ $b->therapist?->name ?? '—' }}</td>
        <td class="text-muted small">{{ $b->scheduled_date?->format('d M Y') }} {{ $b->scheduled_time }}</td>
        <td><span class="badge {{ $stClass }}">{{ $stLabel }}</span></td>
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

{{-- Aksi Cepat --}}
<div class="card">
  <div class="card-header">Aksi Cepat</div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-6 col-md-3">
        <a href="{{ route('owner.booking.index') }}" class="btn btn-outline-primary w-100">
          <span class="iconify me-1" data-icon="tabler:list"></span> Semua Booking
        </a>
      </div>
      <div class="col-6 col-md-3">
        <a href="{{ route('owner.calendar') }}" class="btn btn-outline-primary w-100">
          <span class="iconify me-1" data-icon="tabler:calendar"></span> Kalender
        </a>
      </div>
      <div class="col-6 col-md-3">
        <a href="{{ route('owner.layanan.index') }}" class="btn btn-outline-primary w-100">
          <span class="iconify me-1" data-icon="tabler:spa"></span> Kelola Layanan
        </a>
      </div>
      <div class="col-6 col-md-3">
        <a href="{{ route('owner.terapis.index') }}" class="btn btn-outline-primary w-100">
          <span class="iconify me-1" data-icon="tabler:user-check"></span> Kelola Terapis
        </a>
      </div>
    </div>
  </div>
</div>
@endif
@endsection
