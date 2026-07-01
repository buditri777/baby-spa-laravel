@extends("layouts.app")
@section("title","Detail Anak")
@section("page-title","Detail Anak")
@section("content")
<div class="row g-3">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h6 class="fw-semibold mb-3">{{ $child->name }}</h6>
        <p class="mb-1 small"><strong>Gender:</strong> {{ $child->gender==='L'?'Laki-laki':'Perempuan' }}</p>
        <p class="mb-1 small"><strong>Tgl Lahir:</strong> {{ $child->birth_date?->format('d M Y') }}</p>
        @if($child->allergies)<p class="mb-1 small"><strong>Alergi:</strong> {{ $child->allergies }}</p>@endif
        @if($child->medical_conditions)<p class="mb-1 small"><strong>Kondisi Medis:</strong> {{ $child->medical_conditions }}</p>@endif
        <div class="mt-3 d-flex gap-2">
          <a href="{{ route('anak.edit',$child->id) }}" class="btn btn-sm btn-outline-primary"><i class="bx bx-edit"></i> Edit</a>
          <a href="{{ route('anak.tumbuh',$child->id) }}" class="btn btn-sm btn-outline-success"><i class="bx bx-line-chart"></i> Tumbuh Kembang</a>
          <a href="{{ route('anak.latihan',$child->id) }}" class="btn btn-sm btn-outline-info"><i class="bx bx-dumbbell"></i> Latihan</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Riwayat Booking</div>
      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead class="table-light"><tr><th>Tanggal</th><th>Layanan</th><th>Status</th></tr></thead>
          <tbody>
          @forelse($child->bookings as $b)
          <tr>
            <td>{{ $b->scheduled_date?->format('d M Y') }}</td>
            <td>{{ $b->service?->name }}</td>
            <td><span class="badge bg-{{ $b->status==='COMPLETED'?'success':($b->status==='CANCELLED'?'danger':'primary') }}">{{ $b->status }}</span></td>
          </tr>
          @empty
          <tr><td colspan="3" class="text-center text-muted py-3">Belum ada booking.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<a href="{{ route('anak.index') }}" class="btn btn-outline-secondary mt-3"><i class="bx bx-arrow-back"></i> Kembali</a>
@endsection
