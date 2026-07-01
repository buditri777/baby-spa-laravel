@extends("layouts.app")
@section("title", isset($child) ? "Edit Anak" : "Tambah Anak")
@section("page-title", isset($child) ? "Edit Data Anak" : "Tambah Data Anak")
@section("content")
<div class="card shadow-sm" style="max-width:560px">
  <div class="card-header bg-white fw-semibold">{{ isset($child) ? "Edit" : "Tambah" }} Data Anak</div>
  <div class="card-body">
    @if(isset($child))
      <form method="POST" action="{{ route('anak.update',$child->id) }}">@csrf @method('PUT')
    @else
      <form method="POST" action="{{ route('anak.store') }}">@csrf
    @endif
    <div class="row g-3">
      <div class="col-12"><label class="form-label">Nama Anak</label>
        <input type="text" name="name" class="form-control" value="{{ $child->name ?? '' }}" required></div>
      <div class="col-md-6"><label class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
          <option value="L" @selected(isset($child) && $child->gender==='L')>Laki-laki</option>
          <option value="P" @selected(isset($child) && $child->gender==='P')>Perempuan</option>
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">Tanggal Lahir</label>
        <input type="date" name="birth_date" class="form-control" value="{{ isset($child) ? $child->birth_date?->format('Y-m-d') : '' }}" required></div>
      <div class="col-12"><label class="form-label">Alergi</label>
        <input type="text" name="allergies" class="form-control" value="{{ $child->allergies ?? '' }}" placeholder="Kosongkan jika tidak ada"></div>
      <div class="col-12"><label class="form-label">Catatan Medis</label>
        <textarea name="medical_conditions" class="form-control" rows="2">{{ $child->medical_conditions ?? '' }}</textarea></div>
      <div class="col-12"><label class="form-label">Catatan Lain</label>
        <textarea name="notes" class="form-control" rows="2">{{ $child->notes ?? '' }}</textarea></div>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-pink">Simpan</button>
      <a href="{{ route('anak.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
