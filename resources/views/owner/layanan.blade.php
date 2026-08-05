@extends('layouts.app')
@section('title','Layanan')
@section('page-title','Manajemen Layanan')
@section('content')

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Manajemen Layanan</h4>
    <p class="page-sub">Kelola layanan dan fee terapis per layanan.</p>
  </div>
  <a href="{{ route('owner.layanan.create') }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Tambah Layanan
  </a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Nama Layanan</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Durasi</th>
          <th>Cabang</th>
          <th>Fee Terapis</th>
          <th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($services as $s)
      <tr>
        <td class="fw-semibold">{{ $s->name }}</td>
        <td><span class="badge badge-confirmed">{{ $s->category }}</span></td>
        <td>Rp{{ number_format($s->price,0,',','.') }}</td>
        <td class="text-muted">{{ $s->duration_min }} mnt</td>
        <td class="text-muted">{{ $s->branch?->name ?? 'Global' }}</td>
        <td>
          @if($s->rate)
            <span class="text-success fw-semibold">
              {{ $s->rate->fee_type === 'FLAT' ? 'Rp'.number_format($s->rate->fee_value,0,',','.') : $s->rate->fee_value.'%' }}
            </span>
          @else
            <span class="text-muted small">default</span>
          @endif
        </td>
        <td>
          <span class="badge {{ $s->is_active ? 'badge-active' : 'badge-inactive' }}">
            {{ $s->is_active ? 'Aktif' : 'Nonaktif' }}
          </span>
        </td>
        <td class="text-end">
          <a href="{{ route('owner.layanan.edit',$s->id) }}" class="btn btn-xs btn-outline-primary">
            <span class="iconify" data-icon="tabler:edit"></span>
          </a>
          <form method="POST" action="{{ route('owner.layanan.destroy',$s->id) }}" class="d-inline"
                onsubmit="return confirm('Nonaktifkan layanan ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-xs btn-outline-danger">
              <span class="iconify" data-icon="tabler:trash"></span>
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="8" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:list-search"></span>
        Belum ada layanan terdaftar.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($services->hasPages())
  <div class="card-body pt-0 pb-3">{{ $services->links() }}</div>
  @endif
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
