@extends('layouts.app')
@section('title','Pengeluaran')
@section('page-title','Pengeluaran')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Daftar Pengeluaran</span>
    <a href="{{ route('owner.pengeluaran.create') }}" class="btn btn-sm btn-pink"><i class="bx bx-plus"></i> Tambah</a>
  </div>
  <div class="card-body">
    <form class="row g-2 mb-3" method="GET">
      <div class="col-sm-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari keterangan..." value="{{ request('search') }}"></div>
      <div class="col-sm-3"><input type="month" name="month" class="form-control form-control-sm" value="{{ request('month') }}"></div>
      <div class="col-sm-2"><button class="btn btn-sm btn-outline-secondary w-100">Filter</button></div>
    </form>
    <div class="alert alert-info py-2 small">Total: <strong>Rp{{ number_format($total,0,',','.') }}</strong></div>
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Tanggal</th><th>Keterangan</th><th>Kategori</th><th>Cabang</th><th>Jumlah</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($expenses as $e)
        <tr>
          <td>{{ $e->expense_date?->format('d M Y') }}</td>
          <td>{{ $e->description }}</td>
          <td>{{ $e->category ?? '-' }}</td>
          <td>{{ $e->branch?->name ?? '-' }}</td>
          <td>Rp{{ number_format($e->amount,0,',','.') }}</td>
          <td>
            <a href="{{ route('owner.pengeluaran.edit',$e->id) }}" class="btn btn-xs btn-outline-primary"><i class="bx bx-edit"></i></a>
            <form method="POST" action="{{ route('owner.pengeluaran.destroy',$e->id) }}" class="d-inline" onsubmit="return confirm('Hapus pengeluaran ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-xs btn-outline-danger"><i class="bx bx-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pengeluaran.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $expenses->links() }}
  </div>
</div>
@endsection
@push('styles')<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
