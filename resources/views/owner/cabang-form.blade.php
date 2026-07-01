@extends("layouts.app")
@section("title", isset($branch) ? "Edit Cabang" : "Tambah Cabang")
@section("page-title", isset($branch) ? "Edit Cabang" : "Tambah Cabang")
@section("content")
<div class="card shadow-sm" style="max-width:520px">
  <div class="card-header bg-white"><span class="fw-semibold">{{ isset($branch) ? "Edit" : "Tambah" }} Cabang</span></div>
  <div class="card-body">
    @if(isset($branch))
      <form method="POST" action="{{ route("owner.cabang.update",$branch->id) }}">@csrf @method("PUT")
    @else
      <form method="POST" action="{{ route("owner.cabang.store") }}">@csrf
    @endif
    <div class="row g-3">
      <div class="col-12"><label class="form-label">Nama Cabang</label>
        <input type="text" name="name" class="form-control" value="{{ $branch->name ?? "" }}" required></div>
      <div class="col-12"><label class="form-label">Alamat</label>
        <textarea name="address" class="form-control" rows="2">{{ $branch->address ?? "" }}</textarea></div>
      <div class="col-md-6"><label class="form-label">Telepon</label>
        <input type="text" name="phone" class="form-control" value="{{ $branch->phone ?? "" }}"></div>
      <div class="col-12">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(!isset($branch) || $branch->is_active)>
          <label class="form-check-label">Aktif</label>
        </div>
      </div>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-pink">Simpan</button>
      <a href="{{ route("owner.cabang.index") }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
