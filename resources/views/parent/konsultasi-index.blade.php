@extends("layouts.app")
@section("title","Konsultasi")
@section("page-title","Tanya Terapis")
@section("content")

<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h4>Tanya Terapis</h4>
    <p class="page-sub">Konsultasi langsung dengan terapis kami.</p>
  </div>
  @if(!isset($konsul) && !isset($form))
  <a href="{{ route('konsultasi.index', ['form'=>1]) }}" class="btn btn-sm btn-pink">
    <span class="iconify me-1" data-icon="tabler:plus"></span> Konsultasi Baru
  </a>
  @endif
</div>

<div class="row g-4">
  {{-- Form baru --}}
  @if((isset($form) || isset($konsul)) && !isset($konsul))
  <div class="col-md-5">
    <div class="card">
      <div class="card-header">
        <span class="iconify me-2 text-primary" data-icon="tabler:message-plus"></span>Mulai Konsultasi Baru
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('konsultasi.store') }}">
          @csrf
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Anak</label>
              <select name="child_id" class="form-select" required>
                <option value="">— Pilih Anak —</option>
                @foreach($children as $c)
                  <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Subjek</label>
              <input type="text" name="subject" class="form-control" required
                     placeholder="Misal: Tanya soal perkembangan motorik">
            </div>
            <div class="col-12">
              <label class="form-label">Pesan Pertama</label>
              <textarea name="first_message" class="form-control" rows="3" required></textarea>
            </div>
          </div>
          <div class="mt-4">
            <button class="btn btn-pink w-100">
              <span class="iconify me-1" data-icon="tabler:send"></span> Kirim
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endif

  {{-- Chat thread --}}
  @if(isset($konsul))
  <div class="col-md-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold">{{ $konsul->subject }}</span>
        <span class="badge {{ $konsul->status==='OPEN' ? 'badge-pending' : ($konsul->status==='CLAIMED' ? 'badge-confirmed' : 'badge-inactive') }}">
          {{ $konsul->status==='OPEN' ? 'Menunggu' : ($konsul->status==='CLAIMED' ? 'Ditangani' : 'Ditutup') }}
        </span>
      </div>
      <div class="card-body" style="max-height:400px;overflow-y:auto" id="chatBox">
        @foreach($konsul->messages as $msg)
        @php $isMe = $msg->sender_id === auth()->id(); @endphp
        <div class="mb-2 d-flex {{ $isMe ? 'justify-content-end' : '' }}">
          <div class="px-3 py-2 rounded-3" style="max-width:75%;background:{{ $isMe ? 'var(--brand)' : 'var(--surface-2)' }};color:{{ $isMe ? '#fff' : 'var(--ink)' }}">
            <div class="small fw-semibold mb-1">{{ $msg->sender?->name }}</div>
            <div>{{ $msg->message }}</div>
            <div class="small opacity-75 mt-1">{{ $msg->created_at?->format('d M H:i') }}</div>
          </div>
        </div>
        @endforeach
      </div>
      @if($konsul->status !== 'CLOSED')
      <div class="card-body border-top">
        <form method="POST" action="{{ route('konsultasi.reply', $konsul->id) }}" class="d-flex gap-2">
          @csrf
          <input type="text" name="message" class="form-control form-control-sm" placeholder="Ketik pesan…" required>
          <button class="btn btn-sm btn-pink">
            <span class="iconify" data-icon="tabler:send"></span>
          </button>
        </form>
      </div>
      @endif
    </div>
    <a href="{{ route('konsultasi.index') }}" class="btn btn-outline-secondary btn-sm mt-3">
      <span class="iconify me-1" data-icon="tabler:arrow-left"></span> Kembali
    </a>
  </div>

  @else
  {{-- Daftar konsultasi --}}
  <div class="{{ isset($form) ? 'col-md-7' : 'col-12' }}">
    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead><tr><th>Subjek</th><th>Anak</th><th>Status</th><th>Update</th><th class="text-end">Aksi</th></tr></thead>
          <tbody>
          @forelse($konsultasi as $k)
          <tr>
            <td class="fw-semibold">{{ $k->subject }}</td>
            <td class="text-muted">{{ $k->child?->name }}</td>
            <td>
              <span class="badge {{ $k->status==='OPEN' ? 'badge-pending' : ($k->status==='CLAIMED' ? 'badge-confirmed' : 'badge-inactive') }}">
                {{ $k->status==='OPEN' ? 'Menunggu' : ($k->status==='CLAIMED' ? 'Ditangani' : 'Ditutup') }}
              </span>
            </td>
            <td class="text-muted small">{{ $k->updated_at?->diffForHumans() }}</td>
            <td class="text-end">
              <a href="{{ route('konsultasi.show', $k->id) }}" class="btn btn-xs btn-outline-primary">
                <span class="iconify" data-icon="tabler:eye"></span>
              </a>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted py-5">
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
  </div>
  @endif
</div>
@endsection
@push('styles')
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;line-height:1.4;}</style>
@endpush
@push("scripts")
<script>const b=document.getElementById('chatBox');if(b)b.scrollTop=b.scrollHeight;</script>
@endpush
