@extends("layouts.app")
@section("title","Pengguna")
@section("page-title","Manajemen Pengguna")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Pengguna</h4>
    <p class="page-sub">Kelola seluruh akun pengguna sistem.</p>
  </div>
  <a href="{{ route('owner.staf.create') }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Tambah
  </a>
</div>

<div class="card">
  <div class="card-body border-bottom pb-3">
    <form class="row g-2" method="GET">
      <div class="col-sm-4">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Cari nama / HP…" value="{{ request('search') }}">
      </div>
      <div class="col-sm-3">
        <select name="role" class="form-select form-select-sm">
          <option value="">Semua Role</option>
          @foreach(["PARENT","THERAPIST","RECEPTIONIST","ADMIN","DIREKTUR","OWNER","SUPER_ADMIN"] as $r)
            <option value="{{ $r }}" @selected(request('role')===$r)>{{ $r }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-2">
        <button class="btn btn-sm btn-outline-secondary w-100">Filter</button>
      </div>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Nama</th><th>HP</th><th>Role</th><th>Cabang</th><th>Status</th><th class="text-end">Aksi</th></tr>
      </thead>
      <tbody>
      @forelse($users as $u)
      <tr>
        <td class="fw-semibold">{{ $u->name }}</td>
        <td class="text-muted">{{ $u->phone }}</td>
        <td><span class="badge badge-confirmed">{{ $u->role }}</span></td>
        <td class="text-muted small">{{ $u->branch?->name ?? '—' }}</td>
        <td>
          <span class="badge {{ $u->is_active ? 'badge-completed' : 'badge-inactive' }}">
            {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
          </span>
        </td>
        <td class="text-end">
          <a href="{{ route('owner.users.edit', $u->id) }}" class="btn btn-xs btn-outline-primary me-1">
            <span class="iconify" data-icon="tabler:edit"></span>
          </a>
          <form method="POST" action="{{ route('owner.users.destroy', $u->id) }}" class="d-inline"
                onsubmit="return confirm('Hapus pengguna ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-xs btn-outline-danger">
              <span class="iconify" data-icon="tabler:trash"></span>
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:users-off"></span>
        Tidak ada pengguna.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($users->hasPages())
  <div class="card-body pt-0 pb-3">{{ $users->links() }}</div>
  @endif
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
