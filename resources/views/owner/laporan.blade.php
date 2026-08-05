@extends("layouts.app")
@section("title","Laporan")
@section("page-title","Laporan")
@section("content")

<div class="page-header">
  <h4>Laporan</h4>
  <p class="page-sub">Analisis pendapatan, pembukuan, dan data operasional.</p>
</div>

<ul class="nav nav-tabs mb-4">
  @foreach(["pendapatan"=>"Pendapatan","advanced"=>"Lanjutan","pembukuan"=>"Pembukuan","pajak"=>"Pajak","referral"=>"Referral"] as $key=>$label)
  <li class="nav-item">
    <a class="nav-link @if($tab===$key) active @endif" href="{{ route("owner.laporan.$key") }}">{{ $label }}</a>
  </li>
  @endforeach
</ul>

@if($tab==="pendapatan")
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span><span class="iconify me-2 text-primary" data-icon="tabler:chart-bar"></span>Laporan Pendapatan</span>
    <form class="d-flex gap-2 align-items-center" method="GET">
      <input type="number" name="year" class="form-control form-control-sm" value="{{ $year }}" style="width:80px">
      <select name="month" class="form-select form-select-sm" style="width:130px">
        @for($m=1;$m<=12;$m++)
          <option value="{{ $m }}" @selected($month==$m)>{{ DateTime::createFromFormat("!m",$m)->format("F") }}</option>
        @endfor
      </select>
      <button class="btn btn-sm btn-outline-secondary"><span class="iconify" data-icon="tabler:filter"></span></button>
    </form>
  </div>
  <div class="card-body">
    <div class="row g-3 mb-4">
      <div class="col-sm-4">
        <div class="stat-card green">
          <div class="stat-label">Total Pendapatan</div>
          <div class="stat-value">Rp{{ number_format($total,0,",",".") }}</div>
        </div>
      </div>
      @foreach($byMethod as $method=>$amount)
      <div class="col-sm-4">
        <div class="stat-card brand">
          <div class="stat-label">{{ $method }}</div>
          <div class="stat-value" style="font-size:1.15rem">Rp{{ number_format($amount,0,",",".") }}</div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Tanggal</th><th>Layanan</th><th>Metode</th><th>Jumlah</th></tr></thead>
        <tbody>
        @forelse($payments as $p)
        <tr>
          <td class="text-muted small">{{ $p->paid_at?->format("d M Y") }}</td>
          <td>{{ $p->booking?->service?->name }}</td>
          <td class="text-muted">{{ $p->payment_method }}</td>
          <td class="fw-semibold">Rp{{ number_format($p->amount,0,",",".") }}</td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center text-muted py-5">
          <span class="iconify fs-3 d-block mb-2" data-icon="tabler:chart-bar-off"></span>
          Belum ada data pembayaran.
        </td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@elseif($tab==="pembukuan")
<div class="row g-3">
  <div class="col-sm-4">
    <div class="stat-card green">
      <div class="stat-label">Pendapatan</div>
      <div class="stat-value">Rp{{ number_format($income,0,",",".") }}</div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="stat-card" style="background:linear-gradient(135deg,#dc3545 0%,#a71d2a 100%)">
      <div class="stat-label">Pengeluaran</div>
      <div class="stat-value">Rp{{ number_format($expense,0,",",".") }}</div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="stat-card {{ $net>=0 ? 'teal' : 'brand' }}">
      <div class="stat-label">Laba Bersih</div>
      <div class="stat-value">Rp{{ number_format($net,0,",",".") }}</div>
    </div>
  </div>
</div>

@elseif($tab==="pajak")
<div class="card">
  <div class="card-header">
    <span class="iconify me-2 text-primary" data-icon="tabler:receipt-tax"></span>Laporan Pajak {{ $year }}
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Bulan</th><th>Omzet</th></tr></thead>
      <tbody>
      @foreach($byMonth as $m=>$amount)
      <tr>
        <td>{{ DateTime::createFromFormat("!m",$m)->format("F") }}</td>
        <td class="fw-semibold">Rp{{ number_format($amount,0,",",".") }}</td>
      </tr>
      @endforeach
      </tbody>
      <tfoot>
        <tr style="background:var(--surface-2)">
          <td class="fw-semibold py-3">Total</td>
          <td class="fw-bold py-3">Rp{{ number_format($total,0,",",".") }}</td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

@elseif($tab==="referral")
<div class="card">
  <div class="card-header">
    <span class="iconify me-2 text-primary" data-icon="tabler:share"></span>Laporan Referral {{ $year }}/{{ $month }}
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Sumber</th><th>Jumlah Booking</th></tr></thead>
      <tbody>
      @forelse($data as $row)
      <tr>
        <td class="fw-semibold">{{ $row->referral_source ?? "Tidak diisi" }}</td>
        <td><span class="badge badge-confirmed">{{ $row->total }}</span></td>
      </tr>
      @empty
      <tr><td colspan="2" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:share-off"></span>
        Belum ada data referral.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>

@endif
@endsection
