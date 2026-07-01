@extends('layouts.app')
@section('title','Booking')
@section('page-title','Daftar Booking')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Booking</span>
    <a href="{{ route('owner.booking.create') }}" class="btn btn-sm btn-pink"><i class="bx bx-plus"></i> Buat Booking</a>
  </div>
  <div class="card-body">
    <form class="row g-2 mb-3" method="GET">
      <div class="col-sm-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama anak..." value="{{ request('search') }}"></div>
      <div class="col-sm-3"><input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}"></div>
      <div class="col-sm-3">
        <select name="status" class="form-select form-select-sm">
          <option value="">Semua Status</option>
          @foreach(['CONFIRMED','IN_PROGRESS','COMPLETED','CANCELLED','NO_SHOW'] as $s)
            <option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-2"><button class="btn btn-sm btn-outline-secondary w-100">Filter</button></div>
    </form>
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr>
          <th>Kode</th><th>Anak</th><th>Layanan</th><th>Terapis</th><th>Tanggal</th><th>Status</th><th>HC</th><th>Aksi</th>
        </tr></thead>
        <tbody>
        @forelse($bookings as $b)
        <tr>
          <td><code>{{ $b->booking_code }}</code></td>
          <td>{{ $b->child?->name }}</td>
          <td>{{ $b->service?->name }}</td>
          <td>{{ $b->therapist?->name ?? '-' }}</td>
          <td>{{ $b->scheduled_date?->format('d M Y') }} {{ $b->scheduled_time }}</td>
          <td>
            @php $colors=['CONFIRMED'=>'primary','IN_PROGRESS'=>'warning','COMPLETED'=>'success','CANCELLED'=>'danger','NO_SHOW'=>'secondary'] @endphp
            <span class="badge bg-{{ $colors[$b->status] ?? 'secondary' }}">{{ $b->status }}</span>
          </td>
          <td>@if($b->is_homecare)<span class="badge bg-info">HC</span>@endif</td>
          <td>
            <a href="{{ route('owner.booking.edit',$b->id) }}" class="btn btn-xs btn-outline-primary"><i class="bx bx-edit"></i></a>
            <form method="POST" action="{{ route('owner.booking.destroy',$b->id) }}" class="d-inline" onsubmit="return confirm('Batalkan booking ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-xs btn-outline-danger"><i class="bx bx-x"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-muted py-4">Belum ada booking.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $bookings->links() }}
  </div>
</div>
@endsection
@push('styles')
<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>
@endpush
