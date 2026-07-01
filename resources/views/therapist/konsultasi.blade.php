@extends("layouts.app")
@section("title","Konsultasi")
@section("page-title","Konsultasi Tanya Terapis")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Daftar Konsultasi</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Subjek</th><th>Pasien</th><th>Anak</th><th>Status</th><th>Update</th></tr></thead>
        <tbody>
        @forelse($konsultasi as $k)
        <tr>
          <td>{{ $k->subject }}</td>
          <td>{{ $k->parent?->name }}</td>
          <td>{{ $k->child?->name }}</td>
          <td><span class="badge bg-{{ $k->status==="OPEN"?"warning":($k->status==="CLAIMED"?"primary":"secondary") }}">{{ $k->status }}</span></td>
          <td>{{ $k->updated_at?->diffForHumans() }}</td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada konsultasi.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $konsultasi->links() }}
  </div>
</div>
@endsection
