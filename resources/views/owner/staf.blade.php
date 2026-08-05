@extends('layouts.app')
@section('title','Staf')
@section('page-title','Manajemen Staf')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Manajemen Staf</h4>
    <p class="page-sub">Kelola akun dan akses staf klinik.</p>
  </div>
  <a href="{{ route('owner.staf.create') }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Tambah Staf
  </a>
</div>

<div class="card">
  <div class="card-header">
    <form class="row g-2 align-items-center" method="GET">
      <div class="col-sm-5">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Cari nama / no HP…" value="{{ request('search') }}">
      </div>
      <div class="col-sm-4">
        <select name="role" class="form-select form-select-sm">
          <option value="">Semua Role</option>
          @foreach(['THERAPIST'=>'Terapis','RECEPTIONIST'=>'Resepsionis','ADMIN'=>'Admin','DIREKTUR'=>'Direktur'] as $val => $label)
            <option value="{{ $val }}" @selected(request('role')===$val)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-3">
        <button class="btn btn-sm btn-outline-secondary w-100">
          <span class="iconify me-1" data-icon="tabler:filter"></span>Filter
        </button>
      </div>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Nama</th><th>No HP</th><th>Role</th><th>Cabang</th><th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($staf as $s)
      @php
        $roleLabel = ['THERAPIST'=>'Terapis','RECEPTIONIST'=>'Resepsionis','ADMIN'=>'Admin','DIREKTUR'=>'Direktur','SUPER_ADMIN'=>'Super Admin'][$s->role] ?? $s->role;
      @endphp
      <tr>
        <td class="fw-semibold">{{ $s->name }}</td>
        <td class="text-muted">{{ $s->phone }}</td>
        <td><span class="badge badge-confirmed">{{ $roleLabel }}</span></td>
        <td class="text-muted">{{ $s->branch?->name ?? 'Semua' }}</td>
        <td>
          <span class="badge {{ $s->is_active ? 'badge-active' : 'badge-inactive' }}">
            {{ $s->is_active ? 'Aktif' : 'Nonaktif' }}
          </span>
        </td>
        <td class="text-end">
          <a href="{{ route('owner.staf.edit',$s->id) }}" class="btn btn-xs btn-outline-primary">
            <span class="iconify" data-icon="tabler:edit"></span>
          </a>
          <form method="POST" action="{{ route('owner.staf.destroy',$s->id) }}" class="d-inline"
                onsubmit="return confirm('Nonaktifkan staf ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-xs btn-outline-danger">
              <span class="iconify" data-icon="tabler:user-off"></span>
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:users"></span>
        Belum ada staf terdaftar.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($staf->hasPages())
  <div class="card-body pt-0 pb-3">{{ $staf->links() }}</div>
  @endif
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
