@extends("layouts.app")
@section("title","Sesi")
@section("page-title","Detail Sesi")
@section("content")

<div class="page-header">
  <h4>Sesi: {{ $booking->child?->name }} — {{ $booking->service?->name }}</h4>
  <p class="page-sub">
    {{ $booking->scheduled_date?->format("d M Y") }} {{ $booking->scheduled_time }}
    &nbsp;·&nbsp;
    @php
      $map = ['COMPLETED'=>['Selesai','badge-completed'],'IN_PROGRESS'=>['Berlangsung','badge-pending'],'CONFIRMED'=>['Terjadwal','badge-confirmed']];
      [$stLabel,$stClass] = $map[$booking->status] ?? [$booking->status,'badge-pending'];
    @endphp
    <span class="badge {{ $stClass }}">{{ $stLabel }}</span>
  </p>
</div>

<div class="card" style="max-width:620px">
  <div class="card-body">

    @if($booking->session)
      <div class="mb-3 p-3 rounded" style="background:var(--surface-2)">
        <div class="small text-muted mb-1">Waktu Sesi</div>
        <div>
          Mulai: <strong>{{ \Carbon\Carbon::parse($booking->session->started_at)->timezone("Asia/Jakarta")->format("H:i") }}</strong>
          @if($booking->session->ended_at)
            &nbsp;→&nbsp;
            Selesai: <strong>{{ \Carbon\Carbon::parse($booking->session->ended_at)->timezone("Asia/Jakarta")->format("H:i") }}</strong>
          @endif
        </div>
      </div>

      @if($booking->session->ended_at)
        <div class="alert alert-success">
          <span class="iconify me-2" data-icon="tabler:circle-check"></span> Sesi telah selesai.
        </div>

      @else
        <form method="POST" action="{{ route("therapist.sesi",$booking->id) }}">
          @csrf
          <input type="hidden" name="action" value="end">
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <label class="form-label">BB (kg)</label>
              <input type="number" name="weight_kg" class="form-control form-control-sm" step="0.1" min="0">
            </div>
            <div class="col-md-4">
              <label class="form-label">TB (cm)</label>
              <input type="number" name="height_cm" class="form-control form-control-sm" step="0.1" min="0">
            </div>
            <div class="col-md-4">
              <label class="form-label">LK (cm)</label>
              <input type="number" name="head_circ_cm" class="form-control form-control-sm" step="0.1" min="0">
            </div>
            <div class="col-12">
              <label class="form-label">Catatan Sesi</label>
              <textarea name="notes" class="form-control" rows="3"></textarea>
            </div>
          </div>
          <button class="btn btn-success">
            <span class="iconify me-1" data-icon="tabler:circle-check"></span> Selesaikan Sesi
          </button>
        </form>
      @endif

    @else
      <p class="text-muted mb-4">Sesi belum dimulai.</p>
      <form method="POST" action="{{ route("therapist.sesi",$booking->id) }}">
        @csrf
        <input type="hidden" name="action" value="start">
        <button class="btn btn-pink">
          <span class="iconify me-1" data-icon="tabler:player-play"></span> Mulai Sesi
        </button>
      </form>
    @endif

    <a href="{{ route("therapist.jadwal") }}" class="btn btn-outline-secondary btn-sm mt-4">
      <span class="iconify me-1" data-icon="tabler:arrow-left"></span> Kembali
    </a>
  </div>
</div>
@endsection
