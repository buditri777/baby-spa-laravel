@extends('layouts.app')
@section('title', isset($period) ? 'Detail Penggajian' : 'Generate Periode')
@section('page-title', isset($period) ? 'Detail Penggajian' : 'Generate Periode Penggajian')
@section('content')
@if(!isset($period))
<div class="card shadow-sm" style="max-width:500px">
  <div class="card-header bg-white"><span class="fw-semibold">Generate Periode Penggajian</span></div>
  <div class="card-body">
    <form method="POST" action="{{ route('owner.penggajian.store') }}">@csrf
    <div class="row g-3">
      <div class="col-12"><label class="form-label">Cabang</label>
        <select name="branch_id" class="form-select" required>
          <option value="">-- Pilih Cabang --</option>
          @foreach($branches as $br)
            <option value="{{ $br->id }}">{{ $br->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">Tahun</label>
        <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required></div>
      <div class="col-md-6"><label class="form-label">Bulan</label>
        <select name="month" class="form-select" required>
          @for($m=1;$m<=12;$m++)
            <option value="{{ $m }}" @selected($m==date('n'))>{{ DateTime::createFromFormat('!m',$m)->format('F') }}</option>
          @endfor
        </select>
      </div>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-pink">Generate</button>
      <a href="{{ route('owner.penggajian.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@else
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">{{ $period->branch?->name }} — {{ DateTime::createFromFormat('!m',$period->month)->format('F') }} {{ $period->year }}</span>
    <span class="badge bg-{{ $period->status==='FINALIZED'?'success':'warning' }} fs-6">{{ $period->status }}</span>
  </div>
  <div class="card-body">
    @if($period->status !== 'FINALIZED')
    <form method="POST" action="{{ route('owner.penggajian.update',$period->id) }}" class="mb-3">
      @csrf @method('PUT')
      <input type="hidden" name="action" value="finalize">
      <button class="btn btn-success btn-sm" onclick="return confirm('Finalisasi penggajian ini?')"><i class="bx bx-check"></i> Finalisasi</button>
    </form>
    @else
    <form method="POST" action="{{ route('owner.penggajian.update',$period->id) }}" class="mb-3">
      @csrf @method('PUT')
      <input type="hidden" name="action" value="reopen">
      <button class="btn btn-warning btn-sm" onclick="return confirm('Buka kembali periode ini?')"><i class="bx bx-undo"></i> Buka Kembali</button>
    </form>
    @endif
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead class="table-light"><tr><th>Terapis</th><th>Sesi</th><th>Gaji Pokok</th><th>Fee Sesi</th><th>Total</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($period->payslips as $ps)
        <tr>
          <td>{{ $ps->therapist?->name }}</td>
          <td>{{ $ps->session_count }}</td>
          <td>Rp{{ number_format($ps->base_salary,0,',','.') }}</td>
          <td>Rp{{ number_format($ps->session_fee,0,',','.') }}</td>
          <td><strong>Rp{{ number_format($ps->net_salary,0,',','.') }}</strong></td>
          <td><span class="badge bg-{{ $ps->status==='FINALIZED'?'success':'warning' }}">{{ $ps->status }}</span></td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-3">Belum ada slip gaji.</td></tr>
        @endforelse
        </tbody>
        <tfoot class="table-light">
          <tr><td colspan="4" class="fw-semibold text-end">Total:</td>
            <td colspan="2"><strong>Rp{{ number_format($period->payslips->sum('net_salary'),0,',','.') }}</strong></td></tr>
        </tfoot>
      </table>
    </div>
    <a href="{{ route('owner.penggajian.index') }}" class="btn btn-outline-secondary mt-2"><i class="bx bx-arrow-back"></i> Kembali</a>
  </div>
</div>
@endif
@endsection
@push('styles')<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
