@extends("layouts.app")
@section("title","Instagram DM")
@section("page-title","Instagram DM & AI CS")
@section("content")

<div class="page-header">
  <h4>Instagram DM & AI CS</h4>
  <p class="page-sub">Integrasi Instagram DM via Repliz.</p>
</div>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:settings"></span>Konfigurasi Repliz
      </div>
      <div class="card-body">
        <p class="small text-muted mb-3">
          Integrasi Instagram DM via Repliz dikelola dari sisi server. Pastikan env <code>REPLIZ_*</code> sudah diisi.
        </p>
        <div class="alert alert-info py-2 small mb-3">
          <strong>Status:</strong> Konfigurasi aktif jika env Repliz tersedia.<br>
          Webhook: <code>/api/repliz/webhook</code>
        </div>
        <a href="{{ route("owner.reservasi-ig") }}" class="btn btn-sm btn-outline-primary w-100">
          <span class="iconify me-1" data-icon="tabler:calendar"></span> Lihat Reservasi IG
        </a>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card h-100">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:message"></span>Inbox DM
      </div>
      <div class="card-body">
        <p class="text-muted small mb-3">Inbox Instagram DM dikelola melalui dashboard Repliz secara langsung.</p>
        <a href="https://app.repliz.io" target="_blank" class="btn btn-sm btn-outline-secondary">
          <span class="iconify me-1" data-icon="tabler:external-link"></span> Buka Repliz Dashboard
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
