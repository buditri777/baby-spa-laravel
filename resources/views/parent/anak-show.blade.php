@extends("layouts.app")
@section("title","Detail Anak")
@section("page-title","Detail Anak")
@section("content")

<div class="page-header">
  <h4>{{ $child->name }}</h4>
  <p class="page-sub">Profil dan riwayat sesi.</p>
</div>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <div class="mb-3 p-3 rounded text-center" style="background:var(--brand-muted)">
          <span class="iconify text-primary" data-icon="tabler:baby-carriage" style="font-size:2.5rem"></span>
          <div class="fw-bold mt-2">{{ $child->name }}</div>
        </div>
        <div class="small mb-1">
          <span class="text-muted">Gender:</span>
          <span class="badge {{ $child->gender==='L' ? 'badge-confirmed' : 'badge-pending' }} ms-1">
            {{ $child->gender==='L' ? 'Laki-laki' : 'Perempuan' }}
          </span>
        </div>
        <div class="small mb-1">
          <span class="text-muted">Tgl Lahir:</span>
          <strong class="ms-1">{{ $child->birth_date?->format('d M Y') }}</strong>
        </div>
        @if($child->allergies)
        <div class="small mb-1">
          <span class="text-muted">Alergi:</span>
          <span class="ms-1">{{ $child->allergies }}</span>
        </div>
        @endif
        @if($child->medical_conditions)
        <div class="small mb-1">
          <span class="text-muted">Kondisi Medis:</span>
          <span class="ms-1">{{ $child->medical_conditions }}</span>
        </div>
        @endif
        <div class="mt-3 d-flex flex-wrap gap-2">
          <a href="{{ route('anak.edit',$child->id) }}" class="btn btn-sm btn-outline-primary">
            <span class="iconify me-1" data-icon="tabler:edit"></span> Edit
          </a>
          <a href="{{ route('anak.tumbuh',$child->id) }}" class="btn btn-sm btn-outline-success">
            <span class="iconify me-1" data-icon="tabler:chart-line"></span> Tumbuh
          </a>
          <a href="{{ route('anak.latihan',$child->id) }}" class="btn btn-sm btn-outline-secondary">
            <span class="iconify me-1" data-icon="tabler:barbell"></span> Latihan
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:history"></span>Riwayat Booking
      </div>
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead><tr><th>Tanggal</th><th>Layanan</th><th>Status</th></tr></thead>
          <tbody>
          @forelse($child->bookings as $b)
          @php
            $map = ['COMPLETED'=>['Selesai','badge-completed'],'CANCELLED'=>['Dibatalkan','badge-cancelled'],'CONFIRMED'=>['Terjadwal','badge-confirmed'],'IN_PROGRESS'=>['Berlangsung','badge-pending'],'NO_SHOW'=>['Tidak Hadir','badge-noshow']];
            [$stLabel,$stClass] = $map[$b->status] ?? [$b->status,'badge-pending'];
          @endphp
          <tr>
            <td class="text-muted small">{{ $b->scheduled_date?->format('d M Y') }}</td>
            <td>{{ $b->service?->name }}</td>
            <td><span class="badge {{ $stClass }}">{{ $stLabel }}</span></td>
          </tr>
          @empty
          <tr><td colspan="3" class="text-center text-muted py-4">Belum ada booking.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<a href="{{ route('anak.index') }}" class="btn btn-outline-secondary mt-4">
  <span class="iconify me-1" data-icon="tabler:arrow-left"></span> Kembali
</a>
@endsection
