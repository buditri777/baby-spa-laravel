@extends("layouts.app")
@section("title","Presensi")
@section("page-title","Presensi")
@section("content")
<div class="row g-3">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Presensi Klinik</div>
      <div class="card-body">
        <p class="mb-1 small text-muted">{{ now("Asia/Jakarta")->isoFormat("dddd, D MMMM Y") }}</p>
        @if($attendance->clock_in)
          <p class="mb-1">Datang: <strong>{{ \Carbon\Carbon::parse($attendance->clock_in)->timezone("Asia/Jakarta")->format("H:i") }}</strong></p>
          @if($attendance->clock_out)
            <p class="mb-1">Pulang: <strong>{{ \Carbon\Carbon::parse($attendance->clock_out)->timezone("Asia/Jakarta")->format("H:i") }}</strong></p>
            <span class="badge bg-success">Selesai</span>
          @else
            <form method="POST" action="{{ route("therapist.presensi") }}">@csrf
              <button class="btn btn-warning btn-sm mt-2"><i class="bx bx-log-out"></i> Tandai Pulang</button>
            </form>
          @endif
        @else
          <form method="POST" action="{{ route("therapist.presensi") }}">@csrf
            <button class="btn btn-pink btn-sm mt-2"><i class="bx bx-log-in"></i> Tandai Datang</button>
          </form>
        @endif
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Homecare Hari Ini</div>
      <div class="card-body">
        @forelse($homecareToday as $b)
        <div class="card mb-2 border-info">
          <div class="card-body py-2 px-3">
            <div class="fw-semibold">{{ $b->child?->name }} — {{ $b->service?->name }}</div>
            <div class="small text-muted mb-2">{{ $b->scheduled_time }}</div>
            @if(!$b->homecare_arrived_at)
              <form method="POST" action="/therapist/presensi/homecare/{{ $b->id }}">@csrf
                <button class="btn btn-sm btn-outline-info">Tiba</button>
              </form>
            @elseif(!$b->homecare_finished_at)
              <p class="small mb-1">Tiba: <strong>{{ \Carbon\Carbon::parse($b->homecare_arrived_at)->timezone("Asia/Jakarta")->format("H:i") }}</strong></p>
              <form method="POST" action="/therapist/presensi/homecare/{{ $b->id }}">@csrf
                <button class="btn btn-sm btn-success">Selesai</button>
              </form>
            @else
              <p class="small mb-0">Tiba: {{ \Carbon\Carbon::parse($b->homecare_arrived_at)->timezone("Asia/Jakarta")->format("H:i") }} | Selesai: {{ \Carbon\Carbon::parse($b->homecare_finished_at)->timezone("Asia/Jakarta")->format("H:i") }}</p>
              <span class="badge bg-success">Selesai</span>
            @endif
          </div>
        </div>
        @empty
        <p class="text-muted small">Tidak ada kunjungan homecare hari ini.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
