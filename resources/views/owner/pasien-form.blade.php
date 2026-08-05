@extends('layouts.app')
@section('title','Detail Pasien')
@section('page-title','Detail Pasien')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>{{ $child->name }}</h4>
    <p class="page-sub">Profil anak & riwayat sesi.</p>
  </div>
  <a href="{{ route('owner.pasien') }}" class="btn btn-sm btn-outline-secondary">
    <span class="iconify me-1" data-icon="tabler:arrow-left"></span> Kembali
  </a>
</div>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:baby-carriage"></span>Profil Anak
      </div>
      <div class="card-body">
        <div class="small mb-1"><span class="text-muted">Gender:</span>
          <strong class="ms-1">{{ $child->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</strong>
        </div>
        <div class="small mb-1"><span class="text-muted">Tgl Lahir:</span>
          <strong class="ms-1">{{ $child->birth_date?->format('d M Y') }}</strong>
        </div>
        @if($child->allergies)
        <div class="small mb-1"><span class="text-muted">Alergi:</span>
          <span class="ms-1">{{ $child->allergies }}</span>
        </div>
        @endif
        @if($child->notes)
        <div class="small mb-1"><span class="text-muted">Catatan:</span>
          <span class="ms-1">{{ $child->notes }}</span>
        </div>
        @endif
      </div>
    </div>
    <div class="card mt-3">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:user"></span>Orang Tua
      </div>
      <div class="card-body">
        <div class="small mb-1"><span class="text-muted">Nama:</span>
          <strong class="ms-1">{{ $child->parent?->name }}</strong>
        </div>
        <div class="small mb-1"><span class="text-muted">HP:</span>
          <span class="ms-1">{{ $child->parent?->phone }}</span>
        </div>
        <div class="small mb-0"><span class="text-muted">Wilayah:</span>
          <span class="ms-1">{{ implode(', ', array_filter([$child->parent?->village, $child->parent?->district, $child->parent?->city, $child->parent?->province])) ?: '—' }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card mb-4">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:history"></span>Riwayat Booking
      </div>
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead><tr><th>Tanggal</th><th>Layanan</th><th>Terapis</th><th>Status</th></tr></thead>
          <tbody>
          @forelse($child->bookings as $b)
          @php
            $map = ['COMPLETED'=>['Selesai','badge-completed'],'CANCELLED'=>['Dibatalkan','badge-cancelled'],'CONFIRMED'=>['Terjadwal','badge-confirmed'],'IN_PROGRESS'=>['Berlangsung','badge-pending'],'NO_SHOW'=>['Tidak Hadir','badge-noshow']];
            [$stLabel,$stClass] = $map[$b->status] ?? [$b->status,'badge-pending'];
          @endphp
          <tr>
            <td class="text-muted small">{{ $b->scheduled_date?->format('d M Y') }}</td>
            <td>{{ $b->service?->name }}</td>
            <td class="text-muted">{{ $b->therapist?->name ?? '—' }}</td>
            <td><span class="badge {{ $stClass }}">{{ $stLabel }}</span></td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted py-4">Belum ada booking.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Growth records --}}
    @if(isset($growth) && $growth->count())
    <div class="card">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:chart-line"></span>Data Pertumbuhan
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Tanggal</th><th>BB (kg)</th><th>TB (cm)</th><th>LK (cm)</th></tr></thead>
          <tbody>
          @foreach($growth as $g)
          <tr>
            <td class="text-muted small">{{ \Carbon\Carbon::parse($g->measured_at)->format('d M Y') }}</td>
            <td>{{ $g->weight_kg ?? '—' }}</td>
            <td>{{ $g->height_cm ?? '—' }}</td>
            <td>{{ $g->head_circ_cm ?? '—' }}</td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
