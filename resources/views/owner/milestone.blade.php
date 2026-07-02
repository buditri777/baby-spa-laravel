@extends("layouts.app")
@section("title","Milestone")
@section("page-title","Milestone Tumbuh Kembang")
@section("content")
@if(isset($form))
<div class="card shadow-sm mb-3" style="max-width:560px">
  <div class="card-header bg-white fw-semibold">Tambah Milestone</div>
  <div class="card-body">
    <form method="POST" action="{{ route('owner.milestone') }}">@csrf
    <div class="row g-3">
      <div class="col-12"><label class="form-label">Anak</label>
        <select name="child_id" class="form-select" required>
          <option value="">-- Pilih Anak --</option>
          @foreach($children as $c)
            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->parent?->name }})</option>
          @endforeach
        </select>
      </div>
      <div class="col-12"><label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required></div>
      <div class="col-md-6"><label class="form-label">Kategori</label>
        <input type="text" name="category" class="form-control" placeholder="Motorik, Bahasa, Sosial..."></div>
      <div class="col-md-6"><label class="form-label">Tanggal Dicapai</label>
        <input type="date" name="achieved_at" class="form-control" required></div>
      <div class="col-12"><label class="form-label">Catatan</label>
        <textarea name="notes" class="form-control" rows="2"></textarea></div>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-pink">Simpan</button>
      <a href="{{ route('owner.milestone') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endif
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Daftar Milestone</span>
    <div class="d-flex gap-2">
      <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama anak..." value="{{ request('search') }}">
        <button class="btn btn-sm btn-outline-secondary">Cari</button>
      </form>
      <a href="{{ route('owner.milestone') }}?form=1" class="btn btn-sm btn-pink"><i class="bx bx-plus"></i> Tambah</a>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Anak</th><th>Judul</th><th>Kategori</th><th>Tanggal</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($milestones as $m)
        <tr>
          <td>{{ $m->child?->name }}</td>
          <td>{{ $m->title }}</td>
          <td>{{ $m->category ?? '-' }}</td>
          <td>{{ $m->achieved_at?->format('d M Y') }}</td>
          <td>
            <form method="POST" action="{{ route('owner.milestone') }}/{{ $m->id }}" class="d-inline" onsubmit="return confirm('Hapus milestone ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-xs btn-outline-danger"><i class="bx bx-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada milestone.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $milestones->links() }}
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
