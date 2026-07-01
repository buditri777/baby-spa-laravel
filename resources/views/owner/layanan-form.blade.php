@extends('layouts.app')
@section('title','Layanan Form')
@section('page-title','Layanan Form')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Layanan Form</span>
    <a href="{{ route('owner.dashboard') }}" class="btn btn-sm btn-outline-secondary">
      <i class='bx bx-arrow-back'></i> Kembali
    </a>
  </div>
  <div class="card-body">
    <p class="text-muted">Halaman <strong>Layanan Form</strong> sedang dalam pengembangan.</p>
  </div>
</div>
@endsection
