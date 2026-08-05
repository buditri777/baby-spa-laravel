@extends("layouts.app")
@section("title","Jadwal Terapis")
@section("page-title","Jadwal Terapis Aktif")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Jadwal Terapis</h4>
    <p class="page-sub">Toggle ketersediaan terapis per hari.</p>
  </div>
  <form method="GET" class="d-flex gap-2 align-items-center">
    <input type="date" name="date" class="form-control form-control-sm" value="{{ $date }}">
    <button class="btn btn-sm btn-outline-secondary">
      <span class="iconify me-1" data-icon="tabler:filter"></span>Filter
    </button>
  </form>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Nama Terapis</th><th>Cabang</th><th>Status Hari Ini</th><th class="text-end">Toggle</th></tr>
      </thead>
      <tbody>
      @forelse($therapists as $t)
      @php $active = $dayActives[$t->id] ?? null; @endphp
      <tr>
        <td class="fw-semibold">{{ $t->name }}</td>
        <td class="text-muted">{{ $t->branch?->name ?? "—" }}</td>
        <td>
          @if($active && $active->is_active)
            <span class="badge badge-active">
              <span class="iconify me-1" data-icon="tabler:check" style="font-size:.7rem"></span>Aktif
            </span>
          @else
            <span class="badge badge-inactive">
              <span class="iconify me-1" data-icon="tabler:x" style="font-size:.7rem"></span>Tidak Aktif
            </span>
          @endif
        </td>
        <td class="text-end">
          <form method="POST" action="{{ route('owner.jadwal-terapis') }}" class="d-inline">
            @csrf
            <input type="hidden" name="therapist_id" value="{{ $t->id }}">
            <input type="hidden" name="date" value="{{ $date }}">
            <input type="hidden" name="is_active" value="{{ ($active && $active->is_active) ? '0' : '1' }}">
            <button class="btn btn-xs {{ ($active && $active->is_active) ? 'btn-outline-danger' : 'btn-outline-success' }}">
              {{ ($active && $active->is_active) ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="4" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:calendar-off"></span>
        Belum ada data terapis.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
