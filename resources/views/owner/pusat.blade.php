@extends("layouts.app")
@section("title","Dasbor Pusat")
@section("page-title","Dasbor Pusat")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Dasbor Pusat</h4>
    <p class="page-sub">Ringkasan performa seluruh cabang.</p>
  </div>
  <form method="GET" class="d-flex gap-2 align-items-center">
    <input type="number" name="year" class="form-control form-control-sm" value="{{ $year }}" style="width:80px">
    <select name="month" class="form-select form-select-sm" style="width:130px">
      @for($m=1;$m<=12;$m++)
        <option value="{{ $m }}" @selected($month==$m)>{{ DateTime::createFromFormat("!m",$m)->format("F") }}</option>
      @endfor
    </select>
    <button class="btn btn-sm btn-outline-secondary">
      <span class="iconify me-1" data-icon="tabler:filter"></span>Filter
    </button>
  </form>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-md-2">
    <div class="stat-card green">
      <div class="stat-label">Pendapatan</div>
      <div class="stat-value" style="font-size:1.1rem">Rp{{ number_format($totalRevenue,0,",",".") }}</div>
    </div>
  </div>
  <div class="col-6 col-md-2">
    <div class="stat-card brand">
      <div class="stat-label">Total Booking</div>
      <div class="stat-value">{{ $totalBookings }}</div>
    </div>
  </div>
  <div class="col-6 col-md-2">
    <div class="stat-card" style="background:linear-gradient(135deg,#dc3545 0%,#a71d2a 100%)">
      <div class="stat-label">Pengeluaran</div>
      <div class="stat-value" style="font-size:1.1rem">Rp{{ number_format($totalExpense,0,",",".") }}</div>
    </div>
  </div>
  <div class="col-6 col-md-2">
    <div class="stat-card purple">
      <div class="stat-label">Laba Bersih</div>
      <div class="stat-value" style="font-size:1.1rem">Rp{{ number_format($totalNet,0,",",".") }}</div>
    </div>
  </div>
  <div class="col-6 col-md-2">
    <div class="stat-card teal">
      <div class="stat-label">Terapis Aktif</div>
      <div class="stat-value">{{ $therapistCount }}</div>
    </div>
  </div>
  <div class="col-6 col-md-2">
    <div class="stat-card" style="background:linear-gradient(135deg,#fd7e14 0%,#d35400 100%)">
      <div class="stat-label">Total Pasien</div>
      <div class="stat-value">{{ $patientCount }}</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <span class="iconify me-2 text-primary" data-icon="tabler:building-store"></span>Performa Per Cabang
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Cabang</th><th>Booking</th><th>Pendapatan</th><th>Pengeluaran</th><th>Laba</th></tr>
      </thead>
      <tbody>
      @foreach($stats as $s)
      <tr>
        <td class="fw-semibold">{{ $s["branch"]->name }}</td>
        <td><span class="badge badge-confirmed">{{ $s["bookings"] }}</span></td>
        <td class="text-success fw-semibold">Rp{{ number_format($s["revenue"],0,",",".") }}</td>
        <td class="text-muted">Rp{{ number_format($s["expense"],0,",",".") }}</td>
        <td class="{{ $s["net"]>=0 ? "text-success" : "text-danger" }} fw-bold">
          Rp{{ number_format($s["net"],0,",",".") }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
