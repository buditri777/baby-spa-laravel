@extends("layouts.app")
@section("title","Cabang")
@section("page-title","Manajemen Cabang")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Manajemen Cabang</h4>
    <p class="page-sub">Kelola cabang klinik Sofia Baby Spa.</p>
  </div>
  <a href="{{ route("owner.cabang.create") }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Tambah Cabang
  </a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Nama</th><th>Alamat</th><th>Telepon</th>
          <th>Booking</th><th>Terapis</th><th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($branches as $b)
      <tr>
        <td class="fw-semibold">{{ $b->name }}</td>
        <td class="text-muted small">{{ $b->address ?? "—" }}</td>
        <td class="text-muted">{{ $b->phone ?? "—" }}</td>
        <td><span class="badge badge-confirmed">{{ $b->bookings_count }}</span></td>
        <td><span class="badge badge-confirmed">{{ $b->therapists_count }}</span></td>
        <td>
          <span class="badge {{ $b->is_active ? "badge-active" : "badge-inactive" }}">
            {{ $b->is_active ? "Aktif" : "Nonaktif" }}
          </span>
        </td>
        <td class="text-end">
          <a href="{{ route("owner.cabang.edit",$b->id) }}" class="btn btn-xs btn-outline-primary">
            <span class="iconify" data-icon="tabler:edit"></span>
          </a>
          <form method="POST" action="{{ route("owner.cabang.destroy",$b->id) }}" class="d-inline"
                onsubmit="return confirm('Nonaktifkan cabang ini?')">
            @csrf @method("DELETE")
            <button class="btn btn-xs btn-outline-danger">
              <span class="iconify" data-icon="tabler:trash"></span>
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:building-store"></span>
        Belum ada cabang terdaftar.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($branches->hasPages())
  <div class="card-body pt-0 pb-3">{{ $branches->links() }}</div>
  @endif
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
