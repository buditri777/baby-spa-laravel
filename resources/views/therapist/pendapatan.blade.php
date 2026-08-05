@extends("layouts.app")
@section("title","Pendapatan")
@section("page-title","Pendapatan Saya")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Pendapatan Saya</h4>
    <p class="page-sub">Rincian honor sesi per bulan.</p>
  </div>
  <form method="GET" class="d-flex gap-2 align-items-center">
    <input type="number" name="year" class="form-control form-control-sm" value="{{ $year }}" style="width:80px">
    <select name="month" class="form-select form-select-sm" style="width:130px">
      @for($m=1;$m<=12;$m++)
        <option value="{{ $m }}" @selected($month==$m)>{{ DateTime::createFromFormat("!m",$m)->format("F") }}</option>
      @endfor
    </select>
    <button class="btn btn-sm btn-outline-secondary">
      <span class="iconify" data-icon="tabler:filter"></span>
    </button>
  </form>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-4">
    <div class="stat-card green">
      <div class="stat-label">Total Honor</div>
      <div class="stat-value">Rp{{ number_format($total,0,",",".") }}</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Tanggal</th><th>Layanan</th><th>Harga Layanan</th></tr>
      </thead>
      <tbody>
      @forelse($bookings as $b)
      <tr>
        <td class="text-muted small">{{ $b->scheduled_date?->format("d M Y") }}</td>
        <td>{{ $b->service?->name }}</td>
        <td class="fw-semibold">Rp{{ number_format($b->service?->price??0,0,",",".") }}</td>
      </tr>
      @empty
      <tr><td colspan="3" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:coin-off"></span>
        Belum ada data honor.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($bookings->hasPages())
  <div class="card-body pt-0 pb-3">{{ $bookings->links() }}</div>
  @endif
</div>
@endsection
