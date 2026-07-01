@extends('layouts.app')
@section('title','Reservasi Ig')
@section('page-title','Reservasi Ig')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Reservasi Ig</span>
    <a href="{{ route('owner.dashboard') }}" class="btn btn-sm btn-outline-secondary">
      <i class='bx bx-arrow-back'></i> Kembali
    </a>
  </div>
  <div class="card-body">
    <p class="text-muted">Halaman <strong>Reservasi Ig</strong> sedang dalam pengembangan.</p>
  </div>
</div>
@endsection
