@extends("layouts.app")
@section("title","Booking Berhasil")
@section("page-title","Booking Berhasil")
@section("content")

<div class="card mx-auto" style="max-width:520px">
  <div class="card-body text-center py-5">
    <span class="iconify text-success d-block mb-3" data-icon="tabler:circle-check" style="font-size:4rem"></span>
    <h5 class="fw-bold mb-1">Booking Berhasil!</h5>
    <p class="text-muted small mb-3">Kode booking Anda:</p>
    <div class="alert alert-success py-2 mb-4">
      <strong class="fs-5">{{ $booking->booking_code }}</strong>
    </div>
    <div class="text-start small p-3 rounded mb-4" style="background:var(--surface-2)">
      <div class="mb-1"><span class="text-muted">Anak:</span> <strong>{{ $booking->child?->name }}</strong></div>
      <div class="mb-1"><span class="text-muted">Layanan:</span> <strong>{{ $booking->service?->name }}</strong></div>
      <div class="mb-1"><span class="text-muted">Terapis:</span> <strong>{{ $booking->therapist?->name ?? 'Belum ditentukan' }}</strong></div>
      <div class="mb-1"><span class="text-muted">Tanggal:</span> <strong>{{ $booking->scheduled_date?->format('d M Y') }} {{ $booking->scheduled_time }}</strong></div>
      @if($booking->is_homecare)
      <div class="mt-2"><span class="badge badge-pending">Homecare</span></div>
      @endif
    </div>
    <div class="d-flex gap-2 justify-content-center">
      <a href="{{ route('jadwal') }}" class="btn btn-sm btn-pink">
        <span class="iconify me-1" data-icon="tabler:calendar"></span> Lihat Jadwal
      </a>
      <a href="{{ route('layanan') }}" class="btn btn-sm btn-outline-secondary">Booking Lagi</a>
    </div>
  </div>
</div>
@endsection
