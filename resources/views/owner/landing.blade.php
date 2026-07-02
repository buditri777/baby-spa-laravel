@extends("layouts.app")
@section("title","Pengaturan Landing")
@section("page-title","Pengaturan Halaman Landing")
@section("content")
<div class="card shadow-sm" style="max-width:700px">
  <div class="card-header bg-white fw-semibold">Konten Landing Page</div>
  <div class="card-body">
    <form method="POST" action="{{ route("owner.landing") }}">@csrf @method("PUT")
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Email Kontak</label>
        <input type="email" name="landing_email" class="form-control" value="{{ $settings["landing_email"] ?? "" }}"></div>
      <div class="col-md-6"><label class="form-label">Nomor CS</label>
        <input type="text" name="landing_cs_phone" class="form-control" value="{{ $settings["landing_cs_phone"] ?? "" }}" placeholder="628xxxxxxxxxx"></div>
      <div class="col-12"><label class="form-label">Layanan Unggulan (1 per baris)</label>
        <textarea name="landing_services" class="form-control" rows="4">{{ $settings["landing_services"] ?? "" }}</textarea></div>
      <div class="col-12"><label class="form-label">FAQ (format: Q|A, satu per baris)</label>
        <textarea name="landing_faq" class="form-control" rows="5" placeholder="Apa itu baby spa?|Baby spa adalah...">{{ $settings["landing_faq"] ?? "" }}</textarea></div>
      <div class="col-12"><label class="form-label">Kebijakan Privasi (Markdown)</label>
        <textarea name="privacy_policy" class="form-control" rows="8">{{ $settings["privacy_policy"] ?? "" }}</textarea></div>
    </div>
    <div class="mt-3"><button class="btn btn-pink">Simpan</button></div>
    </form>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
