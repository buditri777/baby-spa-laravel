@extends('layouts.app')
@section('title','Sesi')
@section('page-title','Sesi')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Sesi</span>
    <a href="{{ route('therapist.jadwal') }}" class="btn btn-sm btn-outline-secondary">
      <i class='bx bx-arrow-back'></i> Kembali
    </a>
  </div>
  <div class="card-body">
    <p class="text-muted">Halaman <strong>Sesi</strong> sedang dalam pengembangan.</p>
  </div>
</div>
@endsection
