@extends("layouts.app")
@section("title","Presensi")
@section("page-title","Presensi")
@section("content")

<div class="page-header">
  <h4>Presensi</h4>
  <p class="page-sub">{{ now("Asia/Jakarta")->locale("id")->isoFormat("dddd, D MMMM Y") }}</p>
</div>

<div class="row g-4">
  {{-- Presensi Klinik --}}
  <div class="col-md-5">
    <div class="card h-100">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:building"></span>Presensi Klinik
      </div>
      <div class="card-body">
        @if($attendance->clock_in)
          <div class="mb-3 p-3 rounded" style="background:var(--surface-2)">
            <div class="small text-muted">Datang</div>
            <div class="fw-bold fs-5">{{ \Carbon\Carbon::parse($attendance->clock_in)->timezone("Asia/Jakarta")->format("H:i") }}</div>
          </div>
          @if($attendance->clock_out)
            <div class="mb-3 p-3 rounded" style="background:var(--surface-2)">
              <div class="small text-muted">Pulang</div>
              <div class="fw-bold fs-5">{{ \Carbon\Carbon::parse($attendance->clock_out)->timezone("Asia/Jakarta")->format("H:i") }}</div>
            </div>
            <span class="badge badge-completed">
              <span class="iconify me-1" data-icon="tabler:circle-check"></span>Selesai
            </span>
          @else
            <form method="POST" action="{{ route("therapist.presensi") }}">
              @csrf
              <button class="btn btn-warning">
                <span class="iconify me-1" data-icon="tabler:logout"></span> Tandai Pulang
              </button>
            </form>
          @endif
        @else
          <p class="text-muted small mb-3">Belum melakukan presensi hari ini.</p>
          <form method="POST" action="{{ route("therapist.presensi") }}">
            @csrf
            <button class="btn btn-pink">
              <span class="iconify me-1" data-icon="tabler:login"></span> Tandai Datang
            </button>
          </form>
        @endif
      </div>
    </div>
  </div>

  {{-- Homecare --}}
  <div class="col-md-7">
    <div class="card h-100">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:home"></span>Homecare Hari Ini
      </div>
      <div class="card-body">
        @forelse($homecareToday as $b)
        <div class="p-3 rounded mb-2" style="background:var(--surface-2);border-left:3px solid var(--brand)">
          <div class="fw-semibold">{{ $b->child?->name }} — {{ $b->service?->name }}</div>
          <div class="small text-muted mb-2">{{ $b->scheduled_time }}</div>
          @if(!$b->homecare_arrived_at)
            <form method="POST" action="/therapist/presensi/homecare/{{ $b->id }}">
              @csrf
              <button class="btn btn-sm btn-outline-primary">
                <span class="iconify me-1" data-icon="tabler:map-pin"></span>Tiba
              </button>
            </form>
          @elseif(!$b->homecare_finished_at)
            <div class="small mb-2">
              Tiba: <strong>{{ \Carbon\Carbon::parse($b->homecare_arrived_at)->timezone("Asia/Jakarta")->format("H:i") }}</strong>
            </div>
            <form method="POST" action="/therapist/presensi/homecare/{{ $b->id }}">
              @csrf
              <button class="btn btn-sm btn-success">
                <span class="iconify me-1" data-icon="tabler:circle-check"></span>Selesai
              </button>
            </form>
          @else
            <div class="small text-muted">
              Tiba: {{ \Carbon\Carbon::parse($b->homecare_arrived_at)->timezone("Asia/Jakarta")->format("H:i") }}
              → Selesai: {{ \Carbon\Carbon::parse($b->homecare_finished_at)->timezone("Asia/Jakarta")->format("H:i") }}
            </div>
            <span class="badge badge-completed mt-1">Selesai</span>
          @endif
        </div>
        @empty
        <div class="text-center text-muted py-4">
          <span class="iconify fs-3 d-block mb-2" data-icon="tabler:home-off"></span>
          Tidak ada kunjungan homecare hari ini.
        </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
