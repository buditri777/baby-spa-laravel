@extends("layouts.app")
@section("title","Walk-in")
@section("page-title","Walk-in / Pesan di Tempat")
@section("content")

<div class="page-header">
  <h4>Buat Booking Walk-in</h4>
  <p class="page-sub">Booking langsung untuk pasien yang datang ke klinik.</p>
</div>

<div class="card" style="max-width:700px">
  <div class="card-body">
    <form method="POST" action="{{ route("owner.walk-in.store") }}">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Anak</label>
          <select name="child_id" class="form-select" required>
            <option value="">— Pilih Anak —</option>
            @foreach($children ?? [] as $c)
              <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->parent?->name }})</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Layanan</label>
          <select name="service_id" class="form-select" required>
            <option value="">— Pilih Layanan —</option>
            @foreach($services ?? [] as $s)
              <option value="{{ $s->id }}">{{ $s->name }} — Rp{{ number_format($s->price,0,",",".") }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Terapis</label>
          <select name="therapist_id" class="form-select">
            <option value="">— Tanpa Terapis —</option>
            @foreach($therapists ?? [] as $t)
              <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Cabang</label>
          <select name="branch_id" class="form-select" required>
            <option value="">— Pilih Cabang —</option>
            @foreach($branches ?? [] as $br)
              <option value="{{ $br->id }}">{{ $br->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tanggal</label>
          <input type="date" name="scheduled_date" class="form-control" value="{{ date("Y-m-d") }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jam</label>
          <input type="time" name="scheduled_time" class="form-control" value="{{ date("H:i") }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">Catatan</label>
          <textarea name="notes" class="form-control" rows="2"></textarea>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-pink">
          <span class="iconify me-1" data-icon="tabler:shopping-cart-plus"></span> Buat Booking
        </button>
        <a href="{{ route("owner.booking.index") }}" class="btn btn-outline-secondary">Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection
