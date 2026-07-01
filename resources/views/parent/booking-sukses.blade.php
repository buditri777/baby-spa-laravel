@extends("layouts.app")
@section("title","Booking Berhasil")
@section("page-title","Booking Berhasil")
@section("content")
<div class="card shadow-sm" style="max-width:520px">
  <div class="card-body text-center py-5">
    <div class="mb-3"><i class="bx bx-check-circle text-success" style="font-size:4rem"></i></div>
    <h5 class="fw-semibold mb-1">Booking Berhasil!</h5>
    <p class="text-muted small mb-3">Kode booking Anda:</p>
    <div class="alert alert-success py-2"><strong class="fs-5">{{ $booking->booking_code }}</strong></div>
    <div class="text-start small mt-3">
      <p class="mb-1"><strong>Anak:</strong> {{ $booking->child?->name }}</p>
      <p class="mb-1"><strong>Layanan:</strong> {{ $booking->service?->name }}</p>
      <p class="mb-1"><strong>Terapis:</strong> {{ $booking->therapist?->name ?? 'Belum ditentukan' }}</p>
      <p class="mb-1"><strong>Tanggal:</strong> {{ $booking->scheduled_date?->format('d M Y') }} {{ $booking->scheduled_time }}</p>
      @if($booking->is_homecare)<p class="mb-1"><span class="badge bg-info">Homecare</span></p>@endif
    </div>
    <div class="mt-4 d-flex gap-2 justify-content-center">
      <a href="{{ route('jadwal') }}" class="btn btn-pink btn-sm"><i class="bx bx-calendar"></i> Lihat Jadwal</a>
      <a href="{{ route('layanan') }}" class="btn btn-outline-secondary btn-sm">Booking Lagi</a>
    </div>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
