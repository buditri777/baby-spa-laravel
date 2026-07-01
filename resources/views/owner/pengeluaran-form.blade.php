@extends('layouts.app')
@section('title', isset($expense) ? 'Edit Pengeluaran' : 'Tambah Pengeluaran')
@section('page-title', isset($expense) ? 'Edit Pengeluaran' : 'Tambah Pengeluaran')
@section('content')
<div class="card shadow-sm" style="max-width:560px">
  <div class="card-header bg-white"><span class="fw-semibold">{{ isset($expense) ? 'Edit' : 'Tambah' }} Pengeluaran</span></div>
  <div class="card-body">
    @if(isset($expense))
      <form method="POST" action="{{ route('owner.pengeluaran.update',$expense->id) }}">@csrf @method('PUT')
    @else
      <form method="POST" action="{{ route('owner.pengeluaran.store') }}">@csrf
    @endif
    <div class="row g-3">
      <div class="col-12"><label class="form-label">Keterangan</label>
        <input type="text" name="description" class="form-control" value="{{ $expense->description ?? '' }}" required></div>
      <div class="col-md-6"><label class="form-label">Jumlah (Rp)</label>
        <input type="number" name="amount" class="form-control" value="{{ $expense->amount ?? '' }}" min="0" required></div>
      <div class="col-md-6"><label class="form-label">Tanggal</label>
        <input type="date" name="expense_date" class="form-control" value="{{ isset($expense) ? $expense->expense_date?->format('Y-m-d') : date('Y-m-d') }}" required></div>
      <div class="col-md-6"><label class="form-label">Kategori</label>
        <input type="text" name="category" class="form-control" value="{{ $expense->category ?? '' }}" placeholder="Operasional, Gaji, dll"></div>
      <div class="col-md-6"><label class="form-label">Cabang</label>
        <select name="branch_id" class="form-select">
          <option value="">-- Pilih Cabang --</option>
          @foreach($branches as $br)
            <option value="{{ $br->id }}" @selected(isset($expense) && $expense->branch_id===$br->id)>{{ $br->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-pink">Simpan</button>
      <a href="{{ route('owner.pengeluaran.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endsection
@push('styles')<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
