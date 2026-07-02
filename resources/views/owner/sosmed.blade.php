@extends("layouts.app")
@section("title","Sosial Media")
@section("page-title","Pengaturan Sosial Media")
@section("content")
<div class="card shadow-sm" style="max-width:600px">
  <div class="card-header bg-white fw-semibold">Link Sosial Media</div>
  <div class="card-body">
    <form method="POST" action="/owner/sosmed">@csrf @method("PUT")
    <div class="row g-3">
      @foreach(["instagram"=>"Instagram","facebook"=>"Facebook","tiktok"=>"TikTok","youtube"=>"YouTube","whatsapp"=>"WhatsApp"] as $key=>$label)
      <div class="col-12">
        <label class="form-label"><i class="bx bxl-{{ $key }}"></i> {{ $label }}</label>
        <input type="text" name="{{ $key }}_url" class="form-control" value="{{ $settings[$key."_url"] ?? "" }}" placeholder="https://...">
      </div>
      @endforeach
    </div>
    <div class="mt-3"><button class="btn btn-pink">Simpan</button></div>
    </form>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
