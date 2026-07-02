@extends("layouts.app")
@section("title","Kalender")
@section("page-title","Kalender Booking")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Kalender 7 Hari</span>
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
      <button class="btn btn-sm btn-outline-secondary">Lihat</button>
    </form>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered table-sm mb-0" style="min-width:700px">
        <thead class="table-light">
          <tr>
            @foreach($dates as $d)
            <th class="text-center small py-2">
              {{ \Carbon\Carbon::parse($d)->locale('id')->isoFormat('ddd D MMM') }}
              <div class="badge bg-primary">{{ ($bookings[$d] ?? collect())->count() }}</div>
            </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          <tr class="align-top">
            @foreach($dates as $d)
            <td class="p-1">
              @foreach($bookings[$d] ?? [] as $b)
              @php
                $color = match($b->status) {
                  'COMPLETED' => 'success',
                  'CANCELLED' => 'danger',
                  'NO_SHOW'   => 'secondary',
                  'IN_PROGRESS' => 'warning',
                  default      => 'primary'
                };
              @endphp
              <div class="rounded p-1 mb-1 small bg-{{ $color }} bg-opacity-10 border border-{{ $color }}">
                <div class="fw-semibold text-{{ $color }}">{{ $b->scheduled_time }}</div>
                <div>{{ $b->child?->name }}</div>
                <div class="text-muted" style="font-size:.7rem">{{ Str::limit($b->service?->name,18) }}</div>
                @if($b->is_homecare)<span class="badge bg-info" style="font-size:.65rem">HC</span>@endif
              </div>
              @endforeach
            </td>
            @endforeach
          </tr>
        </tbody>
      </table>
    </div>
    <div class="p-3 d-flex gap-3 flex-wrap small">
      @foreach(['primary'=>'Terjadwal','warning'=>'Proses','success'=>'Selesai','danger'=>'Batal','secondary'=>'Tidak Hadir'] as $c=>$l)
        <span><span class="badge bg-{{ $c }}">&#9679;</span> {{ $l }}</span>
      @endforeach
    </div>
  </div>
</div>
@endsection
