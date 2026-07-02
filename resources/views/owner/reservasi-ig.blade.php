@extends("layouts.app")
@section("title","Reservasi IG")
@section("page-title","Reservasi via Instagram")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Daftar Reservasi Instagram</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Nama</th><th>HP</th><th>Layanan</th><th>Tanggal</th><th>Status</th><th>Pesan</th></tr></thead>
        <tbody>
        @forelse($reservations ?? [] as $r)
        <tr>
          <td>{{ $r->name }}</td>
          <td>{{ $r->phone ?? "-" }}</td>
          <td>{{ $r->service_name ?? "-" }}</td>
          <td>{{ $r->created_at?->format("d M Y H:i") }}</td>
          <td><span class="badge bg-{{ $r->status==="CONFIRMED"?"success":"warning" }}">{{ $r->status }}</span></td>
          <td><small class="text-muted">{{ Str::limit($r->message ?? "",50) }}</small></td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada reservasi via Instagram.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
