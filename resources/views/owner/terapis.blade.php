@extends("layouts.app")
@section("title","Terapis")
@section("page-title","Manajemen Terapis")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Daftar Terapis</span>
    <a href="{{ route("owner.staf.create") }}" class="btn btn-sm btn-pink"><i class="bx bx-plus"></i> Tambah Terapis</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Nama</th><th>Spesialisasi</th><th>Cabang</th><th>Pengalaman</th><th>Gaji Pokok</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($therapists ?? [] as $t)
        <tr>
          <td>{{ $t->user?->name }}</td>
          <td>{{ $t->specialization ?? "-" }}</td>
          <td>{{ $t->branch?->name ?? "-" }}</td>
          <td>{{ $t->years_experience ?? 0 }} thn</td>
          <td>{{ $t->base_salary ? "Rp".number_format($t->base_salary,0,",",".") : "-" }}</td>
          <td><span class="badge bg-{{ $t->is_active?"success":"secondary" }}">{{ $t->is_active?"Aktif":"Nonaktif" }}</span></td>
          <td><a href="{{ route("owner.terapis.edit",$t->id) }}" class="btn btn-xs btn-outline-primary"><i class="bx bx-edit"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada terapis.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
