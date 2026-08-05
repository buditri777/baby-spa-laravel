@extends("layouts.app")
@section("title","Reservasi IG")
@section("page-title","Reservasi via Instagram")
@section("content")

<div class="page-header">
  <h4>Reservasi Instagram</h4>
  <p class="page-sub">Daftar reservasi yang masuk melalui DM Instagram.</p>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Nama</th><th>HP</th><th>Layanan</th><th>Tanggal</th><th>Status</th><th>Pesan</th></tr>
      </thead>
      <tbody>
      @forelse($reservations ?? [] as $r)
      <tr>
        <td class="fw-semibold">{{ $r->name }}</td>
        <td class="text-muted">{{ $r->phone ?? "—" }}</td>
        <td class="text-muted">{{ $r->service_name ?? "—" }}</td>
        <td class="text-muted small">{{ $r->created_at?->format("d M Y H:i") }}</td>
        <td>
          <span class="badge {{ $r->status==='CONFIRMED' ? 'badge-completed' : 'badge-pending' }}">
            {{ $r->status==='CONFIRMED' ? 'Terkonfirmasi' : 'Menunggu' }}
          </span>
        </td>
        <td class="text-muted small">{{ Str::limit($r->message ?? "", 50) }}</td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:brand-instagram"></span>
        Belum ada reservasi via Instagram.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
