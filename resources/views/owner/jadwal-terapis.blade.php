@extends("layouts.app")
@section("title","Jadwal Terapis")
@section("page-title","Jadwal Terapis Aktif")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Jadwal Terapis</span>
    <form method="GET" class="d-flex gap-2">
      <input type="date" name="date" class="form-control form-control-sm" value="{{ $date }}">
      <button class="btn btn-sm btn-outline-secondary">Filter</button>
    </form>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Nama</th><th>Cabang</th><th>Aktif Hari Ini</th><th>Toggle</th></tr></thead>
        <tbody>
        @forelse($therapists as $t)
        @php $active = $t->dayActives->where('date',$date)->first(); @endphp
        <tr>
          <td>{{ $t->user?->name }}</td>
          <td>{{ $t->branch?->name ?? '-' }}</td>
          <td>
            @if($active && $active->is_active)
              <span class="badge bg-success">Aktif</span>
            @else
              <span class="badge bg-secondary">Tidak Aktif</span>
            @endif
          </td>
          <td>
            <form method="POST" action="{{ route('owner.jadwal-terapis') }}">@csrf
              <input type="hidden" name="therapist_id" value="{{ $t->id }}">
              <input type="hidden" name="date" value="{{ $date }}">
              <input type="hidden" name="is_active" value="{{ ($active && $active->is_active) ? '0' : '1' }}">
              <button class="btn btn-xs btn-outline-{{ ($active && $active->is_active)?'danger':'success' }}">
                {{ ($active && $active->is_active) ? 'Nonaktifkan' : 'Aktifkan' }}
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada terapis.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
@push("styles")<style>.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
