@extends('layouts.app')
@section('title', isset($staf) ? 'Edit Staf' : 'Tambah Staf')
@section('page-title', isset($staf) ? 'Edit Staf' : 'Tambah Staf')
@section('content')
<div class="card shadow-sm" style="max-width:600px">
  <div class="card-header bg-white"><span class="fw-semibold">{{ isset($staf) ? 'Edit Staf' : 'Tambah Staf' }}</span></div>
  <div class="card-body">
    @if(isset($staf))
      <form method="POST" action="{{ route('owner.staf.update',$staf->id) }}">@csrf @method('PUT')
    @else
      <form method="POST" action="{{ route('owner.staf.store') }}">@csrf
    @endif
    <div class="row g-3">
      <div class="col-12"><label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ $staf->name ?? '' }}" required></div>
      <div class="col-md-6"><label class="form-label">No HP</label>
        <input type="text" name="phone" class="form-control" value="{{ $staf->phone ?? '' }}" {{ isset($staf)?'readonly':'' }} required></div>
      <div class="col-md-6"><label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $staf->email ?? '' }}"></div>
      @if(!isset($staf))
      <div class="col-md-6"><label class="form-label">Role</label>
        <select name="role" class="form-select" required>
          @foreach(['THERAPIST','RECEPTIONIST','ADMIN','DIREKTUR'] as $r)
            <option value="{{ $r }}">{{ $r }}</option>
          @endforeach
        </select>
      </div>
      @endif
      <div class="col-md-6"><label class="form-label">Cabang</label>
        <select name="branch_id" class="form-select">
          <option value="">-- Semua Cabang --</option>
          @foreach($branches as $br)
            <option value="{{ $br->id }}" @selected(isset($staf) && $staf->branch_id===$br->id)>{{ $br->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">Password {{ isset($staf) ? '(kosongkan jika tidak diubah)' : '' }}</label>
        <input type="password" name="password" class="form-control" {{ isset($staf)?'':'required' }} minlength="6"></div>
      @if(isset($staf))
      <div class="col-12">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked($staf->is_active)>
          <label class="form-check-label">Aktif</label>
        </div>
      </div>
      @endif
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-pink">Simpan</button>
      <a href="{{ route('owner.staf.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endsection
@push('styles')<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
