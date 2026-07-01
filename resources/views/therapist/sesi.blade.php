@extends("layouts.app")
@section("title","Sesi")
@section("page-title","Detail Sesi")
@section("content")
<div class="card shadow-sm" style="max-width:620px">
  <div class="card-header bg-white fw-semibold">Sesi: {{ $booking->child?->name }} — {{ $booking->service?->name }}</div>
  <div class="card-body">
    <p class="small text-muted">{{ $booking->scheduled_date?->format("d M Y") }} {{ $booking->scheduled_time }} | Status: <span class="badge bg-primary">{{ $booking->status }}</span></p>
    @if($booking->session)
      <p class="small">Mulai: <strong>{{ \Carbon\Carbon::parse($booking->session->started_at)->timezone("Asia/Jakarta")->format("H:i") }}</strong></p>
      @if($booking->session->ended_at)
        <p class="small">Selesai: <strong>{{ \Carbon\Carbon::parse($booking->session->ended_at)->timezone("Asia/Jakarta")->format("H:i") }}</strong></p>
        <div class="alert alert-success py-2 small">Sesi selesai.</div>
      @else
        <form method="POST" action="{{ route("therapist.sesi",$booking->id) }}">@csrf
          <input type="hidden" name="action" value="end">
          <div class="row g-3 mb-3">
            <div class="col-md-4"><label class="form-label small">BB (kg)</label><input type="number" name="weight_kg" class="form-control form-control-sm" step="0.1" min="0"></div>
            <div class="col-md-4"><label class="form-label small">TB (cm)</label><input type="number" name="height_cm" class="form-control form-control-sm" step="0.1" min="0"></div>
            <div class="col-md-4"><label class="form-label small">LK (cm)</label><input type="number" name="head_circ_cm" class="form-control form-control-sm" step="0.1" min="0"></div>
            <div class="col-12"><label class="form-label small">Catatan Sesi</label><textarea name="notes" class="form-control form-control-sm" rows="3"></textarea></div>
          </div>
          <button class="btn btn-success btn-sm"><i class="bx bx-check"></i> Selesaikan Sesi</button>
        </form>
      @endif
    @else
      <form method="POST" action="{{ route("therapist.sesi",$booking->id) }}">@csrf
        <input type="hidden" name="action" value="start">
        <button class="btn btn-pink btn-sm"><i class="bx bx-play"></i> Mulai Sesi</button>
      </form>
    @endif
    <a href="{{ route("therapist.jadwal") }}" class="btn btn-outline-secondary btn-sm mt-3"><i class="bx bx-arrow-back"></i> Kembali</a>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
