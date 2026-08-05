@extends("layouts.app")
@section("title","Pasien Saya")
@section("page-title","Pasien Saya")
@section("content")

<div class="page-header">
  <h4>Pasien Saya</h4>
  <p class="page-sub">Daftar anak yang pernah ditangani.</p>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Nama Anak</th><th>Orang Tua</th><th>Gender</th><th>Tgl Lahir</th></tr>
      </thead>
      <tbody>
      @forelse($children as $c)
      <tr>
        <td class="fw-semibold">{{ $c->name }}</td>
        <td class="text-muted">{{ $c->parent?->name }}</td>
        <td>
          <span class="badge {{ $c->gender === 'L' ? 'badge-confirmed' : 'badge-pending' }}">
            {{ $c->gender === "L" ? "Laki-laki" : "Perempuan" }}
          </span>
        </td>
        <td class="text-muted small">{{ $c->birth_date?->format("d M Y") }}</td>
      </tr>
      @empty
      <tr><td colspan="4" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:users-group"></span>
        Belum ada pasien.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($children->hasPages())
  <div class="card-body pt-0 pb-3">{{ $children->links() }}</div>
  @endif
</div>
@endsection
