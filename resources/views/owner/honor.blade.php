@extends('layouts.app')
@section('title','Honor Terapis')
@section('page-title','Honor Terapis')
@section('content')

<div class="page-header">
  <h4>Honor Terapis</h4>
  <p class="page-sub">Rincian rate honor per layanan dan riwayat honor bulanan.</p>
</div>

{{-- Rate per Layanan --}}
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span><span class="iconify me-2 text-primary" data-icon="tabler:coin"></span>Rate Honor per Layanan</span>
    <a href="{{ route('owner.layanan.index') }}" class="btn btn-sm btn-outline-primary">
      <span class="iconify me-1" data-icon="tabler:edit"></span> Edit Rate
    </a>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>Layanan</th>
          <th>Tipe</th>
          <th>Nilai</th>
          <th>HC Base</th>
          <th>HC / km</th>
        </tr>
      </thead>
      <tbody>
      @foreach($services as $s)
      @php $r = $serviceRates[$s->id] ?? null; @endphp
      <tr>
        <td class="fw-semibold">{{ $s->name }}</td>
        <td>
          @if($r)
            <span class="badge badge-confirmed">{{ $r->fee_type === 'FLAT' ? 'Flat' : 'Persen' }}</span>
          @else <span class="text-muted">—</span> @endif
        </td>
        <td>
          @if($r)
            <span class="fw-semibold text-success">
              {{ $r->fee_type === 'FLAT' ? 'Rp'.number_format($r->fee_value,0,',','.') : $r->fee_value.'%' }}
            </span>
          @else <span class="text-muted">—</span> @endif
        </td>
        <td class="text-muted">
          {{ $r ? 'Rp'.number_format($r->homecare_base_fee,0,',','.') : '—' }}
        </td>
        <td class="text-muted">
          {{ $r ? 'Rp'.number_format($r->homecare_per_km_fee,0,',','.') : '—' }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Riwayat Honor --}}
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span><span class="iconify me-2 text-primary" data-icon="tabler:history"></span>Riwayat Honor</span>
    <form class="d-flex gap-2 align-items-center" method="GET">
      <input type="number" name="year" class="form-control form-control-sm" value="{{ $year }}" style="width:80px">
      <select name="month" class="form-select form-select-sm" style="width:130px">
        @for($m=1;$m<=12;$m++)
          <option value="{{ $m }}" @selected($month==$m)>
            {{ DateTime::createFromFormat("!m",$m)->format("F") }}
          </option>
        @endfor
      </select>
      <button class="btn btn-sm btn-outline-secondary">
        <span class="iconify" data-icon="tabler:filter"></span>
      </button>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Terapis</th>
          <th>Layanan</th>
          <th>Harga</th>
          <th>Honor</th>
          <th>HC</th>
        </tr>
      </thead>
      <tbody>
      @php $totalHonor = 0; @endphp
      @forelse($bookings as $b)
      @php
        $rate = $serviceRates[$b->service_id] ?? null;
        $honor = 0;
        if($rate) $honor = $rate->fee_type === "FLAT"
          ? $rate->fee_value
          : ($b->service?->price * $rate->fee_value / 100);
        $totalHonor += $honor;
      @endphp
      <tr>
        <td class="text-muted small">{{ $b->scheduled_date?->format("d M Y") }}</td>
        <td class="fw-semibold">{{ $b->therapist?->name ?? "—" }}</td>
        <td>{{ $b->service?->name }}</td>
        <td class="text-muted">Rp{{ number_format($b->service?->price??0,0,",",".") }}</td>
        <td class="fw-semibold text-success">Rp{{ number_format($honor,0,",",".") }}</td>
        <td>
          @if($b->is_homecare)
            <span class="badge badge-pending">Homecare</span>
          @else
            <span class="text-muted">—</span>
          @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:coin-off"></span>
        Belum ada data honor periode ini.
      </td></tr>
      @endforelse
      </tbody>
      @if($bookings->count())
      <tfoot>
        <tr style="background:var(--surface-2)">
          <td colspan="4" class="fw-semibold text-end py-3">Total Honor:</td>
          <td class="fw-bold text-success py-3">Rp{{ number_format($totalHonor,0,",",".") }}</td>
          <td></td>
        </tr>
      </tfoot>
      @endif
    </table>
  </div>
  @if($bookings->hasPages())
  <div class="card-body pt-0 pb-3">{{ $bookings->links() }}</div>
  @endif
</div>
@endsection
