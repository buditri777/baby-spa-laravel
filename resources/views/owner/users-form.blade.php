@extends("layouts.app")
@section("title","Edit User")
@section("page-title","Edit User")
@section("content")

<div class="page-header">
  <h4>Edit User: {{ $user->name }}</h4>
  <p class="page-sub">Ubah role, cabang, atau reset password.</p>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body">
    <form method="POST" action="{{ route('owner.users.update', $user->id) }}">
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
          <label class="form-label">Role</label>
          <select name="role" class="form-select">
            @foreach(["PARENT","THERAPIST","RECEPTIONIST","ADMIN","DIREKTUR","OWNER","SUPER_ADMIN"] as $r)
              <option value="{{ $r }}" @selected($user->role===$r)>{{ $r }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Cabang</label>
          <select name="branch_id" class="form-select">
            <option value="">— Semua Cabang —</option>
            @foreach($branches as $br)
              <option value="{{ $br->id }}" @selected($user->branch_id===$br->id)>{{ $br->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password Baru <span class="text-muted fw-normal">(kosongkan jika tidak diubah)</span></label>
          <input type="password" name="password" class="form-control" minlength="6" placeholder="••••••">
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select name="is_active" class="form-select">
            <option value="1" @selected($user->is_active)>Aktif</option>
            <option value="0" @selected(!$user->is_active)>Nonaktif</option>
          </select>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-pink">
          <span class="iconify me-1" data-icon="tabler:device-floppy"></span> Simpan
        </button>
        <a href="{{ route('owner.users') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
