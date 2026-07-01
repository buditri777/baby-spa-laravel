@extends("layouts.app")
@section("title","Data Anak")
@section("page-title","Data Anak")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Daftar Anak</span>
    <a href="{{ route('anak.create') }}" class="btn btn-sm btn-pink"><i class="bx bx-plus"></i> Tambah Anak</a>
  </div>
  <div class="card-body">
    @forelse($children as $c)
    <div class="card mb-2 border-0 shadow-sm">
      <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
        <div>
          <div class="fw-semibold">{{ $c->name }}</div>
          <div class="small text-muted">{{ $c->gender==='L'?'Laki-laki':'Perempuan' }} · {{ $c->birth_date?->format('d M Y') }}</div>
        </div>
        <div class="d-flex gap-2">
          <a href="{{ route('anak.show',$c->id) }}" class="btn btn-sm btn-outline-primary"><i class="bx bx-show"></i></a>
          <a href="{{ route('anak.edit',$c->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bx bx-edit"></i></a>
        </div>
      </div>
    </div>
    @empty
    <p class="text-muted text-center py-4">Belum ada data anak. <a href="{{ route('anak.create') }}">Tambah sekarang</a>.</p>
    @endforelse
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
