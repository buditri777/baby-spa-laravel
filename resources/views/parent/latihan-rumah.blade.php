@extends("layouts.app")
@section("title","Latihan Rumah")
@section("page-title","Latihan Rumah — {{ $child->name }}")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Latihan Rumah</h4>
    <p class="page-sub">Program latihan mandiri untuk {{ $child->name }}.</p>
  </div>
  <a href="{{ route('anak.show',$child->id) }}" class="btn btn-sm btn-outline-secondary">
    <span class="iconify me-1" data-icon="tabler:arrow-left"></span> Kembali
  </a>
</div>

@forelse($exercises as $e)
<div class="card mb-3">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
      <div class="fw-semibold">{{ $e->title }}</div>
      <div class="small text-muted">{{ \Carbon\Carbon::parse($e->created_at)->format('d M Y') }}</div>
    </div>
    <div class="small text-muted">{!! nl2br(e($e->description)) !!}</div>
    @if($e->video_url)
    <a href="{{ $e->video_url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
      <span class="iconify me-1" data-icon="tabler:player-play"></span> Video
    </a>
    @endif
  </div>
</div>
@empty
<div class="card">
  <div class="card-body text-center text-muted py-5">
    <span class="iconify fs-3 d-block mb-2" data-icon="tabler:barbell-off"></span>
    Belum ada program latihan rumah.
  </div>
</div>
@endforelse
@endsection
