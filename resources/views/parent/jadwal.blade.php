@extends("layouts.app")
@section("title","Jadwal Booking")
@section("page-title","Jadwal Booking Saya")
@section("content")

<div class="page-header">
  <h4>Jadwal & Riwayat Booking</h4>
  <p class="page-sub">Semua booking sesi si kecil.</p>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Kode</th><th>Anak</th><th>Layanan</th><th>Tanggal</th><th>Status</th><th>HC</th></tr>
      </thead>
      <tbody>
      @forelse($bookings as $b)
      @php
        $map = ['CONFIRMED'=>['Terjadwal','badge-confirmed'],'IN_PROGRESS'=>['Berlangsung','badge-pending'],'COMPLETED'=>['Selesai','badge-completed'],'CANCELLED'=>['Dibatalkan','badge-cancelled'],'NO_SHOW'=>['Tidak Hadir','badge-noshow']];
        [$stLabel,$stClass] = $map[$b->status] ?? [$b->status,'badge-pending'];
      @endphp
      <tr>
        <td><code class="small">{{ $b->booking_code }}</code></td>
        <td class="fw-semibold">{{ $b->child?->name }}</td>
        <td class="text-muted">{{ $b->service?->name }}</td>
        <td class="text-muted small">{{ $b->scheduled_date?->format('d M Y') }} {{ $b->scheduled_time }}</td>
        <td><span class="badge {{ $stClass }}">{{ $stLabel }}</span></td>
        <td>
          @if($b->is_homecare)
            <span class="badge badge-pending">HC</span>
          @else
            <span class="text-muted">—</span>
          @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:calendar-off"></span>
        Belum ada booking.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($bookings->hasPages())
  <div class="card-body pt-0 pb-3">{{ $bookings->links() }}</div>
  @endif
</div>
@endsection
