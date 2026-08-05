@extends('layouts.app')
@section('title','Walk In')
@section('page-title','Walk In')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Walk In</h4>
    <p class="page-sub">Halaman dalam pengembangan.</p>
  </div>
  <a href="{{ route('owner.dashboard') }}" class="btn btn-sm btn-outline-secondary">
    <span class="iconify me-1" data-icon="tabler:arrow-left"></span> Kembali
  </a>
</div>

<div class="card">
  <div class="card-body text-center text-muted py-5">
    <span class="iconify fs-1 d-block mb-3" data-icon="tabler:construction"></span>
    <p class="mb-0">Halaman <strong>Walk In</strong> sedang dalam pengembangan.</p>
  </div>
</div>
@endsection
