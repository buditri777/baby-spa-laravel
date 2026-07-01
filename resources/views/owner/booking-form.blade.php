@extends('layouts.app')
@section('title', isset($booking) ? 'Edit Booking' : 'Buat Booking')
@section('page-title', isset($booking) ? 'Edit Booking' : 'Buat Booking')
@section('content')
<div class="card shadow-sm" style="max-width:700px">
  <div class="card-header bg-white"><span class="fw-semibold">{{ isset($booking) ? 'Edit Booking' : 'Buat Booking' }}</span></div>
  <div class="card-body">
    @if(isset($booking))
      <form method="POST" action="{{ route('owner.booking.update',$booking->id) }}">
        @csrf @method('PUT')
    @else
      <form method="POST" action="{{ route('owner.booking.store') }}">
        @csrf
    @endif
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Anak</label>
          <select name="child_id" class="form-select" required>
            <option value="">-- Pilih Anak --</option>
            @foreach($children ?? [] as $c)
              <option value="{{ $c->id }}" @selected(isset($booking) && $booking->child_id===$c->id)>{{ $c->name }} ({{ $c->parent?->name }})</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Layanan</label>
          <select name="service_id" class="form-select" required>
            <option value="">-- Pilih Layanan --</option>
            @foreach($services ?? [] as $s)
              <option value="{{ $s->id }}" @selected(isset($booking) && $booking->service_id===$s->id)>{{ $s->name }} — Rp{{ number_format($s->price,0,',','.') }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Terapis</label>
          <select name="therapist_id" class="form-select">
            <option value="">-- Pilih Terapis --</option>
            @foreach($therapists ?? [] as $t)
              <option value="{{ $t->id }}" @selected(isset($booking) && $booking->therapist_id===$t->id)>{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Cabang</label>
          <select name="branch_id" class="form-select" required>
            <option value="">-- Pilih Cabang --</option>
            @foreach($branches ?? [] as $br)
              <option value="{{ $br->id }}" @selected(isset($booking) && $booking->branch_id===$br->id)>{{ $br->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tanggal</label>
          <input type="date" name="scheduled_date" class="form-control" value="{{ isset($booking) ? $booking->scheduled_date?->format('Y-m-d') : '' }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jam</label>
          <input type="time" name="scheduled_time" class="form-control" value="{{ $booking->scheduled_time ?? '' }}" required>
        </div>
        @if(isset($booking))
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            @foreach(['CONFIRMED','IN_PROGRESS','COMPLETED','CANCELLED','NO_SHOW'] as $s)
              <option value="{{ $s }}" @selected($booking->status===$s)>{{ $s }}</option>
            @endforeach
          </select>
        </div>
        @endif
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_homecare" value="1" id="isHomecare" @checked(isset($booking) && $booking->is_homecare)>
            <label class="form-check-label" for="isHomecare">Layanan Homecare</label>
          </div>
        </div>
        <div class="col-12">
          <label class="form-label">Catatan</label>
          <textarea name="notes" class="form-control" rows="2">{{ $booking->notes ?? '' }}</textarea>
        </div>
      </div>
      <div class="mt-3 d-flex gap-2">
        <button class="btn btn-pink">Simpan</button>
        <a href="{{ route('owner.booking.index') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
@push('styles')<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
