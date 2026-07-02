@extends("layouts.app")
@section("title","Instagram DM")
@section("page-title","Instagram DM & AI CS")
@section("content")
<div class="row g-3">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Konfigurasi Repliz</div>
      <div class="card-body">
        <p class="small text-muted">Integrasi Instagram DM via Repliz dikelola dari sisi server. Pastikan env <code>REPLIZ_*</code> sudah diisi.</p>
        <div class="alert alert-info small py-2">
          <strong>Status:</strong> Konfigurasi aktif jika env Repliz tersedia.<br>
          Webhook endpoint: <code>/api/repliz/webhook</code>
        </div>
        <a href="{{ route("owner.reservasi-ig") }}" class="btn btn-sm btn-outline-primary w-100 mt-2"><i class="bx bx-calendar"></i> Lihat Reservasi IG</a>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Inbox DM</div>
      <div class="card-body">
        <p class="text-muted small">Inbox Instagram DM dikelola melalui dashboard Repliz secara langsung.</p>
        <a href="https://app.repliz.io" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bx bx-link-external"></i> Buka Repliz Dashboard</a>
      </div>
    </div>
  </div>
</div>
@endsection
