@extends("layouts.app")
@section("title", isset($tab) && $tab==="ulasan" ? "Ulasan Terapis" : "Edit Terapis")
@section("page-title", isset($tab) && $tab==="ulasan" ? "Ulasan Terapis" : "Edit Terapis")
@section("content")

@if(isset($tab) && $tab==="ulasan")
<div class="page-header">
  <h4>Ulasan — {{ $therapist->user?->name }}</h4>
  <p class="page-sub">Riwayat penilaian dari orang tua pasien.</p>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Pasien</th><th>Rating</th><th>Komentar</th><th>Tanggal</th></tr>
      </thead>
      <tbody>
      @forelse($reviews as $r)
      <tr>
        <td class="fw-semibold">{{ $r->child?->parent?->name }}</td>
        <td>
          <span class="text-warning">{{ str_repeat("★", $r->rating ?? 5) }}</span>
          <span class="text-muted">{{ str_repeat("☆", 5 - ($r->rating ?? 5)) }}</span>
        </td>
        <td class="text-muted">{{ $r->comment ?? "—" }}</td>
        <td class="text-muted small">{{ $r->created_at?->format("d M Y") }}</td>
      </tr>
      @empty
      <tr><td colspan="4" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:star-off"></span>
        Belum ada ulasan.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($reviews->hasPages())
  <div class="card-body pt-0 pb-3">{{ $reviews->links() }}</div>
  @endif
  <div class="card-body">
    <a href="{{ route("owner.terapis.index") }}" class="btn btn-outline-secondary">
      <span class="iconify me-1" data-icon="tabler:arrow-left"></span> Kembali
    </a>
  </div>
</div>

@else
<div class="page-header">
  <h4>Edit Terapis: {{ $therapist->user?->name }}</h4>
  <p class="page-sub">Perbarui profil dan data operasional terapis.</p>
</div>
<div class="card" style="max-width:600px">
  <div class="card-body">
    <form method="POST" action="{{ route("owner.terapis.update",$therapist->id) }}">
      @csrf @method("PUT")
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Cabang</label>
          <select name="branch_id" class="form-select">
            <option value="">— Pilih Cabang —</option>
            @foreach($branches ?? [] as $br)
              <option value="{{ $br->id }}" @selected($therapist->branch_id===$br->id)>{{ $br->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Spesialisasi</label>
          <input type="text" name="specialization" class="form-control"
                 value="{{ $therapist->specialization ?? "" }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Pengalaman (tahun)</label>
          <input type="number" name="years_experience" class="form-control"
                 value="{{ $therapist->years_experience ?? 0 }}" min="0">
        </div>
        <div class="col-md-6">
          <label class="form-label">Gaji Pokok (Rp)</label>
          <input type="number" name="base_salary" class="form-control"
                 value="{{ $therapist->base_salary ?? 0 }}" min="0">
        </div>
        <div class="col-12">
          <label class="form-label">Bio</label>
          <textarea name="bio" class="form-control" rows="3">{{ $therapist->bio ?? "" }}</textarea>
        </div>
        <div class="col-12">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                   value="1" @checked($therapist->is_active)>
            <label class="form-check-label" for="isActive">Terapis aktif</label>
          </div>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2 flex-wrap">
        <button class="btn btn-pink">
          <span class="iconify me-1" data-icon="tabler:device-floppy"></span> Simpan
        </button>
        <a href="{{ route("owner.terapis.index") }}" class="btn btn-outline-secondary">Batal</a>
        <a href="{{ route("owner.terapis.ulasan",$therapist->id) }}" class="btn btn-outline-secondary ms-auto">
          <span class="iconify me-1" data-icon="tabler:star"></span> Lihat Ulasan
        </a>
      </div>
    </form>
  </div>
</div>
@endif
@endsection
