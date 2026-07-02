@extends("layouts.app")
@section("title","Pengguna")
@section("page-title","Manajemen Pengguna")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Daftar Pengguna</span>
    <a href="{{ route("owner.staf.create") }}" class="btn btn-sm btn-pink"><i class="bx bx-plus"></i> Tambah</a>
  </div>
  <div class="card-body">
    <form class="row g-2 mb-3" method="GET">
      <div class="col-sm-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama / HP..." value="{{ request("search") }}"></div>
      <div class="col-sm-3">
        <select name="role" class="form-select form-select-sm">
          <option value="">Semua Role</option>
          @foreach(["PARENT","THERAPIST","RECEPTIONIST","ADMIN","DIREKTUR","OWNER","SUPER_ADMIN"] as $r)
            <option value="{{ $r }}" @selected(request("role")===$r)>{{ $r }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-2"><button class="btn btn-sm btn-outline-secondary w-100">Filter</button></div>
    </form>
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Nama</th><th>HP</th><th>Role</th><th>Cabang</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($users as $u)
        <tr>
          <td>{{ $u->name }}</td>
          <td>{{ $u->phone }}</td>
          <td><span class="badge bg-primary">{{ $u->role }}</span></td>
          <td>{{ $u->branch?->name ?? "-" }}</td>
          <td><span class="badge bg-{{ $u->is_active?"success":"secondary" }}">{{ $u->is_active?"Aktif":"Nonaktif" }}</span></td>
          <td>
            <a href="{{ route("owner.users.edit",$u->id) }}" class="btn btn-xs btn-outline-primary"><i class="bx bx-edit"></i></a>
            <form method="POST" action="{{ route("owner.users.destroy",$u->id) }}" class="d-inline" onsubmit="return confirm('Nonaktifkan user ini?')">
              @csrf @method("DELETE")
              <button class="btn btn-xs btn-outline-danger"><i class="bx bx-user-x"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pengguna.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $users->links() }}
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
