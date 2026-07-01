@extends('layouts.app')
@section('title','Akun Pasien')
@section('page-title','Akun Pasien')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Akun Pasien</span>
    <a href="{{ route('owner.dashboard') }}" class="btn btn-sm btn-outline-secondary">
      <i class='bx bx-arrow-back'></i> Kembali
    </a>
  </div>
  <div class="card-body">
    <p class="text-muted">Halaman <strong>Akun Pasien</strong> sedang dalam pengembangan.</p>
  </div>
</div>
@endsection
