@extends("layouts.app")
@section("title","Audit Log")
@section("page-title","Audit Log")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Log Aktivitas</span>
    <form method="GET" class="d-flex gap-2">
      <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari aksi..." value="{{ request('search') }}">
      <button class="btn btn-sm btn-outline-secondary">Cari</button>
    </form>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead class="table-light"><tr><th>Waktu</th><th>User</th><th>Aksi</th><th>Target</th><th>Detail</th></tr></thead>
        <tbody>
        @forelse($logs as $l)
        <tr>
          <td class="text-nowrap">{{ $l->created_at?->timezone('Asia/Jakarta')?->format('d M Y H:i') }}</td>
          <td>{{ $l->user?->name ?? '-' }}</td>
          <td><code class="small">{{ $l->action }}</code></td>
          <td><span class="badge bg-secondary">{{ $l->target_type }}</span> <code class="small">{{ Str::limit($l->target_id,12) }}</code></td>
          <td class="small text-muted">{{ Str::limit($l->description ?? '', 60) }}</td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada log.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $logs->links() }}
  </div>
</div>
@endsection
