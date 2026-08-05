@extends("layouts.app")
@section("title","Konsultasi")
@section("page-title","Konsultasi Tanya Terapis")
@section("content")

@if(isset($detail) && isset($konsul))
{{-- Detail / chat --}}
<div class="page-header">
  <h4>{{ $konsul->subject }}</h4>
  <p class="page-sub">{{ $konsul->child?->name }} · {{ $konsul->parent?->name }}</p>
</div>

<div class="card" style="max-width:720px">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
      <span class="badge {{ $konsul->status==='OPEN' ? 'badge-pending' : ($konsul->status==='CLAIMED' ? 'badge-confirmed' : 'badge-inactive') }}">
        {{ $konsul->status==='OPEN' ? 'Menunggu' : ($konsul->status==='CLAIMED' ? 'Ditangani' : 'Ditutup') }}
      </span>
    </div>
  </div>
  <div class="card-body" style="max-height:400px;overflow-y:auto" id="chatBox">
    @foreach($konsul->messages as $msg)
    @php $isMe = $msg->sender_id === auth()->id(); @endphp
    <div class="mb-2 d-flex {{ $isMe ? 'justify-content-end' : '' }}">
      <div class="px-3 py-2 rounded-3" style="max-width:75%;background:{{ $isMe ? 'var(--brand)' : 'var(--surface-2)' }};color:{{ $isMe ? '#fff' : 'var(--ink)' }}">
        <div class="small fw-semibold mb-1">{{ $msg->sender?->name }}</div>
        <div>{{ $msg->message }}</div>
        <div class="small opacity-75 mt-1">{{ $msg->created_at?->format("d M H:i") }}</div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="card-body border-top">
    <div class="d-flex gap-2 mb-3">
      @if($konsul->status === "OPEN")
      <form method="POST" action="{{ route("owner.konsultasi") }}/{{ $konsul->id }}">
        @csrf @method("PUT")
        <input type="hidden" name="action" value="claim">
        <button class="btn btn-sm btn-outline-primary">
          <span class="iconify me-1" data-icon="tabler:hand-grab"></span> Ambil
        </button>
      </form>
      @endif
      @if($konsul->status !== "CLOSED")
      <form method="POST" action="{{ route("owner.konsultasi") }}/{{ $konsul->id }}">
        @csrf @method("PUT")
        <input type="hidden" name="action" value="close">
        <button class="btn btn-sm btn-outline-danger" onclick="return confirm("Tutup konsultasi ini?")">
          <span class="iconify me-1" data-icon="tabler:x"></span> Tutup
        </button>
      </form>
      @endif
    </div>
    @if($konsul->status !== "CLOSED")
    <form method="POST" action="{{ route("owner.konsultasi") }}/{{ $konsul->id }}" class="d-flex gap-2">
      @csrf @method("PUT")
      <input type="text" name="message" class="form-control form-control-sm" placeholder="Ketik balasan…" required>
      <button class="btn btn-sm btn-pink">
        <span class="iconify" data-icon="tabler:send"></span>
      </button>
    </form>
    @endif
  </div>
</div>
<a href="{{ route("owner.konsultasi") }}" class="btn btn-outline-secondary btn-sm mt-3">
  <span class="iconify me-1" data-icon="tabler:arrow-left"></span> Kembali
</a>

@else
{{-- Daftar --}}
<div class="page-header">
  <h4>Daftar Konsultasi</h4>
  <p class="page-sub">Kelola permintaan konsultasi dari orang tua.</p>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span><span class="iconify me-2 text-primary" data-icon="tabler:message-circle"></span>Konsultasi</span>
    <form method="GET" class="d-flex gap-2">
      <select name="status" class="form-select form-select-sm" style="width:160px">
        <option value="">Semua Status</option>
        @foreach(["OPEN"=>"Menunggu","CLAIMED"=>"Ditangani","CLOSED"=>"Ditutup"] as $val => $label)
          <option value="{{ $val }}" @selected(request("status")===$val)>{{ $label }}</option>
        @endforeach
      </select>
      <button class="btn btn-sm btn-outline-secondary"><span class="iconify" data-icon="tabler:filter"></span></button>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr><th>Subjek</th><th>Pasien</th><th>Anak</th><th>Terapis</th><th>Status</th><th>Update</th><th class="text-end">Aksi</th></tr>
      </thead>
      <tbody>
      @forelse($konsultasi as $k)
      <tr>
        <td class="fw-semibold">{{ $k->subject }}</td>
        <td class="text-muted">{{ $k->parent?->name }}</td>
        <td class="text-muted">{{ $k->child?->name }}</td>
        <td class="text-muted">{{ $k->therapist?->name ?? "—" }}</td>
        <td>
          <span class="badge {{ $k->status==='OPEN' ? 'badge-pending' : ($k->status==='CLAIMED' ? 'badge-confirmed' : 'badge-inactive') }}">
            {{ $k->status==='OPEN' ? 'Menunggu' : ($k->status==='CLAIMED' ? 'Ditangani' : 'Ditutup') }}
          </span>
        </td>
        <td class="text-muted small">{{ $k->updated_at?->diffForHumans() }}</td>
        <td class="text-end">
          <a href="{{ route("owner.konsultasi") }}/{{ $k->id }}" class="btn btn-xs btn-outline-primary">
            <span class="iconify" data-icon="tabler:eye"></span>
          </a>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" class="text-center text-muted py-5">
        <span class="iconify fs-3 d-block mb-2" data-icon="tabler:message-off"></span>
        Belum ada konsultasi.
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($konsultasi->hasPages())
  <div class="card-body pt-0 pb-3">{{ $konsultasi->links() }}</div>
  @endif
</div>
@endif
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
@push("scripts")
<script>const b=document.getElementById('chatBox');if(b)b.scrollTop=b.scrollHeight;</script>
@endpush
