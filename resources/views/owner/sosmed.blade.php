@extends("layouts.app")
@section("title","Sosial Media")
@section("page-title","Pengaturan Sosial Media")
@section("content")

<div class="page-header">
  <h4>Link Sosial Media</h4>
  <p class="page-sub">Atur tautan sosial media untuk landing page.</p>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body">
    <form method="POST" action="/owner/sosmed">
      @csrf @method("PUT")
      <div class="row g-3">
        @foreach(["instagram"=>"tabler:brand-instagram","facebook"=>"tabler:brand-facebook","tiktok"=>"tabler:brand-tiktok","youtube"=>"tabler:brand-youtube","whatsapp"=>"tabler:brand-whatsapp"] as $key => $icon)
        <div class="col-12">
          <label class="form-label">
            <span class="iconify me-1 text-primary" data-icon="{{ $icon }}"></span>
            {{ ucfirst($key) }}
          </label>
          <input type="url" name="{{ $key }}_url" class="form-control"
                 value="{{ $settings[$key."_url"] ?? "" }}" placeholder="https://...">
        </div>
        @endforeach
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
