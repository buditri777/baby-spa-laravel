@extends('layouts.app')
@section('title','Booking')
@section('page-title','Daftar Booking')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Daftar Booking</h4>
    <p class="page-sub">Kelola seluruh booking sesi.</p>
  </div>
  <a href="{{ route('owner.booking.create') }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Buat Booking
  </a>
</div>

<div class="card">
  <div class="card-header">
    <form class="row g-2 align-items-center" method="GET">
      <div class="col-sm-4">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Cari nama anak…" value="{{ request('search') }}">
      </div>
      <div class="col-sm-3">
        <input type="date" name="date" class="form-control form-control-sm"
               value="{{ request('date') }}">
      </div>
      <div class="col-sm-3">
        <select name="status" class="form-select form-select-sm">
          <option value="">Semua Status</option>
          @foreach(['CONFIRMED'=>'Terjadwal','IN_PROGRESS'=>'Berlangsung','COMPLETED'=>'Selesai','CANCELLED'=>'Dibatalkan','NO_SHOW'=>'Tidak Hadir'] as $val => $label)
            <option value="{{ $val }}" @selected(request('status')===$val)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-2">
        <button class="btn btn-sm btn-outline-secondary w-100">
          <span class="iconify me-1" data-icon="tabler:filter"></span>Filter
        </button>
      </div>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Kode</th><th>Anak</th><th>Layanan</th><th>Terapis</th>
          <th>Tanggal</th><th>Status</th><th>HC</th><th class="text-end">Aksi</th>
        </tr>
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
        <td class="text-muted">{{ $b->therapist?->name ?? '—' }}</td>
        <td class="text-muted small">{{ $b->scheduled_date?->format('d M Y') }} {{ $b->scheduled_time }}</td>
        <td><span class="badge {{ $stClass }}">{{ $stLabel }}</span></td>
        <td>
          @if($b->is_homecare)
            <span class="badge badge-pending">HC</span>
          @else
            <span class="text-muted">—</span>
          @endif
        </td>
        <td class="text-end">
          <a href="{{ route('owner.booking.edit',$b->id) }}" class="btn btn-xs btn-outline-primary">
            <span class="iconify" data-icon="tabler:edit"></span>
          </a>
          <form method="POST" action="{{ route('owner.booking.destroy',$b->id) }}" class="d-inline"
                onsubmit="return confirm('Batalkan booking ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-xs btn-outline-danger">
              <span class="iconify" data-icon="tabler:trash"></span>
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="8" class="text-center text-muted py-5">
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
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
