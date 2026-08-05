@extends("layouts.app")
@section("title","Milestone")
@section("page-title","Milestone Tumbuh Kembang")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Milestone Tumbuh Kembang</h4>
    <p class="page-sub">Catat pencapaian perkembangan anak.</p>
  </div>
  @if(!isset($form))
  <a href="{{ route('owner.milestone', ['form'=>1]) }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Tambah
  </a>
  @endif
</div>

@if(isset($form))
<div class="card mb-4" style="max-width:560px">
  <div class="card-header">
    <span class="iconify me-2 text-primary" data-icon="tabler:award"></span>Tambah Milestone
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('owner.milestone') }}">
      @csrf
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">Anak</label>
          <select name="child_id" class="form-select" required>
            <option value="">— Pilih Anak —</option>
            @foreach($children as $c)
              <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->parent?->name }})</option>
            @endforeach
          </select>
        </div>
        <div class="col-12">
          <label class="form-label">Judul</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Kategori</label>
          <input type="text" name="category" class="form-control" placeholder="Motorik, Bahasa, Sosial…">
        </div>
        <div class="col-md-6">
          <label class="form-label">Tanggal Dicapai</label>
          <input type="date" name="achieved_at" class="form-control" required>
        </div>
        <div class="col-12">
          <label class="form-label">Catatan</label>
          <textarea name="notes" class="form-control" rows="2"></textarea>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-pink">
          <span class="iconify me-1" data-icon="tabler:device-floppy"></span> Simpan
        </button>
        <a href="{{ route('owner.milestone') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endif

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Anak</th><th>Orang Tua</th><th>Judul</th><th>Kategori</th><th>Tanggal</th><th class="text-end">Aksi</th></tr>
      </thead>
      <tbody>
      @forelse($milestones as $m)
      <tr>
        <td class="fw-semibold">{{ $m->child?->name }}</td>
        <td class="text-muted small">{{ $m->child?->parent?->name }}</td>
        <td>{{ $m->title }}</td>
        <td><span class="badge badge-confirmed">{{ $m->category ?? '—' }}</span></td>
        <td class="text-muted small">{{ \Carbon\Carbon::parse($m->achieved_at)->format('d M Y') }}</td>
        <td class="text-end">
          <form method="POST" action="{{ route('owner.milestone.destroy', $m->id) }}" class="d-inline"
                onsubmit="return confirm('Hapus milestone ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-xs btn-outline-danger">
              <span class="iconify" data-icon="tabler:trash"></span>
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:award-off"></span>
        Belum ada milestone.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($milestones->hasPages())
  <div class="card-body pt-0 pb-3">{{ $milestones->links() }}</div>
  @endif
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
