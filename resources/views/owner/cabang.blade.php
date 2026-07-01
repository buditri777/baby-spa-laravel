@extends("layouts.app")
@section("title","Cabang")
@section("page-title","Manajemen Cabang")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Daftar Cabang</span>
    <a href="{{ route("owner.cabang.create") }}" class="btn btn-sm btn-pink"><i class="bx bx-plus"></i> Tambah Cabang</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Nama</th><th>Alamat</th><th>Telepon</th><th>Booking</th><th>Terapis</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($branches as $b)
        <tr>
          <td>{{ $b->name }}</td>
          <td>{{ $b->address ?? "-" }}</td>
          <td>{{ $b->phone ?? "-" }}</td>
          <td>{{ $b->bookings_count }}</td>
          <td>{{ $b->therapists_count }}</td>
          <td><span class="badge bg-{{ $b->is_active?"success":"secondary" }}">{{ $b->is_active?"Aktif":"Nonaktif" }}</span></td>
          <td>
            <a href="{{ route("owner.cabang.edit",$b->id) }}" class="btn btn-xs btn-outline-primary"><i class="bx bx-edit"></i></a>
            <form method="POST" action="{{ route("owner.cabang.destroy",$b->id) }}" class="d-inline" onsubmit="return confirm('Nonaktifkan cabang ini?')">
              @csrf @method("DELETE")
              <button class="btn btn-xs btn-outline-danger"><i class="bx bx-x"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada cabang.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $branches->links() }}
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
