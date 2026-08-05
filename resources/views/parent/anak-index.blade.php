@extends("layouts.app")
@section("title","Data Anak")
@section("page-title","Data Anak")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Data Anak</h4>
    <p class="page-sub">Kelola profil si kecil.</p>
  </div>
  <a href="{{ route('anak.create') }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Tambah Anak
  </a>
</div>

@forelse($children as $c)
<div class="card mb-2">
  <div class="card-body py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
      <div class="fw-semibold">{{ $c->name }}</div>
      <div class="small text-muted">
        {{ $c->gender==='L' ? 'Laki-laki' : 'Perempuan' }} · {{ $c->birth_date?->format('d M Y') }}
      </div>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('anak.show',$c->id) }}" class="btn btn-sm btn-outline-primary">
        <span class="iconify" data-icon="tabler:eye"></span>
      </a>
      <a href="{{ route('anak.edit',$c->id) }}" class="btn btn-sm btn-outline-secondary">
        <span class="iconify" data-icon="tabler:edit"></span>
      </a>
    </div>
  </div>
</div>
@empty
<div class="card">
  <div class="card-body text-center text-muted py-5">
    <span class="iconify fs-2 d-block mb-2" data-icon="tabler:baby-carriage"></span>
    Belum ada data anak.
    <a href="{{ route('anak.create') }}" class="d-block mt-2">Tambah sekarang</a>
  </div>
</div>
@endforelse
@endsection
