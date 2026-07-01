@extends('layouts.app')
@section('title','Milestone')
@section('page-title','Milestone')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Milestone</span>
    <a href="{{ route('owner.dashboard') }}" class="btn btn-sm btn-outline-secondary">
      <i class='bx bx-arrow-back'></i> Kembali
    </a>
  </div>
  <div class="card-body">
    <p class="text-muted">Halaman <strong>Milestone</strong> sedang dalam pengembangan.</p>
  </div>
</div>
@endsection
