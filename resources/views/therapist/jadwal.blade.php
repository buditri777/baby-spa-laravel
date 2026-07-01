@extends("layouts.app")
@section("title","Jadwal Hari Ini")
@section("page-title","Jadwal Hari Ini")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Jadwal — {{ \Carbon\Carbon::parse($date)->locale("id")->isoFormat("dddd, D MMMM Y") }}</span>
    <form method="GET" class="d-flex gap-2">
      <input type="date" name="date" class="form-control form-control-sm" value="{{ $date }}">
      <button class="btn btn-sm btn-outline-secondary">Lihat</button>
    </form>
  </div>
  <div class="card-body">
    @forelse($bookings as $b)
    <div class="card mb-2 border-{{ $b->status==="COMPLETED"?"success":($b->status==="IN_PROGRESS"?"warning":"primary") }}">
      <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
          <div class="fw-semibold">{{ $b->scheduled_time }} — {{ $b->child?->name }}</div>
          <div class="small text-muted">{{ $b->service?->name }} @if($b->is_homecare)<span class="badge bg-info ms-1">Homecare</span>@endif</div>
        </div>
        <div class="d-flex gap-2 align-items-center">
          <span class="badge bg-{{ $b->status==="COMPLETED"?"success":($b->status==="IN_PROGRESS"?"warning":"primary") }}">{{ $b->status }}</span>
          @if(in_array($b->status,["CONFIRMED","IN_PROGRESS"]))
          <a href="{{ route("therapist.sesi",$b->id) }}" class="btn btn-sm btn-pink">Mulai Sesi</a>
          @endif
        </div>
      </div>
    </div>
    @empty
    <p class="text-muted text-center py-4">Tidak ada jadwal hari ini.</p>
    @endforelse
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
