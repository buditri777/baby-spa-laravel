@extends('layouts.app')
@section('title','Penggajian')
@section('page-title','Penggajian')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Periode Penggajian</h4>
    <p class="page-sub">Kelola penggajian terapis per periode.</p>
  </div>
  <a href="{{ route('owner.penggajian.create') }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Generate Periode
  </a>
</div>

<div class="card">
  <div class="card-header">
    <form class="row g-2 align-items-center" method="GET">
      <div class="col-sm-3">
        <input type="number" name="year" class="form-control form-control-sm"
               placeholder="Tahun" value="{{ $year }}">
      </div>
      <div class="col-sm-3">
        <select name="month" class="form-select form-select-sm">
          <option value="">Semua Bulan</option>
          @for($m=1;$m<=12;$m++)
            <option value="{{ $m }}" @selected($month==$m)>
              {{ DateTime::createFromFormat('!m',$m)->format('F') }}
            </option>
          @endfor
        </select>
      </div>
      <div class="col-sm-2">
        <button class="btn btn-sm btn-outline-secondary w-100">
          <span class="iconify me-1" data-icon="tabler:filter"></span>Filter
        </button>
      </div>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Cabang</th>
          <th>Periode</th>
          <th>Terapis</th>
          <th>Total Gaji</th>
          <th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($periods as $p)
      <tr>
        <td class="fw-semibold">{{ $p->branch?->name ?? '—' }}</td>
        <td>{{ DateTime::createFromFormat('!m',$p->month)->format('F') }} {{ $p->year }}</td>
        <td>
          <span class="badge badge-confirmed">{{ $p->payslips->count() }} terapis</span>
        </td>
        <td class="fw-semibold">Rp{{ number_format($p->payslips->sum('net_salary'),0,',','.') }}</td>
        <td>
          <span class="badge {{ $p->status==='FINALIZED' ? 'badge-completed' : 'badge-pending' }}">
            {{ $p->status==='FINALIZED' ? 'Final' : 'Draft' }}
          </span>
        </td>
        <td class="text-end">
          <a href="{{ route('owner.penggajian.show',$p->id) }}" class="btn btn-xs btn-outline-primary">
            <span class="iconify" data-icon="tabler:eye"></span>
          </a>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:cash"></span>
        Belum ada periode penggajian.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($periods->hasPages())
  <div class="card-body pt-0 pb-3">{{ $periods->links() }}</div>
  @endif
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
