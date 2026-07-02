@extends("layouts.app")
@section("title","Edit User")
@section("page-title","Edit User")
@section("content")
<div class="card shadow-sm" style="max-width:600px">
  <div class="card-header bg-white fw-semibold">Edit User: {{ $user->name }}</div>
  <div class="card-body">
    <form method="POST" action="{{ route("owner.users.update",$user->id) }}">@csrf @method("PUT")
    <div class="row g-3">
      <div class="col-12"><label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
      <div class="col-md-6"><label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email ?? "" }}"></div>
      <div class="col-md-6"><label class="form-label">Role</label>
        <select name="role" class="form-select">
          @foreach(["PARENT","THERAPIST","RECEPTIONIST","ADMIN","DIREKTUR","OWNER","SUPER_ADMIN"] as $r)
            <option value="{{ $r }}" @selected($user->role===$r)>{{ $r }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">Cabang</label>
        <select name="branch_id" class="form-select">
          <option value="">-- Semua Cabang --</option>
          @foreach($branches as $br)
            <option value="{{ $br->id }}" @selected($user->branch_id===$br->id)>{{ $br->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control" minlength="6"></div>
      <div class="col-12">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked($user->is_active)>
          <label class="form-check-label">Aktif</label>
        </div>
      </div>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-pink">Simpan</button>
      <a href="{{ route("owner.users.index") }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
