@extends("layouts.app")
@section("title","Akun Pasien")
@section("page-title","Manajemen Akun Pasien")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Akun Pasien</h4>
    <p class="page-sub">Kelola akun orang tua & aktifasi akses.</p>
  </div>
  <button class="btn btn-sm btn-pink" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Tambah Akun
  </button>
</div>

<div class="card">
  <div class="card-body border-bottom pb-3">
    <form class="row g-2" method="GET">
      <div class="col-sm-5">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Cari nama / no HP…" value="{{ request('search') }}">
      </div>
      <div class="col-sm-2">
        <button class="btn btn-sm btn-outline-secondary w-100">Cari</button>
      </div>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Nama</th><th>HP</th><th>Anak</th><th>Daftar</th><th>Status</th><th class="text-end">Aksi</th></tr>
      </thead>
      <tbody>
      @forelse($patients as $p)
      <tr>
        <td class="fw-semibold">{{ $p->name }}</td>
        <td class="text-muted">{{ $p->phone }}</td>
        <td><span class="badge badge-confirmed">{{ $p->children->count() }}</span></td>
        <td class="text-muted small">{{ $p->created_at?->format('d M Y') }}</td>
        <td>
          <span class="badge {{ $p->is_active ? 'badge-completed' : 'badge-inactive' }}">
            {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
          </span>
        </td>
        <td class="text-end">
          <form method="POST" action="{{ route('owner.akun-pasien') }}/{{ $p->id }}" class="d-inline">
            @csrf @method('PUT')
            <input type="hidden" name="is_active" value="{{ $p->is_active ? 0 : 1 }}">
            <button class="btn btn-xs {{ $p->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
              {{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:users-off"></span>
        Belum ada akun pasien.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if(isset($patients) && method_exists($patients,'hasPages') && $patients->hasPages())
  <div class="card-body pt-0 pb-3">{{ $patients->links() }}</div>
  @endif
</div>

{{-- Modal Tambah Akun --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Akun Pasien</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('owner.akun-pasien.store') }}">
        @csrf
        <div class="modal-body row g-3">
          <div class="col-12">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">No HP</label>
            <input type="text" name="phone" class="form-control" required placeholder="08xxxxxxxxxx">
          </div>
          <div class="col-md-6">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-pink">Buat Akun</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
