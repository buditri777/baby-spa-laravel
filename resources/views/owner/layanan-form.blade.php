@extends('layouts.app')
@section('title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')
@section('page-title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')
@section('content')

<div class="page-header">
  <h4>{{ isset($service) ? 'Edit Layanan' : 'Tambah Layanan' }}</h4>
  <p class="page-sub">{{ isset($service) ? 'Perbarui detail layanan.' : 'Tambah layanan baru ke katalog.' }}</p>
</div>

<div class="card" style="max-width:700px">
  <div class="card-body">
    @if(isset($service))
      <form method="POST" action="{{ route('owner.layanan.update', $service->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
    @else
      <form method="POST" action="{{ route('owner.layanan.store') }}" enctype="multipart/form-data">
        @csrf
    @endif
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nama Layanan</label>
        <input type="text" name="name" class="form-control" value="{{ $service->name ?? '' }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Kategori</label>
        <input type="text" name="category" class="form-control" value="{{ $service->category ?? '' }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Harga (Rp)</label>
        <input type="number" name="price" class="form-control" value="{{ $service->price ?? '' }}" min="0" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Durasi (menit)</label>
        <input type="number" name="duration_min" class="form-control" value="{{ $service->duration_min ?? '' }}" min="1" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Usia Min (bulan)</label>
        <input type="number" name="age_min_months" class="form-control" value="{{ $service->age_min_months ?? '' }}" min="0">
      </div>
      <div class="col-md-6">
        <label class="form-label">Usia Maks (bulan)</label>
        <input type="number" name="age_max_months" class="form-control" value="{{ $service->age_max_months ?? '' }}" min="0">
      </div>
      <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3">{{ $service->description ?? '' }}</textarea>
      </div>
      <div class="col-12">
        <label class="form-label">Foto <span class="text-muted fw-normal">(opsional)</span></label>
        <input type="file" name="photo" class="form-control" accept="image/*">
        @if(isset($service) && $service->photo_url)
        <div class="mt-2">
          <img src="{{ $service->photo_url }}" style="height:80px;border-radius:.5rem;object-fit:cover" alt="">
        </div>
        @endif
      </div>
      <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-select">
          <option value="1" @selected(($service->is_active ?? true))>Aktif</option>
          <option value="0" @selected(!(($service->is_active ?? true)))>Nonaktif</option>
        </select>
      </div>
    </div>
    <div class="mt-4 d-flex gap-2">
      <button class="btn btn-pink">
        <span class="iconify me-1" data-icon="tabler:device-floppy"></span> Simpan
      </button>
      <a href="{{ route('owner.layanan') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endsection
