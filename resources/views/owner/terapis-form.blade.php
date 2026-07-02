@extends("layouts.app")
@section("title", isset($tab) && $tab==="ulasan" ? "Ulasan Terapis" : "Edit Terapis")
@section("page-title", isset($tab) && $tab==="ulasan" ? "Ulasan Terapis" : "Edit Terapis")
@section("content")
@if(isset($tab) && $tab==="ulasan")
<div class="card shadow-sm">
  <div class="card-header bg-white fw-semibold">Ulasan — {{ $therapist->user?->name }}</div>
  <div class="table-responsive">
    <table class="table table-sm align-middle mb-0">
      <thead class="table-light"><tr><th>Pasien</th><th>Rating</th><th>Komentar</th><th>Tanggal</th></tr></thead>
      <tbody>
      @forelse($reviews as $r)
      <tr>
        <td>{{ $r->child?->parent?->name }}</td>
        <td>{{ str_repeat("★",$r->rating ?? 5) }}</td>
        <td>{{ $r->comment ?? "-" }}</td>
        <td>{{ $r->created_at?->format("d M Y") }}</td>
      </tr>
      @empty
      <tr><td colspan="4" class="text-center text-muted py-3">Belum ada ulasan.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  {{ $reviews->links() }}
</div>
@else
<div class="card shadow-sm" style="max-width:600px">
  <div class="card-header bg-white fw-semibold">Edit Terapis: {{ $therapist->user?->name }}</div>
  <div class="card-body">
    <form method="POST" action="{{ route("owner.terapis.update",$therapist->id) }}">@csrf @method("PUT")
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Cabang</label>
        <select name="branch_id" class="form-select">
          <option value="">-- Pilih Cabang --</option>
          @foreach($branches ?? [] as $br)
            <option value="{{ $br->id }}" @selected($therapist->branch_id===$br->id)>{{ $br->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">Spesialisasi</label>
        <input type="text" name="specialization" class="form-control" value="{{ $therapist->specialization ?? "" }}"></div>
      <div class="col-md-6"><label class="form-label">Pengalaman (thn)</label>
        <input type="number" name="years_experience" class="form-control" value="{{ $therapist->years_experience ?? 0 }}" min="0"></div>
      <div class="col-md-6"><label class="form-label">Gaji Pokok (Rp)</label>
        <input type="number" name="base_salary" class="form-control" value="{{ $therapist->base_salary ?? 0 }}" min="0"></div>
      <div class="col-12"><label class="form-label">Bio</label>
        <textarea name="bio" class="form-control" rows="2">{{ $therapist->bio ?? "" }}</textarea></div>
      <div class="col-12">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked($therapist->is_active)>
          <label class="form-check-label">Aktif</label>
        </div>
      </div>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-pink">Simpan</button>
      <a href="{{ route("owner.terapis.index") }}" class="btn btn-outline-secondary">Batal</a>
      <a href="{{ route("owner.terapis.ulasan",$therapist->id) }}" class="btn btn-outline-info ms-auto">Lihat Ulasan</a>
    </div>
    </form>
  </div>
</div>
@endif
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
