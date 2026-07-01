@extends("layouts.app")
@section("title","Latihan Rumah")
@section("page-title","Latihan Rumah — {{ $child->name }}")
@section("content")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Program Latihan Rumah</div>
  <div class="card-body">
    @forelse($exercises as $e)
    <div class="card mb-2 border-0 shadow-sm">
      <div class="card-body py-2 px-3">
        <div class="fw-semibold">{{ $e->title }}</div>
        <div class="small text-muted mb-1">{{ \Carbon\Carbon::parse($e->created_at)->format('d M Y') }}</div>
        <div class="small">{!! nl2br(e($e->description)) !!}</div>
        @if($e->video_url)<a href="{{ $e->video_url }}" target="_blank" class="btn btn-xs btn-outline-info mt-1"><i class="bx bx-play"></i> Video</a>@endif
      </div>
    </div>
    @empty
    <p class="text-muted text-center py-4">Belum ada program latihan rumah.</p>
    @endforelse
  </div>
</div>
<a href="{{ route('anak.show',$child->id) }}" class="btn btn-outline-secondary mt-3 btn-sm"><i class="bx bx-arrow-back"></i> Kembali</a>
@endsection
@push("styles")<style>.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
