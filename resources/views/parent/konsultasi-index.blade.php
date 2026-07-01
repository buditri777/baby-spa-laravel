@extends("layouts.app")
@section("title","Konsultasi")
@section("page-title","Tanya Terapis")
@section("content")
<div class="row g-3">
  {{-- Form buat konsultasi baru --}}
  @if(isset($form) || isset($konsul))
  <div class="col-md-5">
    @if(!isset($konsul))
    <div class="card shadow-sm">
      <div class="card-header bg-white fw-semibold">Mulai Konsultasi Baru</div>
      <div class="card-body">
        <form method="POST" action="{{ route('konsultasi.store') }}">@csrf
        <div class="row g-3">
          <div class="col-12"><label class="form-label">Anak</label>
            <select name="child_id" class="form-select" required>
              <option value="">-- Pilih Anak --</option>
              @foreach($children as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12"><label class="form-label">Subjek</label>
            <input type="text" name="subject" class="form-control" required placeholder="Misal: Tanya soal perkembangan motorik"></div>
          <div class="col-12"><label class="form-label">Pesan Pertama</label>
            <textarea name="first_message" class="form-control" rows="3" required></textarea></div>
        </div>
        <div class="mt-3"><button class="btn btn-pink w-100">Kirim</button></div>
        </form>
      </div>
    </div>
    @endif
  </div>
  @endif

  @if(isset($konsul))
  {{-- Chat thread --}}
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold">{{ $konsul->subject }}</span>
        <span class="badge bg-{{ $konsul->status==='OPEN'?'warning':($konsul->status==='CLAIMED'?'primary':'secondary') }}">{{ $konsul->status }}</span>
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
      @if($konsul->status !== 'CLOSED')
      <div class="card-footer bg-white">
        <form method="POST" action="{{ route('konsultasi.store') }}" class="d-flex gap-2">@csrf
          <input type="hidden" name="child_id" value="{{ $konsul->child_id }}">
          <input type="hidden" name="subject" value="{{ $konsul->subject }}">
          <input type="text" name="first_message" class="form-control form-control-sm" placeholder="Ketik pesan..." required>
          <button class="btn btn-sm btn-pink"><i class="bx bx-send"></i></button>
        </form>
      </div>
      @endif
    </div>
  </div>
  @else
  {{-- Daftar konsultasi --}}
  <div class="col-12">
    <div class="card shadow-sm">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold">Konsultasi Saya</span>
        <a href="{{ route('konsultasi.create') }}" class="btn btn-sm btn-pink"><i class="bx bx-plus"></i> Tanya Baru</a>
      </div>
      <div class="card-body">
        @forelse($konsultasi as $k)
        <a href="{{ route('konsultasi.show',$k->id) }}" class="text-decoration-none">
          <div class="card mb-2 border-0 shadow-sm">
            <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold text-dark">{{ $k->subject }}</div>
                <div class="small text-muted">{{ $k->child?->name }} · {{ $k->updated_at?->diffForHumans() }}</div>
              </div>
              <span class="badge bg-{{ $k->status==='OPEN'?'warning':($k->status==='CLAIMED'?'primary':'secondary') }}">{{ $k->status }}</span>
            </div>
          </div>
        </a>
        @empty
        <p class="text-muted text-center py-4">Belum ada konsultasi. <a href="{{ route('konsultasi.create') }}">Mulai tanya</a>.</p>
        @endforelse
        {{ $konsultasi->links() }}
      </div>
    </div>
  </div>
  @endif
</div>
@endsection
@push("styles")<style>.btn-pink{background:#e83e8c;color:#fff;}.btn-pink:hover{background:#c2185b;color:#fff;}</style>@endpush
@push("scripts")
<script>
const box = document.getElementById('chatBox');
if (box) box.scrollTop = box.scrollHeight;
</script>
@endpush
