@extends("layouts.app")
@section("title","Buat Booking")
@section("page-title","Buat Booking")
@section("content")
<div class="card shadow-sm" style="max-width:640px">
  <div class="card-header bg-white fw-semibold">Buat Booking</div>
  <div class="card-body">
    <form method="POST" action="{{ route('booking.store') }}">@csrf
    <div class="row g-3">
      @if($service)
      <div class="col-12">
        <div class="alert alert-info py-2 small mb-0">
          <strong>{{ $service->name }}</strong> — Rp{{ number_format($service->price,0,',','.') }} · {{ $service->duration_min }} mnt
        </div>
      </div>
      @endif
      <input type="hidden" name="service_id" value="{{ $serviceId }}">
      <div class="col-12"><label class="form-label">Anak</label>
        <select name="child_id" class="form-select" required>
          <option value="">-- Pilih Anak --</option>
          @foreach($children as $c)
            <option value="{{ $c->id }}" @selected($childId===$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      @if(!$serviceId)
      <div class="col-12"><label class="form-label">Layanan</label>
        <select name="service_id" class="form-select" required>
          <option value="">-- Pilih Layanan --</option>
          @foreach($services as $s)
            <option value="{{ $s->id }}">{{ $s->name }} — Rp{{ number_format($s->price,0,',','.') }}</option>
          @endforeach
        </select>
      </div>
      @endif
      <div class="col-md-6"><label class="form-label">Terapis (opsional)</label>
        <select name="therapist_id" class="form-select">
          <option value="">-- Tanpa Pilihan --</option>
          @foreach($therapists as $t)
            <option value="{{ $t->id }}">{{ $t->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">Tanggal</label>
        <input type="date" name="scheduled_date" class="form-control" min="{{ date('Y-m-d') }}" required></div>
      <div class="col-md-6"><label class="form-label">Jam</label>
        <input type="time" name="scheduled_time" class="form-control" required></div>
      <div class="col-12">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="is_homecare" value="1" id="isHomecare">
          <label class="form-check-label" for="isHomecare">Layanan Homecare</label>
        </div>
      </div>
      <div class="col-12"><label class="form-label">Catatan</label>
        <textarea name="notes" class="form-control" rows="2"></textarea></div>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-pink">Konfirmasi Booking</button>
      <a href="{{ route('layanan') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
    </form>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
