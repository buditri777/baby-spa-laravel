@extends('layouts.app')
@section('title','Booking Form')
@section('page-title','Booking Form')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Booking Form</span>
    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
      <i class='bx bx-arrow-back'></i> Kembali
    </a>
  </div>
  <div class="card-body">
    <p class="text-muted">Halaman <strong>Booking Form</strong> sedang dalam pengembangan.</p>
  </div>
</div>
@endsection
