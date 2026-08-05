@extends("layouts.app")
@section("title","Kalender")
@section("page-title","Kalender Booking")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Kalender Booking</h4>
    <p class="page-sub">Tampilan mingguan booking 7 hari ke depan.</p>
  </div>
  <form method="GET" class="d-flex gap-2 align-items-center flex-wrap">
    <input type="date" name="start" class="form-control form-control-sm" value="{{ $start }}">
    @if(count($branches)>1)
    <select name="branch_id" class="form-select form-select-sm" style="width:160px">
      <option value="">Semua Cabang</option>
      @foreach($branches as $br)
        <option value="{{ $br->id }}" @selected(request('branch_id')===$br->id)>{{ $br->name }}</option>
      @endforeach
    </select>
    @endif
    <button class="btn btn-sm btn-outline-secondary">
      <span class="iconify me-1" data-icon="tabler:filter"></span>Lihat
    </button>
  </form>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered mb-0" style="min-width:700px">
        <thead>
          <tr>
            @foreach($dates as $d)
            <th class="text-center small py-3" style="background:var(--surface-2);border-color:var(--border)">
              {{ \Carbon\Carbon::parse($d)->locale('id')->isoFormat('ddd D MMM') }}
              <div><span class="badge badge-confirmed">{{ ($bookings[$d] ?? collect())->count() }}</span></div>
            </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          <tr class="align-top">
            @foreach($dates as $d)
            <td class="p-2" style="min-height:120px;vertical-align:top">
              @foreach($bookings[$d] ?? [] as $b)
              @php
                $color = match($b->status) {
                  'COMPLETED' => 'badge-completed',
                  'CANCELLED' => 'badge-cancelled',
                  'NO_SHOW' => 'badge-noshow',
                  'IN_PROGRESS' => 'badge-pending',
                  default => 'badge-confirmed'
                };
              @endphp
              <div class="mb-1 p-2 rounded" style="background:var(--surface-2);border-left:3px solid var(--brand);font-size:.78rem">
                <div class="fw-semibold">{{ $b->scheduled_time }} {{ $b->child?->name }}</div>
                <div class="text-muted">{{ $b->service?->name }}</div>
                <span class="badge {{ $color }} mt-1" style="font-size:.65rem">
                  {{ $b->status }}
                </span>
              </div>
              @endforeach
            </td>
            @endforeach
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
