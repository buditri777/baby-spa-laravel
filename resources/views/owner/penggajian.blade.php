@extends('layouts.app')
@section('title','Penggajian')
@section('page-title','Penggajian')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Penggajian</span>
    <a href="{{ route('owner.dashboard') }}" class="btn btn-sm btn-outline-secondary">
      <i class='bx bx-arrow-back'></i> Kembali
    </a>
  </div>
  <div class="card-body">
    <p class="text-muted">Halaman <strong>Penggajian</strong> sedang dalam pengembangan.</p>
  </div>
</div>
@endsection
