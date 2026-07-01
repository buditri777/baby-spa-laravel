@extends('layouts.app')
@section('title','Detail Pasien')
@section('page-title','Detail Pasien')
@section('content')
<div class="row g-3">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h6 class="fw-semibold mb-3">Profil Anak</h6>
        <p class="mb-1"><strong>Nama:</strong> {{ $child->name }}</p>
        <p class="mb-1"><strong>Gender:</strong> {{ $child->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
        <p class="mb-1"><strong>Tgl Lahir:</strong> {{ $child->birth_date?->format('d M Y') }}</p>
        @if($child->allergies)<p class="mb-1"><strong>Alergi:</strong> {{ $child->allergies }}</p>@endif
        @if($child->notes)<p class="mb-1"><strong>Catatan:</strong> {{ $child->notes }}</p>@endif
        <hr>
        <h6 class="fw-semibold mb-2">Orang Tua</h6>
        <p class="mb-1"><strong>Nama:</strong> {{ $child->parent?->name }}</p>
        <p class="mb-1"><strong>HP:</strong> {{ $child->parent?->phone }}</p>
        <p class="mb-0"><strong>Wilayah:</strong> {{ implode(', ', array_filter([$child->parent?->village, $child->parent?->district, $child->parent?->city, $child->parent?->province])) ?: '-' }}</p>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card shadow-sm mb-3">
      <div class="card-header bg-white fw-semibold">Riwayat Booking</div>
      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead class="table-light"><tr><th>Tanggal</th><th>Layanan</th><th>Terapis</th><th>Status</th></tr></thead>
          <tbody>
          @forelse($child->bookings ?? [] as $b)
          <tr>
            <td>{{ $b->scheduled_date?->format('d M Y') }}</td>
            <td>{{ $b->service?->name }}</td>
            <td>{{ $b->therapist?->name ?? '-' }}</td>
            <td><span class="badge bg-{{ $b->status==='COMPLETED'?'success':($b->status==='CANCELLED'?'danger':'primary') }}">{{ $b->status }}</span></td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted py-3">Belum ada booking.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Pertumbuhan</div>
      <div class="table-responsive">
        <table class="table table-sm mb-0">
          <thead class="table-light"><tr><th>Tanggal</th><th>BB (kg)</th><th>TB (cm)</th><th>LK (cm)</th></tr></thead>
          <tbody>
          @forelse($child->growthMeasurements ?? [] as $g)
          <tr><td>{{ $g->measured_at?->format('d M Y') }}</td><td>{{ $g->weight_kg }}</td><td>{{ $g->height_cm }}</td><td>{{ $g->head_circ_cm ?? '-' }}</td></tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="mt-3"><a href="{{ route('owner.pasien.index') }}" class="btn btn-outline-secondary"><i class="bx bx-arrow-back"></i> Kembali</a></div>
@endsection
