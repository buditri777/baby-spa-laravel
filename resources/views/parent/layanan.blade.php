@extends("layouts.app")
@section("title","Katalog Layanan")
@section("page-title","Katalog Layanan")
@section("content")
@if($children->isEmpty())
<div class="alert alert-warning">Tambahkan data anak terlebih dahulu sebelum booking. <a href="{{ route('anak.create') }}">Tambah Anak</a></div>
@endif
<div class="row g-3">
@forelse($services as $s)
<div class="col-sm-6 col-md-4">
  <div class="card shadow-sm h-100">
    @if($s->photo_url)<img src="{{ $s->photo_url }}" class="card-img-top" style="height:160px;object-fit:cover" alt="{{ $s->name }}">@endif
    <div class="card-body">
      <h6 class="fw-semibold">{{ $s->name }}</h6>
      <p class="small text-muted mb-1">{{ $s->category }} · {{ $s->duration_min }} mnt</p>
      @if($s->age_min_months || $s->age_max_months)
      <p class="small text-muted mb-1">Usia: {{ $s->age_min_months ?? 0 }}–{{ $s->age_max_months ?? '∞' }} bulan</p>
      @endif
      <p class="fw-semibold text-pink mb-2">Rp{{ number_format($s->price,0,',','.') }}</p>
      @if($s->description)<p class="small mb-2">{{ Str::limit($s->description,80) }}</p>@endif
      @if(!$children->isEmpty())
      <div class="d-flex gap-2 align-items-center">
        <select class="form-select form-select-sm child-select" id="child-{{ $s->id }}">
          <option value="">-- Pilih Anak --</option>
          @foreach($children as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
          @endforeach
        </select>
        <a href="#" class="btn btn-sm btn-pink book-btn" data-service="{{ $s->id }}">Booking</a>
      </div>
      @endif
    </div>
  </div>
</div>
@empty
<div class="col-12"><p class="text-muted text-center py-4">Belum ada layanan tersedia.</p></div>
@endforelse
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.text-pink{color:#e83e8c;}</style>@endpush
@push("scripts")
<script>
document.querySelectorAll('.book-btn').forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    const svcId   = btn.dataset.service;
    const childId = document.getElementById('child-'+svcId).value;
    if (!childId) { alert('Pilih anak terlebih dahulu.'); return; }
    window.location = '{{ url("/booking/baru") }}?serviceId='+svcId+'&childId='+childId;
  });
});
</script>
@endpush
