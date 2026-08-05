@extends('layouts.app')
@section('title','Pengeluaran')
@section('page-title','Pengeluaran')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Daftar Pengeluaran</h4>
    <p class="page-sub">Catat dan pantau pengeluaran operasional.</p>
  </div>
  <a href="{{ route('owner.pengeluaran.create') }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Tambah
  </a>
</div>

<div class="card">
  <div class="card-header">
    <form class="row g-2 align-items-center" method="GET">
      <div class="col-sm-4">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Cari keterangan…" value="{{ request('search') }}">
      </div>
      <div class="col-sm-3">
        <input type="month" name="month" class="form-control form-control-sm"
               value="{{ request('month') }}">
      </div>
      <div class="col-sm-2">
        <button class="btn btn-sm btn-outline-secondary w-100">
          <span class="iconify me-1" data-icon="tabler:filter"></span>Filter
        </button>
      </div>
      <div class="col-sm-3 text-end">
        <span class="badge badge-completed px-3 py-2" style="font-size:.82rem">
          Total: Rp{{ number_format($total,0,',','.') }}
        </span>
      </div>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Tanggal</th><th>Keterangan</th><th>Kategori</th>
          <th>Cabang</th><th>Jumlah</th><th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($expenses as $e)
      <tr>
        <td class="text-muted small">{{ $e->expense_date?->format('d M Y') }}</td>
        <td class="fw-semibold">{{ $e->description }}</td>
        <td><span class="badge badge-pending">{{ $e->category ?? '—' }}</span></td>
        <td class="text-muted">{{ $e->branch?->name ?? '—' }}</td>
        <td class="fw-semibold">Rp{{ number_format($e->amount,0,',','.') }}</td>
        <td class="text-end">
          <a href="{{ route('owner.pengeluaran.edit',$e->id) }}" class="btn btn-xs btn-outline-primary">
            <span class="iconify" data-icon="tabler:edit"></span>
          </a>
          <form method="POST" action="{{ route('owner.pengeluaran.destroy',$e->id) }}" class="d-inline"
                onsubmit="return confirm('Hapus pengeluaran ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-xs btn-outline-danger">
              <span class="iconify" data-icon="tabler:trash"></span>
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:receipt-off"></span>
        Belum ada pengeluaran.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($expenses->hasPages())
  <div class="card-body pt-0 pb-3">{{ $expenses->links() }}</div>
  @endif
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
