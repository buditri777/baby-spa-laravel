@extends("layouts.app")
@section("title","Tumbuh Kembang")
@section("page-title","Tumbuh Kembang — {{ $child->name }}")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Tumbuh Kembang</h4>
    <p class="page-sub">{{ $child->name }} — grafik pertumbuhan & milestone.</p>
  </div>
  <a href="{{ route('anak.show',$child->id) }}" class="btn btn-sm btn-outline-secondary">
    <span class="iconify me-1" data-icon="tabler:arrow-left"></span> Kembali
  </a>
</div>

<div class="row g-4">
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:chart-line"></span>Data Pertumbuhan
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Tanggal</th><th>BB (kg)</th><th>TB (cm)</th><th>LK (cm)</th></tr></thead>
          <tbody>
          @forelse($growth as $g)
          <tr>
            <td class="text-muted small">{{ \Carbon\Carbon::parse($g->measured_at)->format('d M Y') }}</td>
            <td>{{ $g->weight_kg ?? '—' }}</td>
            <td>{{ $g->height_cm ?? '—' }}</td>
            <td>{{ $g->head_circ_cm ?? '—' }}</td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted py-4">
            <span class="iconify fs-3 d-block mb-2" data-icon="tabler:chart-line-off"></span>
            Belum ada data pertumbuhan.
          </td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:award"></span>Milestone
      </div>
      <div class="card-body p-0">
        @forelse($milestones as $m)
        <div class="px-4 py-3 border-bottom">
          <div class="fw-semibold small">{{ $m->title }}</div>
          <div class="small text-muted">{{ $m->category }} · {{ \Carbon\Carbon::parse($m->achieved_at)->format('d M Y') }}</div>
          @if($m->notes)<div class="small mt-1">{{ $m->notes }}</div>@endif
        </div>
        @empty
        <div class="text-center text-muted py-5">
          <span class="iconify fs-3 d-block mb-2" data-icon="tabler:award-off"></span>
          Belum ada milestone.
        </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
