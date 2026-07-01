@extends('layouts.app')
@section('title','Layanan')
@section('page-title','Manajemen Layanan')
@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Daftar Layanan</span>
    <a href="{{ route('owner.layanan.create') }}" class="btn btn-sm btn-pink"><i class="bx bx-plus"></i> Tambah Layanan</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Nama</th><th>Kategori</th><th>Harga</th><th>Durasi</th><th>Cabang</th><th>Rate Honor</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($services as $s)
        <tr>
          <td>{{ $s->name }}</td>
          <td>{{ $s->category }}</td>
          <td>Rp{{ number_format($s->price,0,',','.') }}</td>
          <td>{{ $s->duration_min }} mnt</td>
          <td>{{ $s->branch?->name ?? 'Global' }}</td>
          <td>
            @if($s->rate)
              {{ $s->rate->fee_type === 'FLAT' ? 'Rp'.number_format($s->rate->fee_value,0,',','.') : $s->rate->fee_value.'%' }}
            @else <span class="text-muted small">default</span> @endif
          </td>
          <td><span class="badge bg-{{ $s->is_active?'success':'secondary' }}">{{ $s->is_active?'Aktif':'Nonaktif' }}</span></td>
          <td>
            <a href="{{ route('owner.layanan.edit',$s->id) }}" class="btn btn-xs btn-outline-primary"><i class="bx bx-edit"></i></a>
            <form method="POST" action="{{ route('owner.layanan.destroy',$s->id) }}" class="d-inline" onsubmit="return confirm('Nonaktifkan layanan ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-xs btn-outline-danger"><i class="bx bx-x"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-muted py-4">Belum ada layanan.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $services->links() }}
  </div>
</div>
@endsection
@push('styles')<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
