@extends("layouts.app")
@section("title","Pengaturan Landing")
@section("page-title","Pengaturan Halaman Landing")
@section("content")

<div class="page-header">
  <h4>Konten Landing Page</h4>
  <p class="page-sub">Atur konten yang tampil di halaman publik.</p>
</div>

<div class="card" style="max-width:700px">
  <div class="card-body">
    <form method="POST" action="{{ route("owner.landing") }}">
      @csrf @method("PUT")
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Email Kontak</label>
          <input type="email" name="landing_email" class="form-control" value="{{ $settings["landing_email"] ?? "" }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Nomor CS</label>
          <input type="text" name="landing_cs_phone" class="form-control" value="{{ $settings["landing_cs_phone"] ?? "" }}" placeholder="628xxxxxxxxxx">
        </div>
        <div class="col-12">
          <label class="form-label">Layanan Unggulan <span class="text-muted fw-normal">(satu per baris)</span></label>
          <textarea name="landing_services" class="form-control" rows="4">{{ $settings["landing_services"] ?? "" }}</textarea>
        </div>
        <div class="col-12">
          <label class="form-label">FAQ <span class="text-muted fw-normal">(format: Pertanyaan|Jawaban, satu per baris)</span></label>
          <textarea name="landing_faq" class="form-control" rows="5" placeholder="Apa itu baby spa?|Baby spa adalah...">{{ $settings["landing_faq"] ?? "" }}</textarea>
        </div>
        <div class="col-12">
          <label class="form-label">Kebijakan Privasi <span class="text-muted fw-normal">(Markdown)</span></label>
          <textarea name="privacy_policy" class="form-control" rows="8">{{ $settings["privacy_policy"] ?? "" }}</textarea>
        </div>
      </div>
      <div class="mt-4">
        <button class="btn btn-pink">
          <span class="iconify me-1" data-icon="tabler:device-floppy"></span> Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
