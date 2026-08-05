@extends('layouts.app')
@section('title','Riwayat Booking')
@section('page-title','Riwayat Booking')
@section('content')

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
  <div>
    <h4 class="mb-0">Riwayat Booking</h4>
    <p class="page-sub mb-0">Daftar semua booking si kecil.</p>
  </div>
  <a href="{{ route('parent.booking.create') }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Buat Booking
  </a>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>Kode</th>
            <th>Tanggal</th>
            <th>Anak</th>
            <th>Layanan</th>
            <th>Terapis</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings as $b)
          <tr>
            <td><span class="font-monospace small">{{ $b->booking_code }}</span></td>
            <td>{{ $b->scheduled_at?->format('d M Y H:i') ?? '-' }}</td>
            <td>{{ $b->child?->name ?? '-' }}</td>
            <td>{{ $b->service?->name ?? '-' }}</td>
            <td>{{ $b->therapist?->name ?? '-' }}</td>
            <td>
              <span class="badge bg-{{ match($b->status) {
                'CONFIRMED'=>'success','REQUESTED'=>'warning','CANCELLED'=>'danger','COMPLETED'=>'info',default=>'secondary'
              } }}">{{ $b->status }}</span>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted py-3">Belum ada booking.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($bookings->hasPages())
  <div class="card-footer">{{ $bookings->links() }}</div>
  @endif
</div>

@endsection
