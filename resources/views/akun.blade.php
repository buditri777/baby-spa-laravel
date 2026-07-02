@extends("layouts.app")
@section("title","Akun Saya")
@section("page-title","Akun Saya")
@section("content")
<div class="card shadow-sm" style="max-width:600px">
  <div class="card-header bg-white fw-semibold">Profil Akun</div>
  <div class="card-body">
    <form method="POST" action="/akun">@csrf @method("PUT")
    <div class="row g-3">
      <div class="col-12"><label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
      <div class="col-md-6"><label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email ?? "" }}"></div>
      <div class="col-md-6"><label class="form-label">No HP</label>
        <input type="text" class="form-control" value="{{ $user->phone }}" readonly disabled></div>
      <div class="col-12"><label class="form-label">Alamat</label>
        <input type="text" name="address_line" class="form-control" value="{{ $user->address_line ?? "" }}"></div>
      <div class="col-md-6"><label class="form-label">Provinsi</label>
        <input type="text" name="province" class="form-control" value="{{ $user->province ?? "" }}"></div>
      <div class="col-md-6"><label class="form-label">Kota</label>
        <input type="text" name="city" class="form-control" value="{{ $user->city ?? "" }}"></div>
      <div class="col-md-6"><label class="form-label">Kecamatan</label>
        <input type="text" name="district" class="form-control" value="{{ $user->district ?? "" }}"></div>
      <div class="col-md-6"><label class="form-label">Kelurahan</label>
        <input type="text" name="village" class="form-control" value="{{ $user->village ?? "" }}"></div>
      @if($user->role === "PARENT")
      <div class="col-md-6"><label class="form-label">Lat Homecare</label>
        <input type="text" name="homecare_latitude" class="form-control" value="{{ $user->homecare_latitude ?? "" }}" placeholder="-7.123456"></div>
      <div class="col-md-6"><label class="form-label">Long Homecare</label>
        <input type="text" name="homecare_longitude" class="form-control" value="{{ $user->homecare_longitude ?? "" }}" placeholder="110.123456"></div>
      @endif
    </div>
    <div class="mt-3"><button class="btn btn-pink">Simpan Profil</button></div>
    </form>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
