@extends("layouts.app")
@section("title","Akun Pasien")
@section("page-title","Manajemen Akun Pasien")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Akun Pasien</span>
    <button class="btn btn-sm btn-pink" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bx bx-plus"></i> Tambah Akun</button>
  </div>
  <div class="card-body">
    <form class="row g-2 mb-3" method="GET">
      <div class="col-sm-6"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama / no HP..." value="{{ request('search') }}"></div>
      <div class="col-sm-2"><button class="btn btn-sm btn-outline-secondary w-100">Cari</button></div>
    </form>
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Nama</th><th>HP</th><th>Anak</th><th>Daftar</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($patients as $p)
        <tr>
          <td>{{ $p->name }}</td>
          <td>{{ $p->phone }}</td>
          <td>{{ $p->children->count() }}</td>
          <td>{{ $p->created_at?->format('d M Y') }}</td>
          <td><span class="badge bg-{{ $p->is_active?'success':'secondary' }}">{{ $p->is_active?'Aktif':'Nonaktif' }}</span></td>
          <td>
            <form method="POST" action="{{ route('owner.akun-pasien') }}/{{ $p->id }}" class="d-inline">
              @csrf @method('PUT')
              <input type="hidden" name="is_active" value="{{ $p->is_active ? '0' : '1' }}">
              <button class="btn btn-xs btn-outline-{{ $p->is_active?'danger':'success' }}">{{ $p->is_active?'Nonaktifkan':'Aktifkan' }}</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada akun pasien.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $patients->links() }}
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('owner.akun-pasien') }}">@csrf
      <div class="modal-header"><h5 class="modal-title">Tambah Akun Pasien</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">No HP</label><input type="text" name="phone" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required minlength="6"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-pink">Buat Akun</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
