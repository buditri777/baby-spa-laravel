@extends("layouts.app")
@section("title","Jadwal Hari Ini")
@section("page-title","Jadwal Hari Ini")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Jadwal — {{ \Carbon\Carbon::parse($date)->locale("id")->isoFormat("dddd, D MMMM Y") }}</h4>
    <p class="page-sub">Daftar sesi yang harus dikerjakan hari ini.</p>
  </div>
  <form method="GET" class="d-flex gap-2">
    <input type="date" name="date" class="form-control form-control-sm" value="{{ $date }}">
    <button class="btn btn-sm btn-outline-secondary">
      <span class="iconify me-1" data-icon="tabler:filter"></span>Lihat
    </button>
  </form>
</div>

@forelse($bookings as $b)
@php
  $borderColor = match($b->status) {
    'COMPLETED' => 'var(--status-completed)',
    'IN_PROGRESS' => 'var(--status-pending)',
    default => 'var(--brand)'
  };
  $map = ['COMPLETED'=>['Selesai','badge-completed'],'IN_PROGRESS'=>['Berlangsung','badge-pending'],'CONFIRMED'=>['Terjadwal','badge-confirmed'],'CANCELLED'=>['Dibatalkan','badge-cancelled'],'NO_SHOW'=>['Tidak Hadir','badge-noshow']];
  [$stLabel,$stClass] = $map[$b->status] ?? [$b->status,'badge-pending'];
@endphp
<div class="card mb-2" style="border-left:3px solid {{ $borderColor }}">
  <div class="card-body py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
      <div class="fw-semibold">{{ $b->scheduled_time }} — {{ $b->child?->name }}</div>
      <div class="small text-muted">
        {{ $b->service?->name }}
        @if($b->is_homecare)
          <span class="badge badge-pending ms-1">Homecare</span>
        @endif
      </div>
    </div>
    <div class="d-flex gap-2 align-items-center">
      <span class="badge {{ $stClass }}">{{ $stLabel }}</span>
      @if(in_array($b->status,["CONFIRMED","IN_PROGRESS"]))
      <a href="{{ route("therapist.sesi",$b->id) }}" class="btn btn-sm btn-pink">
        <span class="iconify me-1" data-icon="tabler:player-play"></span>Mulai Sesi
      </a>
      @endif
    </div>
  </div>
</div>
@empty
<div class="card">
  <div class="card-body text-center text-muted py-5">
    <span class="iconify fs-2 d-block mb-2" data-icon="tabler:sun"></span>
    Tidak ada jadwal untuk hari ini.
  </div>
</div>
@endforelse
@endsection
