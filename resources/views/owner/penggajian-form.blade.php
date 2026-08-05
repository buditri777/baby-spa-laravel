@extends('layouts.app')
@section('title', isset($period) ? 'Detail Penggajian' : 'Generate Periode')
@section('page-title', isset($period) ? 'Detail Penggajian' : 'Generate Periode Penggajian')
@section('content')

@if(!isset($period))
<div class="page-header">
  <h4>Generate Periode Penggajian</h4>
  <p class="page-sub">Buat periode penggajian baru untuk cabang tertentu.</p>
</div>
<div class="card" style="max-width:500px">
  <div class="card-body">
    <form method="POST" action="{{ route('owner.penggajian.store') }}">
      @csrf
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">Cabang</label>
          <select name="branch_id" class="form-select" required>
            <option value="">— Pilih Cabang —</option>
            @foreach($branches as $br)
              <option value="{{ $br->id }}">{{ $br->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tahun</label>
          <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Bulan</label>
          <select name="month" class="form-select" required>
            @for($m=1;$m<=12;$m++)
              <option value="{{ $m }}" @selected($m==date('n'))>
                {{ DateTime::createFromFormat('!m',$m)->format('F') }}
              </option>
            @endfor
          </select>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-pink">
          <span class="iconify me-1" data-icon="tabler:calculator"></span> Generate
        </button>
        <a href="{{ route('owner.penggajian.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>

@else
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>{{ $period->branch?->name }} — {{ DateTime::createFromFormat('!m',$period->month)->format('F') }} {{ $period->year }}</h4>
    <p class="page-sub">Rincian slip gaji terapis periode ini.</p>
  </div>
  <span class="badge {{ $period->status==='FINALIZED' ? 'badge-completed' : 'badge-pending' }}" style="font-size:.85rem;padding:.45em .9em">
    {{ $period->status==='FINALIZED' ? '✅ Final' : '📝 Draft' }}
  </span>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span><span class="iconify me-2 text-primary" data-icon="tabler:cash"></span>Slip Gaji Terapis</span>
    <div>
      @if($period->status !== 'FINALIZED')
      <form method="POST" action="{{ route('owner.penggajian.update',$period->id) }}" class="d-inline">
        @csrf @method('PUT')
        <input type="hidden" name="action" value="finalize">
        <button class="btn btn-sm btn-success" onclick="return confirm('Finalisasi penggajian ini?')">
          <span class="iconify me-1" data-icon="tabler:lock"></span> Finalisasi
        </button>
      </form>
      @else
      <form method="POST" action="{{ route('owner.penggajian.update',$period->id) }}" class="d-inline">
        @csrf @method('PUT')
        <input type="hidden" name="action" value="reopen">
        <button class="btn btn-sm btn-warning" onclick="return confirm('Buka kembali periode ini?')">
          <span class="iconify me-1" data-icon="tabler:lock-open"></span> Buka Kembali
        </button>
      </form>
      @endif
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Terapis</th>
          <th>Sesi</th>
          <th>Gaji Pokok</th>
          <th>Fee Sesi</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
      @forelse($period->payslips as $ps)
      <tr>
        <td class="fw-semibold">{{ $ps->therapist?->name }}</td>
        <td><span class="badge badge-confirmed">{{ $ps->session_count }}</span></td>
        <td class="text-muted">Rp{{ number_format($ps->base_salary,0,',','.') }}</td>
        <td class="text-muted">Rp{{ number_format($ps->session_fee,0,',','.') }}</td>
        <td class="fw-bold text-success">Rp{{ number_format($ps->net_salary,0,',','.') }}</td>
        <td>
          <span class="badge {{ $ps->status==='FINALIZED' ? 'badge-completed' : 'badge-pending' }}">
            {{ $ps->status==='FINALIZED' ? 'Final' : 'Draft' }}
          </span>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center text-muted py-4">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:cash-off"></span>
        Belum ada slip gaji.
      </td></tr>
      @endforelse
      </tbody>
      @if($period->payslips->count())
      <tfoot>
        <tr style="background:var(--surface-2)">
          <td colspan="4" class="fw-semibold text-end py-3">Total:</td>
          <td class="fw-bold text-success py-3">Rp{{ number_format($period->payslips->sum('net_salary'),0,',','.') }}</td>
          <td></td>
        </tr>
      </tfoot>
      @endif
    </table>
  </div>
  <div class="card-body">
    <a href="{{ route('owner.penggajian.index') }}" class="btn btn-outline-secondary">
      <span class="iconify me-1" data-icon="tabler:arrow-left"></span> Kembali
    </a>
  </div>
</div>
@endif
@endsection
