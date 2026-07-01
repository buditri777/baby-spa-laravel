@extends('layouts.app')
@section('title','Penggajian')
@section('page-title','Penggajian')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Periode Penggajian</span>
    <a href="{{ route('owner.penggajian.create') }}" class="btn btn-sm btn-pink"><i class="bx bx-plus"></i> Generate Periode</a>
  </div>
  <div class="card-body">
    <form class="row g-2 mb-3" method="GET">
      <div class="col-sm-3"><input type="number" name="year" class="form-control form-control-sm" placeholder="Tahun" value="{{ $year }}"></div>
      <div class="col-sm-3">
        <select name="month" class="form-select form-select-sm">
          <option value="">Semua Bulan</option>
          @for($m=1;$m<=12;$m++)
            <option value="{{ $m }}" @selected($month==$m)>{{ DateTime::createFromFormat('!m',$m)->format('F') }}</option>
          @endfor
        </select>
      </div>
      <div class="col-sm-2"><button class="btn btn-sm btn-outline-secondary w-100">Filter</button></div>
    </form>
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Cabang</th><th>Bulan/Tahun</th><th>Terapis</th><th>Total Gaji</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($periods as $p)
        <tr>
          <td>{{ $p->branch?->name ?? '-' }}</td>
          <td>{{ DateTime::createFromFormat('!m',$p->month)->format('F') }} {{ $p->year }}</td>
          <td>{{ $p->payslips->count() }} terapis</td>
          <td>Rp{{ number_format($p->payslips->sum('net_salary'),0,',','.') }}</td>
          <td><span class="badge bg-{{ $p->status==='FINALIZED'?'success':'warning' }}">{{ $p->status }}</span></td>
          <td><a href="{{ route('owner.penggajian.show',$p->id) }}" class="btn btn-xs btn-outline-primary"><i class="bx bx-show"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada periode penggajian.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $periods->links() }}
  </div>
</div>
@endsection
@push('styles')<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
