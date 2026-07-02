@extends("layouts.app")
@section("title","Konsultasi")
@section("page-title","Konsultasi Tanya Terapis")
@section("content")
@if(isset($detail) && isset($konsul))
{{-- Detail / chat --}}
<div class="card shadow-sm" style="max-width:720px">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
      <span class="fw-semibold">{{ $konsul->subject }}</span>
      <div class="small text-muted">{{ $konsul->child?->name }} · {{ $konsul->parent?->name }}</div>
    </div>
    <span class="badge bg-{{ $konsul->status==='OPEN'?'warning':($konsul->status==='CLAIMED'?'primary':'secondary') }} fs-6">{{ $konsul->status }}</span>
  </div>
  <div class="card-body" style="max-height:400px;overflow-y:auto" id="chatBox">
    @foreach($konsul->messages as $msg)
    <div class="mb-2 d-flex {{ $msg->sender_id===auth()->id()?'justify-content-end':'' }}">
      <div class="px-3 py-2 rounded" style="max-width:75%;background:{{ $msg->sender_id===auth()->id()?'#e83e8c':'#f0f0f0' }};color:{{ $msg->sender_id===auth()->id()?'#fff':'#333' }}">
        <div class="small fw-semibold mb-1">{{ $msg->sender?->name }}</div>
        <div>{{ $msg->message }}</div>
        <div class="small opacity-75 mt-1">{{ $msg->created_at?->format('d M H:i') }}</div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="card-footer bg-white">
    <div class="d-flex gap-2 mb-2">
      @if($konsul->status === 'OPEN')
      <form method="POST" action="{{ route('owner.konsultasi') }}/{{ $konsul->id }}">@csrf @method('PUT')
        <input type="hidden" name="action" value="claim">
        <button class="btn btn-sm btn-outline-primary"><i class="bx bx-hand"></i> Ambil</button>
      </form>
      @endif
      @if($konsul->status !== 'CLOSED')
      <form method="POST" action="{{ route('owner.konsultasi') }}/{{ $konsul->id }}">@csrf @method('PUT')
        <input type="hidden" name="action" value="close">
        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Tutup konsultasi ini?')"><i class="bx bx-x"></i> Tutup</button>
      </form>
      @endif
    </div>
    @if($konsul->status !== 'CLOSED')
    <form method="POST" action="{{ route('owner.konsultasi') }}/{{ $konsul->id }}" class="d-flex gap-2">@csrf @method('PUT')
      <input type="text" name="message" class="form-control form-control-sm" placeholder="Balas..." required>
      <button class="btn btn-sm btn-pink"><i class="bx bx-send"></i></button>
    </form>
    @endif
  </div>
</div>
<a href="{{ route('owner.konsultasi') }}" class="btn btn-outline-secondary btn-sm mt-3"><i class="bx bx-arrow-back"></i> Kembali</a>
@else
{{-- Daftar --}}
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-semibold">Daftar Konsultasi</span>
    <form method="GET" class="d-flex gap-2">
      <select name="status" class="form-select form-select-sm" style="width:140px">
        <option value="">Semua Status</option>
        @foreach(['OPEN','CLAIMED','CLOSED'] as $s)
          <option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>
        @endforeach
      </select>
      <button class="btn btn-sm btn-outline-secondary">Filter</button>
    </form>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light"><tr><th>Subjek</th><th>Pasien</th><th>Anak</th><th>Terapis</th><th>Status</th><th>Update</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($konsultasi as $k)
        <tr>
          <td>{{ $k->subject }}</td>
          <td>{{ $k->parent?->name }}</td>
          <td>{{ $k->child?->name }}</td>
          <td>{{ $k->therapist?->name ?? '-' }}</td>
          <td><span class="badge bg-{{ $k->status==='OPEN'?'warning':($k->status==='CLAIMED'?'primary':'secondary') }}">{{ $k->status }}</span></td>
          <td>{{ $k->updated_at?->diffForHumans() }}</td>
          <td><a href="{{ route('owner.konsultasi') }}/{{ $k->id }}" class="btn btn-xs btn-outline-primary"><i class="bx bx-show"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada konsultasi.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    {{ $konsultasi->links() }}
  </div>
</div>
@endif
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}.btn-xs{padding:.15rem .4rem;font-size:.75rem;}</style>@endpush
@push("scripts")<script>const b=document.getElementById('chatBox');if(b)b.scrollTop=b.scrollHeight;</script>@endpush
