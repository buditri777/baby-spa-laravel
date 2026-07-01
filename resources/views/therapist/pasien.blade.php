@extends("layouts.app")
@section("title","Pasien Saya")
@section("page-title","Pasien Saya")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Daftar Pasien</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Nama Anak</th><th>Orang Tua</th><th>Gender</th><th>Tgl Lahir</th></tr></thead>
        <tbody>
        @forelse($children as $c)
        <tr>
          <td>{{ $c->name }}</td>
          <td>{{ $c->parent?->name }}</td>
          <td>{{ $c->gender === "L" ? "Laki-laki" : "Perempuan" }}</td>
          <td>{{ $c->birth_date?->format("d M Y") }}</td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada pasien.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $children->links() }}
  </div>
</div>
@endsection
