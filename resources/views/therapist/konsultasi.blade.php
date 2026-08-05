@extends("layouts.app")
@section("title","Konsultasi")
@section("page-title","Konsultasi Tanya Terapis")
@section("content")

<div class="page-header">
  <h4>Konsultasi</h4>
  <p class="page-sub">Pertanyaan dari orang tua pasien.</p>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Subjek</th><th>Pasien</th><th>Anak</th><th>Status</th><th>Update</th></tr>
      </thead>
      <tbody>
      @forelse($konsultasi as $k)
      <tr>
        <td class="fw-semibold">{{ $k->subject }}</td>
        <td class="text-muted">{{ $k->parent?->name }}</td>
        <td class="text-muted">{{ $k->child?->name }}</td>
        <td>
          <span class="badge {{ $k->status==='OPEN' ? 'badge-pending' : ($k->status==='CLAIMED' ? 'badge-confirmed' : 'badge-inactive') }}">
            {{ $k->status==='OPEN' ? 'Menunggu' : ($k->status==='CLAIMED' ? 'Ditangani' : 'Ditutup') }}
          </span>
        </td>
        <td class="text-muted small">{{ $k->updated_at?->diffForHumans() }}</td>
      </tr>
      @empty
      <tr><td colspan="5" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:message-off"></span>
        Belum ada konsultasi.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($konsultasi->hasPages())
  <div class="card-body pt-0 pb-3">{{ $konsultasi->links() }}</div>
  @endif
</div>
@endsection
