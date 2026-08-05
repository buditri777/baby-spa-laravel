@extends("layouts.app")
@section("title","Buat Booking")
@section("page-title","Buat Booking")
@section("content")

<div class="page-header">
  <h4>Buat Booking</h4>
  <p class="page-sub">Jadwalkan sesi untuk si kecil.</p>
</div>

<div class="card" style="max-width:640px">
  <div class="card-body">
    <form method="POST" action="{{ route('booking.store') }}">
      @csrf
      <div class="row g-3">
        @if($service)
        <div class="col-12">
          <div class="p-3 rounded d-flex align-items-center gap-3" style="background:var(--brand-muted);border:1px solid var(--brand-light)">
            <span class="iconify text-primary fs-4" data-icon="tabler:massage"></span>
            <div>
              <div class="fw-semibold">{{ $service->name }}</div>
              <div class="small text-muted">Rp{{ number_format($service->price,0,',','.') }} · {{ $service->duration_min }} mnt</div>
            </div>
          </div>
        </div>
        @endif
        <input type="hidden" name="service_id" value="{{ $serviceId }}">

        <div class="col-12">
          <label class="form-label">Anak</label>
          <select name="child_id" class="form-select" required>
            <option value="">— Pilih Anak —</option>
            @foreach($children as $c)
              <option value="{{ $c->id }}" @selected($childId===$c->id)>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>

        @if(!$serviceId)
        <div class="col-12">
          <label class="form-label">Layanan</label>
          <select name="service_id" class="form-select" required>
            <option value="">— Pilih Layanan —</option>
            @foreach($services as $s)
              <option value="{{ $s->id }}">{{ $s->name }} — Rp{{ number_format($s->price,0,',','.') }}</option>
            @endforeach
          </select>
        </div>
        @endif

        <div class="col-md-6">
          <label class="form-label">Terapis <span class="text-muted fw-normal">(opsional)</span></label>
          <select name="therapist_id" class="form-select">
            <option value="">— Tanpa Pilihan —</option>
            @foreach($therapists as $t)
              <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tanggal</label>
          <input type="date" name="scheduled_date" class="form-control" min="{{ date('Y-m-d') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jam</label>
          <input type="time" name="scheduled_time" class="form-control" required>
        </div>
        <div class="col-12">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_homecare" value="1" id="isHomecare">
            <label class="form-check-label" for="isHomecare">Layanan Homecare</label>
          </div>
        </div>
        <div class="col-12">
          <label class="form-label">Catatan</label>
          <textarea name="notes" class="form-control" rows="2"></textarea>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-pink">
          <span class="iconify me-1" data-icon="tabler:calendar-plus"></span> Buat Booking
        </button>
        <a href="{{ route('layanan') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
