@extends("layouts.app")
@section("title","Pendapatan")
@section("page-title","Pendapatan Saya")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Pendapatan</span>
    <form method="GET" class="d-flex gap-2">
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
    <div class="alert alert-success py-2 small mb-3">Total Honor: <strong>Rp{{ number_format($total,0,",",".") }}</strong></div>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead class="table-light"><tr><th>Tanggal</th><th>Layanan</th><th>Harga</th></tr></thead>
        <tbody>
        @forelse($bookings as $b)
        <tr>
          <td>{{ $b->scheduled_date?->format("d M Y") }}</td>
          <td>{{ $b->service?->name }}</td>
          <td>Rp{{ number_format($b->service?->price??0,0,",",".") }}</td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
