@extends("layouts.app")
@section("title","Laporan")
@section("page-title","Laporan")
@section("content")
<ul class="nav nav-tabs mb-3">
  @foreach(["pendapatan"=>"Pendapatan","advanced"=>"Lanjutan","pembukuan"=>"Pembukuan","pajak"=>"Pajak","referral"=>"Referral"] as $key=>$label)
  <li class="nav-item">
    <a class="nav-link @if($tab===$key) active @endif" href="{{ route("owner.laporan.$key") }}">{{ $label }}</a>
  </li>
  @endforeach
</ul>

@if($tab==="pendapatan")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Laporan Pendapatan</span>
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
    <div class="row g-3 mb-3">
      <div class="col-sm-4"><div class="stat-card bg-success"><div class="small">Total Pendapatan</div><div class="fs-5 fw-bold">Rp{{ number_format($total,0,",",".") }}</div></div></div>
      @foreach($byMethod as $method=>$amount)
      <div class="col-sm-4"><div class="stat-card" style="background:#e83e8c"><div class="small">{{ $method }}</div><div class="fs-5 fw-bold">Rp{{ number_format($amount,0,",",".") }}</div></div></div>
      @endforeach
    </div>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead class="table-light"><tr><th>Tanggal</th><th>Layanan</th><th>Metode</th><th>Jumlah</th></tr></thead>
        <tbody>
        @forelse($payments as $p)
        <tr>
          <td>{{ $p->paid_at?->format("d M Y") }}</td>
          <td>{{ $p->booking?->service?->name }}</td>
          <td>{{ $p->payment_method }}</td>
          <td>Rp{{ number_format($p->amount,0,",",".") }}</td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@elseif($tab==="pembukuan")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Laporan Pembukuan {{ $year }}/{{ $month }}</div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-sm-4"><div class="stat-card bg-success"><div class="small">Pendapatan</div><div class="fs-5 fw-bold">Rp{{ number_format($income,0,",",".") }}</div></div></div>
      <div class="col-sm-4"><div class="stat-card bg-danger"><div class="small">Pengeluaran</div><div class="fs-5 fw-bold">Rp{{ number_format($expense,0,",",".") }}</div></div></div>
      <div class="col-sm-4"><div class="stat-card" style="background:{{ $net>=0?"#0d6efd":"#dc3545" }}"><div class="small">Laba Bersih</div><div class="fs-5 fw-bold">Rp{{ number_format($net,0,",",".") }}</div></div></div>
    </div>
  </div>
</div>

@elseif($tab==="pajak")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Laporan Pajak {{ $year }}</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm">
        <thead class="table-light"><tr><th>Bulan</th><th>Omzet</th></tr></thead>
        <tbody>
        @foreach($byMonth as $m=>$amount)
        <tr><td>{{ DateTime::createFromFormat("!m",$m)->format("F") }}</td><td>Rp{{ number_format($amount,0,",",".") }}</td></tr>
        @endforeach
        </tbody>
        <tfoot class="table-light"><tr><td class="fw-semibold">Total</td><td><strong>Rp{{ number_format($total,0,",",".") }}</strong></td></tr></tfoot>
      </table>
    </div>
  </div>
</div>

@elseif($tab==="referral")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Laporan Referral {{ $year }}/{{ $month }}</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm">
        <thead class="table-light"><tr><th>Sumber</th><th>Jumlah</th></tr></thead>
        <tbody>
        @forelse($data as $row)
        <tr><td>{{ $row->referral_source ?? "Tidak diisi" }}</td><td>{{ $row->total }}</td></tr>
        @empty
        <tr><td colspan="2" class="text-center text-muted py-3">Belum ada data.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@elseif($tab==="advanced")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Laporan Lanjutan {{ $year }}/{{ $month }}</div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-6">
        <h6 class="fw-semibold">Per Layanan</h6>
        <table class="table table-sm"><thead class="table-light"><tr><th>Layanan</th><th>Total</th></tr></thead><tbody>
        @foreach($byService as $name=>$amt)
        <tr><td>{{ $name }}</td><td>Rp{{ number_format($amt,0,",",".") }}</td></tr>
        @endforeach
        </tbody></table>
      </div>
      <div class="col-md-6">
        <h6 class="fw-semibold">Per Terapis</h6>
        <table class="table table-sm"><thead class="table-light"><tr><th>Terapis</th><th>Total</th></tr></thead><tbody>
        @foreach($byTherapist as $name=>$amt)
        <tr><td>{{ $name }}</td><td>Rp{{ number_format($amt,0,",",".") }}</td></tr>
        @endforeach
        </tbody></table>
      </div>
    </div>
  </div>
</div>
@endif
@endsection
