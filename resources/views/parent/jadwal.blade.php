@extends("layouts.app")
@section("title","Jadwal Booking")
@section("page-title","Jadwal Booking Saya")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Riwayat & Jadwal Booking</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Kode</th><th>Anak</th><th>Layanan</th><th>Tanggal</th><th>Status</th><th>HC</th></tr></thead>
        <tbody>
        @forelse($bookings as $b)
        <tr>
          <td><code>{{ $b->booking_code }}</code></td>
          <td>{{ $b->child?->name }}</td>
          <td>{{ $b->service?->name }}</td>
          <td>{{ $b->scheduled_date?->format('d M Y') }} {{ $b->scheduled_time }}</td>
          <td>
            @php $colors=['CONFIRMED'=>'primary','IN_PROGRESS'=>'warning','COMPLETED'=>'success','CANCELLED'=>'danger','NO_SHOW'=>'secondary'] @endphp
            <span class="badge bg-{{ $colors[$b->status] ?? 'secondary' }}">{{ $b->status }}</span>
          </td>
          <td>@if($b->is_homecare)<span class="badge bg-info">HC</span>@endif</td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada booking.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $bookings->links() }}
  </div>
</div>
@endsection
