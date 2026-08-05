@extends("layouts.app")
@section("title","Akun Saya")
@section("page-title","Akun Saya")
@section("content")

<div class="page-header">
  <h4>Profil Akun</h4>
  <p class="page-sub">Perbarui informasi pribadi dan lokasi homecare.</p>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body">
    <form method="POST" action="/akun">
      @csrf @method("PUT")
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">Nama</label>
          <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ $user->email ?? '' }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">No HP</label>
          <input type="text" class="form-control" value="{{ $user->phone }}" readonly disabled>
          <div class="form-text text-muted">No HP tidak dapat diubah.</div>
        </div>
        <div class="col-12">
          <label class="form-label">Alamat</label>
          <input type="text" name="address_line" class="form-control" value="{{ $user->address_line ?? '' }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Provinsi</label>
          <input type="text" name="province" class="form-control" value="{{ $user->province ?? '' }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Kota</label>
          <input type="text" name="city" class="form-control" value="{{ $user->city ?? '' }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Kecamatan</label>
          <input type="text" name="district" class="form-control" value="{{ $user->district ?? '' }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Kelurahan</label>
          <input type="text" name="village" class="form-control" value="{{ $user->village ?? '' }}">
        </div>

        @if($user->role === "PARENT")
        <div class="col-12">
          <div class="pt-2 pb-1 small fw-semibold text-muted" style="border-top:1px solid var(--border);letter-spacing:.04em;text-transform:uppercase">
            Lokasi Homecare
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Latitude</label>
          <input type="text" name="homecare_latitude" class="form-control"
                 value="{{ $user->homecare_latitude ?? '' }}" placeholder="-7.123456">
        </div>
        <div class="col-md-6">
          <label class="form-label">Longitude</label>
          <input type="text" name="homecare_longitude" class="form-control"
                 value="{{ $user->homecare_longitude ?? '' }}" placeholder="110.123456">
        </div>
        @endif

        <div class="col-12">
          <div class="pt-2 pb-1 small fw-semibold text-muted" style="border-top:1px solid var(--border);letter-spacing:.04em;text-transform:uppercase">
            Ganti Password
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password Baru <span class="text-muted fw-normal">(kosongkan jika tidak diubah)</span></label>
          <input type="password" name="password" class="form-control" minlength="6" placeholder="••••••">
        </div>
        <div class="col-md-6">
          <label class="form-label">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="••••••">
        </div>
      </div>
      <div class="mt-4">
        <button class="btn btn-pink">
          <span class="iconify me-1" data-icon="tabler:device-floppy"></span> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
