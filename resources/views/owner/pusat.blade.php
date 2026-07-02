@extends("layouts.app")
@section("title","Dasbor Pusat")
@section("page-title","Dasbor Pusat")
@section("content")
<form method="GET" class="row g-2 mb-3">
  <div class="col-auto"><input type="number" name="year" class="form-control form-control-sm" value="{{ $year }}" style="width:80px"></div>
  <div class="col-auto">
    <select name="month" class="form-select form-select-sm" style="width:130px">
      @for($m=1;$m<=12;$m++)
        <option value="{{ $m }}" @selected($month==$m)>{{ DateTime::createFromFormat("!m",$m)->format("F") }}</option>
      @endfor
    </select>
  </div>
  <div class="col-auto"><button class="btn btn-sm btn-outline-secondary">Filter</button></div>
</form>

<div class="row g-3 mb-4">
  <div class="col-6 col-md-3"><div class="stat-card bg-success"><div class="small">Total Pendapatan</div><div class="fw-bold">Rp{{ number_format($totalRevenue,0,",",".") }}</div></div></div>
  <div class="col-6 col-md-3"><div class="stat-card bg-primary"><div class="small">Total Booking</div><div class="fw-bold">{{ $totalBookings }}</div></div></div>
  <div class="col-6 col-md-3"><div class="stat-card bg-danger"><div class="small">Total Pengeluaran</div><div class="fw-bold">Rp{{ number_format($totalExpense,0,",",".") }}</div></div></div>
  <div class="col-6 col-md-3"><div class="stat-card" style="background:#6f42c1"><div class="small">Laba Bersih</div><div class="fw-bold">Rp{{ number_format($totalNet,0,",",".") }}</div></div></div>
  <div class="col-6 col-md-3"><div class="stat-card" style="background:#e83e8c"><div class="small">Terapis Aktif</div><div class="fw-bold">{{ $therapistCount }}</div></div></div>
  <div class="col-6 col-md-3"><div class="stat-card" style="background:#fd7e14"><div class="small">Total Pasien</div><div class="fw-bold">{{ $patientCount }}</div></div></div>
</div>

<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Per Cabang</div>
  <div class="table-responsive">
    <table class="table table-sm align-middle mb-0">
      <thead class="table-light"><tr><th>Cabang</th><th>Booking</th><th>Pendapatan</th><th>Pengeluaran</th><th>Laba</th></tr></thead>
      <tbody>
      @foreach($stats as $s)
      <tr>
        <td>{{ $s["branch"]->name }}</td>
        <td>{{ $s["bookings"] }}</td>
        <td>Rp{{ number_format($s["revenue"],0,",",".") }}</td>
        <td>Rp{{ number_format($s["expense"],0,",",".") }}</td>
        <td class="{{ $s["net"]>=0?"text-success":"text-danger" }}"><strong>Rp{{ number_format($s["net"],0,",",".") }}</strong></td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
