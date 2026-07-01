@extends('layouts.app')
@section('title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')
@section('page-title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')
@section('content')
<div class="card shadow-sm" style="max-width:700px">
  <div class="card-header bg-white"><span class="fw-semibold">{{ isset($service) ? 'Edit Layanan' : 'Tambah Layanan' }}</span></div>
  <div class="card-body">
    @if(isset($service))
      <form method="POST" action="{{ route('owner.layanan.update',$service->id) }}">@csrf @method('PUT')
    @else
      <form method="POST" action="{{ route('owner.layanan.store') }}">@csrf
    @endif
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Nama Layanan</label>
        <input type="text" name="name" class="form-control" value="{{ $service->name ?? '' }}" required></div>
      <div class="col-md-6"><label class="form-label">Kategori</label>
        <input type="text" name="category" class="form-control" value="{{ $service->category ?? '' }}" required></div>
      <div class="col-md-6"><label class="form-label">Harga (Rp)</label>
        <input type="number" name="price" class="form-control" value="{{ $service->price ?? '' }}" min="0" required></div>
      <div class="col-md-6"><label class="form-label">Durasi (menit)</label>
        <input type="number" name="duration_min" class="form-control" value="{{ $service->duration_min ?? '' }}" min="1" required></div>
      <div class="col-md-6"><label class="form-label">Usia Min (bulan)</label>
        <input type="number" name="age_min_months" class="form-control" value="{{ $service->age_min_months ?? '' }}" min="0"></div>
      <div class="col-md-6"><label class="form-label">Usia Maks (bulan)</label>
        <input type="number" name="age_max_months" class="form-control" value="{{ $service->age_max_months ?? '' }}" min="0"></div>
      <div class="col-md-6"><label class="form-label">Cabang</label>
        <select name="branch_id" class="form-select">
          <option value="">-- Global (semua cabang) --</option>
          @foreach($branches as $br)
            <option value="{{ $br->id }}" @selected(isset($service) && $service->branch_id===$br->id)>{{ $br->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12"><label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="2">{{ $service->description ?? '' }}</textarea></div>
      <div class="col-12">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(!isset($service) || $service->is_active)>
          <label class="form-check-label">Aktif</label>
        </div>
      </div>
      <div class="col-12"><hr><h6 class="fw-semibold">Rate Honor Terapis (opsional)</h6></div>
      <div class="col-md-4"><label class="form-label">Tipe</label>
        <select name="fee_type" class="form-select">
          <option value="PERCENT" @selected(isset($service) && $service->rate?->fee_type==='PERCENT')>Persentase (%)</option>
          <option value="FLAT" @selected(isset($service) && $service->rate?->fee_type==='FLAT')>Flat (Rp)</option>
        </select>
      </div>
      <div class="col-md-4"><label class="form-label">Nilai</label>
        <input type="number" name="fee_value" class="form-control" value="{{ $service->rate?->fee_value ?? '' }}" min="0" step="0.01"></div>
      <div class="col-md-4"><label class="form-label">Homecare Base Fee (Rp)</label>
        <input type="number" name="homecare_base_fee" class="form-control" value="{{ $service->rate?->homecare_base_fee ?? '' }}" min="0"></div>
      <div class="col-md-4"><label class="form-label">Homecare per KM (Rp)</label>
        <input type="number" name="homecare_per_km_fee" class="form-control" value="{{ $service->rate?->homecare_per_km_fee ?? '' }}" min="0"></div>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-pink">Simpan</button>
      <a href="{{ route('owner.layanan.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endsection
@push('styles')<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
