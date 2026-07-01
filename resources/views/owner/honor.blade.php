@extends('layouts.app')
@section('title','Honor Terapis')
@section('page-title','Honor Terapis')
@section('content')
<div class="card shadow-sm mb-3">
  <div class="card-header bg-white fw-semibold">Rate Honor per Layanan</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead class="table-light"><tr><th>Layanan</th><th>Tipe</th><th>Nilai</th><th>HC Base</th><th>HC/km</th></tr></thead>
        <tbody>
        @foreach($services as $s)
        <tr>
          <td>{{ $s->name }}</td>
          <td>{{ $serviceRates[$s->id]?->fee_type ?? '-' }}</td>
          <td>{{ isset($serviceRates[$s->id]) ? ($serviceRates[$s->id]->fee_type==='FLAT' ? 'Rp'.number_format($serviceRates[$s->id]->fee_value,0,',','.') : $serviceRates[$s->id]->fee_value.'%') : '-' }}</td>
          <td>{{ isset($serviceRates[$s->id]) ? 'Rp'.number_format($serviceRates[$s->id]->homecare_base_fee,0,',','.') : '-' }}</td>
          <td>{{ isset($serviceRates[$s->id]) ? 'Rp'.number_format($serviceRates[$s->id]->homecare_per_km_fee,0,',','.') : '-' }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <a href="{{ route('owner.layanan.index') }}" class="btn btn-sm btn-outline-primary mt-2"><i class="bx bx-edit"></i> Edit Rate di halaman Layanan</a>
  </div>
</div>
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Riwayat Honor</span>
    <form class="d-flex gap-2" method="GET">
      <input type="number" name="year" class="form-control form-control-sm" value="{{ $year }}" style="width:80px">
      <select name="month" class="form-select form-select-sm" style="width:120px">
        @for($m=1;$m<=12;$m++)
          <option value="{{ $m }}" @selected($month==$m)>{{ DateTime::createFromFormat("!m",$m)->format("F") }}</option>
        @endfor
      </select>
      <button class="btn btn-sm btn-outline-secondary">Filter</button>
    </form>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead class="table-light"><tr><th>Tanggal</th><th>Terapis</th><th>Layanan</th><th>Harga</th><th>Honor</th><th>HC</th></tr></thead>
        <tbody>
        @php $totalHonor=0; @endphp
        @forelse($bookings as $b)
        @php
          $rate = $serviceRates[$b->service_id] ?? null;
          $honor = 0;
          if($rate) $honor = $rate->fee_type==="FLAT" ? $rate->fee_value : ($b->service?->price * $rate->fee_value / 100);
          $totalHonor += $honor;
        @endphp
        <tr>
          <td>{{ $b->scheduled_date?->format("d M Y") }}</td>
          <td>{{ $b->therapist?->name ?? "-" }}</td>
          <td>{{ $b->service?->name }}</td>
          <td>Rp{{ number_format($b->service?->price??0,0,",",".") }}</td>
          <td>Rp{{ number_format($honor,0,",",".") }}</td>
          <td>@if($b->is_homecare)<span class="badge bg-info">HC</span>@endif</td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data honor.</td></tr>
        @endforelse
        </tbody>
        @if($bookings->count())
        <tfoot class="table-light">
          <tr><td colspan="4" class="fw-semibold text-end">Total Honor:</td><td colspan="2"><strong>Rp{{ number_format($totalHonor,0,",",".") }}</strong></td></tr>
        </tfoot>
        @endif
      </table>
    </div>
    {{ $bookings->links() }}
  </div>
</div>
@endsection
