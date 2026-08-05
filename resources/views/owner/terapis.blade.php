@extends("layouts.app")
@section("title","Terapis")
@section("page-title","Manajemen Terapis")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Manajemen Terapis</h4>
    <p class="page-sub">Data terapis aktif dan detail profil mereka.</p>
  </div>
  <a href="{{ route("owner.staf.create") }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Tambah Terapis
  </a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Nama</th><th>Spesialisasi</th><th>Cabang</th>
          <th>Pengalaman</th><th>Gaji Pokok</th><th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($therapists ?? [] as $t)
      <tr>
        <td class="fw-semibold">{{ $t->user?->name }}</td>
        <td class="text-muted">{{ $t->specialization ?? "—" }}</td>
        <td class="text-muted">{{ $t->branch?->name ?? "—" }}</td>
        <td class="text-muted">{{ $t->years_experience ?? 0 }} thn</td>
        <td>{{ $t->base_salary ? "Rp".number_format($t->base_salary,0,",",".") : "—" }}</td>
        <td>
          <span class="badge {{ $t->is_active ? "badge-active" : "badge-inactive" }}">
            {{ $t->is_active ? "Aktif" : "Nonaktif" }}
          </span>
        </td>
        <td class="text-end">
          <a href="{{ route("owner.terapis.edit",$t->id) }}" class="btn btn-xs btn-outline-primary">
            <span class="iconify" data-icon="tabler:edit"></span>
          </a>
          <a href="{{ route("owner.terapis.ulasan",$t->id) }}" class="btn btn-xs btn-outline-secondary">
            <span class="iconify" data-icon="tabler:star"></span>
          </a>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:user-search"></span>
        Belum ada terapis terdaftar.
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
