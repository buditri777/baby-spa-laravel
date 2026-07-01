@extends("layouts.app")
@section("title","Tumbuh Kembang")
@section("page-title","Tumbuh Kembang — {{ $child->name }}")
@section("content")
<div class="row g-3">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Data Pertumbuhan</div>
      <div class="table-responsive">
        <table class="table table-sm mb-0">
          <thead class="table-light"><tr><th>Tanggal</th><th>BB (kg)</th><th>TB (cm)</th><th>LK (cm)</th></tr></thead>
          <tbody>
          @forelse($growth as $g)
          <tr>
            <td>{{ \Carbon\Carbon::parse($g->measured_at)->format('d M Y') }}</td>
            <td>{{ $g->weight_kg ?? '-' }}</td>
            <td>{{ $g->height_cm ?? '-' }}</td>
            <td>{{ $g->head_circ_cm ?? '-' }}</td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data pertumbuhan.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Milestone</div>
      <div class="card-body p-0">
        @forelse($milestones as $m)
        <div class="px-3 py-2 border-bottom">
          <div class="fw-semibold small">{{ $m->title }}</div>
          <div class="small text-muted">{{ $m->category }} · {{ \Carbon\Carbon::parse($m->achieved_at)->format('d M Y') }}</div>
          @if($m->notes)<div class="small">{{ $m->notes }}</div>@endif
        </div>
        @empty
        <p class="text-muted text-center py-3 small">Belum ada milestone.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>
<a href="{{ route('anak.show',$child->id) }}" class="btn btn-outline-secondary mt-3 btn-sm"><i class="bx bx-arrow-back"></i> Kembali</a>
@endsection
