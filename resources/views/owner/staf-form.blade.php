@extends('layouts.app')
@section('title', isset($staf) ? 'Edit Staf' : 'Tambah Staf')
@section('page-title', isset($staf) ? 'Edit Staf' : 'Tambah Staf')
@section('content')

<div class="page-header">
  <h4>{{ isset($staf) ? 'Edit Staf' : 'Tambah Staf' }}</h4>
  <p class="page-sub">{{ isset($staf) ? 'Perbarui data staf.' : 'Daftarkan staf baru ke sistem.' }}</p>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body">
    @if(isset($staf))
      <form method="POST" action="{{ route('owner.staf.update',$staf->id) }}">@csrf @method('PUT')
    @else
      <form method="POST" action="{{ route('owner.staf.store') }}">@csrf
    @endif

    <div class="row g-3">
      <div class="col-12">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name" class="form-control"
               value="{{ $staf->name ?? '' }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">No HP</label>
        <input type="text" name="phone" class="form-control"
               value="{{ $staf->phone ?? '' }}"
               {{ isset($staf) ? 'readonly' : '' }} required>
        @if(isset($staf))
          <div class="form-text text-muted">No HP tidak dapat diubah.</div>
        @endif
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ $staf->email ?? '' }}">
      </div>

      @if(!isset($staf))
      <div class="col-md-6">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
          @foreach(['THERAPIST'=>'Terapis','RECEPTIONIST'=>'Resepsionis','ADMIN'=>'Admin','DIREKTUR'=>'Direktur'] as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
          @endforeach
        </select>
      </div>
      @endif

      <div class="col-md-6">
        <label class="form-label">Cabang</label>
        <select name="branch_id" class="form-select">
          <option value="">— Semua Cabang —</option>
          @foreach($branches as $br)
            <option value="{{ $br->id }}"
              @selected(isset($staf) && $staf->branch_id === $br->id)>
              {{ $br->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">
          Password {{ isset($staf) ? '<span class="text-muted fw-normal">(kosongkan jika tidak diubah)</span>' : '' }}
        </label>
        <input type="password" name="password" class="form-control"
               {{ isset($staf) ? '' : 'required' }} minlength="6"
               placeholder="{{ isset($staf) ? '••••••' : 'Min. 6 karakter' }}">
      </div>

      @if(isset($staf))
      <div class="col-12">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                 value="1" @checked($staf->is_active)>
          <label class="form-check-label" for="isActive">Staf aktif</label>
        </div>
      </div>
      @endif
    </div>

    <div class="mt-4 d-flex gap-2">
      <button class="btn btn-pink">
        <span class="iconify me-1" data-icon="tabler:device-floppy"></span> Simpan
      </button>
      <a href="{{ route('owner.staf.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endsection
