@extends("layouts.app")
@section("title", isset($branch) ? "Edit Cabang" : "Tambah Cabang")
@section("page-title", isset($branch) ? "Edit Cabang" : "Tambah Cabang")
@section("content")

<div class="page-header">
  <h4>{{ isset($branch) ? "Edit Cabang" : "Tambah Cabang" }}</h4>
  <p class="page-sub">{{ isset($branch) ? "Perbarui data cabang." : "Daftarkan cabang baru." }}</p>
</div>

<div class="card" style="max-width:520px">
  <div class="card-body">
    @if(isset($branch))
      <form method="POST" action="{{ route("owner.cabang.update",$branch->id) }}">@csrf @method("PUT")
    @else
      <form method="POST" action="{{ route("owner.cabang.store") }}">@csrf
    @endif
    <div class="row g-3">
      <div class="col-12">
        <label class="form-label">Nama Cabang</label>
        <input type="text" name="name" class="form-control"
               value="{{ $branch->name ?? "" }}" required>
      </div>
      <div class="col-12">
        <label class="form-label">Alamat</label>
        <textarea name="address" class="form-control" rows="2">{{ $branch->address ?? "" }}</textarea>
      </div>
      <div class="col-md-6">
        <label class="form-label">Telepon</label>
        <input type="text" name="phone" class="form-control" value="{{ $branch->phone ?? "" }}">
      </div>
      <div class="col-12">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                 value="1" @checked(!isset($branch) || $branch->is_active)>
          <label class="form-check-label" for="isActive">Cabang aktif</label>
        </div>
      </div>
    </div>
    <div class="mt-4 d-flex gap-2">
      <button class="btn btn-pink">
        <span class="iconify me-1" data-icon="tabler:device-floppy"></span> Simpan
      </button>
      <a href="{{ route("owner.cabang.index") }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endsection
