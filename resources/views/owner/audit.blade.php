@extends("layouts.app")
@section("title","Audit Log")
@section("page-title","Audit Log")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Log Aktivitas</h4>
    <p class="page-sub">Rekam jejak seluruh aksi pengguna di sistem.</p>
  </div>
  <form method="GET" class="d-flex gap-2">
    <input type="text" name="search" class="form-control form-control-sm"
           placeholder="Cari aksi…" value="{{ request('search') }}">
    <button class="btn btn-sm btn-outline-secondary">
      <span class="iconify" data-icon="tabler:search"></span>
    </button>
  </form>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Waktu</th><th>User</th><th>Aksi</th><th>Target</th><th>Detail</th>
        </tr>
      </thead>
      <tbody>
      @forelse($logs as $l)
      <tr>
        <td class="text-muted small text-nowrap">
          {{ $l->created_at?->timezone('Asia/Jakarta')?->format('d M Y H:i') }}
        </td>
        <td class="fw-semibold">{{ $l->user?->name ?? '—' }}</td>
        <td><code class="small">{{ $l->action }}</code></td>
        <td>
          <span class="badge badge-confirmed">{{ $l->target_type }}</span>
          <code class="small text-muted ms-1">{{ Str::limit($l->target_id,12) }}</code>
        </td>
        <td class="small text-muted">{{ Str::limit($l->description ?? '', 60) }}</td>
      </tr>
      @empty
      <tr><td colspan="5" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:clipboard-off"></span>
        Belum ada log aktivitas.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($logs->hasPages())
  <div class="card-body pt-0 pb-3">{{ $logs->links() }}</div>
  @endif
</div>
@endsection
