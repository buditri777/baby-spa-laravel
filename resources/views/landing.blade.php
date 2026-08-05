<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sofia Baby Spa — Perawatan & Tumbuh Kembang Si Kecil</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    :root { --brand:#e83e8c; --brand-dark:#c62d78; --brand-light:#ff85b3; --brand-muted:#fdf0f6; }
    * { box-sizing:border-box; }
    body { font-family:'Public Sans',sans-serif; color:#3a3a4c; margin:0; }
    .hero { background:linear-gradient(135deg,var(--brand) 0%,var(--brand-light) 100%); color:#fff; padding:80px 0 64px; }
    .hero h1 { font-size:2.5rem; font-weight:700; }
    .hero p { font-size:1.15rem; opacity:.92; }
    .btn-hero { background:#fff; color:var(--brand); font-weight:600; border-radius:.5rem; padding:.65rem 1.5rem; border:none; transition:all .15s; }
    .btn-hero:hover { background:#fff0f6; transform:translateY(-1px); }
    .btn-hero-outline { color:#fff; border:2px solid rgba(255,255,255,.7); border-radius:.5rem; padding:.6rem 1.5rem; font-weight:600; background:transparent; transition:all .15s; }
    .btn-hero-outline:hover { background:rgba(255,255,255,.15); color:#fff; border-color:#fff; }
    .card-service { border:none; border-radius:16px; box-shadow:0 2px 20px rgba(232,62,140,.08); transition:transform .2s,box-shadow .2s; overflow:hidden; }
    .card-service:hover { transform:translateY(-4px); box-shadow:0 8px 30px rgba(232,62,140,.15); }
    .card-service .svc-icon { font-size:2.5rem; display:block; margin-bottom:.75rem; }
    .badge-price { background:var(--brand-muted); color:var(--brand); font-size:.9rem; font-weight:600; border-radius:8px; padding:4px 12px; }
    .section-title { color:var(--brand); font-weight:700; }
    .why-item { display:flex; gap:1rem; align-items:flex-start; margin-bottom:1.5rem; }
    .why-icon { font-size:1.8rem; flex-shrink:0; }
    footer { background:var(--brand); color:#fff; padding:2rem 0; }
    footer a { color:rgba(255,255,255,.8); text-decoration:none; }
    footer a:hover { color:#fff; }
    .faq-q { font-weight:600; cursor:pointer; }
    .nav-brand { color:var(--brand) !important; font-weight:700; font-size:1.2rem; }
  </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-light bg-white border-bottom px-4 py-3">
  <a class="navbar-brand nav-brand" href="/">🌸 Sofia Baby Spa</a>
  <div class="d-flex gap-2">
    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary">Masuk</a>
    <a href="{{ route('register') }}" class="btn btn-sm btn-pink" style="background:var(--brand);color:#fff;border:none">Daftar</a>
  </div>
</nav>

{{-- Hero --}}
<section class="hero text-center">
  <div class="container">
    <h1>Perawatan Si Kecil,<br>Penuh Kasih Sayang</h1>
    <p class="mb-4">Layanan baby spa profesional dengan terapis bersertifikat.<br>Pijat bayi, renang, senam, dan stimulasi tumbuh kembang.</p>
    <a href="{{ route('register') }}" class="btn-hero btn-lg px-5 me-2">Daftar Sekarang</a>
    <a href="#layanan" class="btn-hero-outline btn-lg px-5">Lihat Layanan</a>
  </div>
</section>

{{-- Layanan --}}
<section id="layanan" class="py-5">
  <div class="container">
    <h2 class="text-center section-title mb-2">Layanan Kami</h2>
    <p class="text-center text-muted mb-5">Perawatan lengkap untuk si kecil.</p>
    <div class="row g-4 justify-content-center">
      @php
        $layanan = [
          ['icon'=>'🤲','nama'=>'Pijat Bayi','desc'=>'Pijat relaksasi untuk bayi 0–12 bulan','harga'=>'Rp 150.000'],
          ['icon'=>'🏊','nama'=>'Renang Bayi','desc'=>'Terapi air menyenangkan untuk bayi','harga'=>'Rp 100.000'],
          ['icon'=>'🤸','nama'=>'Senam Bayi','desc'=>'Stimulasi motorik bayi 3–12 bulan','harga'=>'Rp 120.000'],
          ['icon'=>'🌱','nama'=>'Stimulasi Tumbuh Kembang','desc'=>'Asesmen & stimulasi perkembangan anak','harga'=>'Rp 200.000'],
        ];
      @endphp
      @foreach($layanan as $s)
      <div class="col-sm-6 col-md-3">
        <div class="card card-service h-100 text-center p-4">
          <span class="svc-icon">{{ $s['icon'] }}</span>
          <h6 class="fw-semibold mb-1">{{ $s['nama'] }}</h6>
          <p class="small text-muted mb-2">{{ $s['desc'] }}</p>
          <span class="badge-price align-self-center">{{ $s['harga'] }}</span>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Kenapa --}}
<section class="py-5" style="background:var(--brand-muted)">
  <div class="container">
    <h2 class="text-center section-title mb-5">Kenapa Pilih Kami?</h2>
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="why-item"><span class="why-icon">👩‍⚕️</span>
          <div><h6 class="fw-semibold mb-1">Terapis Bersertifikat</h6><p class="small text-muted mb-0">Semua terapis terlatih dan berpengalaman.</p></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="why-item"><span class="why-icon">🏠</span>
          <div><h6 class="fw-semibold mb-1">Homecare</h6><p class="small text-muted mb-0">Layanan bisa datang ke rumah Anda.</p></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="why-item"><span class="why-icon">📊</span>
          <div><h6 class="fw-semibold mb-1">Monitoring Tumbuh Kembang</h6><p class="small text-muted mb-0">Pantau perkembangan anak secara berkala.</p></div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- FAQ --}}
<section class="py-5">
  <div class="container" style="max-width:700px">
    <h2 class="text-center section-title mb-5">Pertanyaan Umum</h2>
    <div class="accordion" id="faqAccordion">
      @php
        $faq = [
          ['q'=>'Berapa usia minimal bayi?','a'=>'Layanan pijat dan renang bayi bisa dimulai dari usia 1 bulan.'],
          ['q'=>'Apakah perlu reservasi?','a'=>'Ya, reservasi dianjurkan agar terapis bisa disiapkan sesuai kebutuhan si kecil.'],
          ['q'=>'Apakah bisa homecare?','a'=>'Ya, kami menyediakan layanan homecare untuk wilayah tertentu.'],
        ];
      @endphp
      @foreach($faq as $i => $f)
      <div class="accordion-item border-0 mb-2" style="border-radius:.75rem;overflow:hidden;box-shadow:0 1px 8px rgba(0,0,0,.04)">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}">
            {{ $f['q'] }}
          </button>
        </h2>
        <div id="faq{{ $i }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">{{ $f['a'] }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="py-5 text-center" style="background:var(--brand-muted)">
  <div class="container">
    <h3 class="fw-bold mb-3" style="color:var(--brand)">Siap Booking untuk Si Kecil?</h3>
    <p class="text-muted mb-4">Daftar sekarang dan nikmati layanan terbaik.</p>
    <a href="{{ route('register') }}" class="btn btn-hero btn-lg px-5">Daftar Sekarang</a>
  </div>
</section>

{{-- Footer --}}
<footer>
  <div class="container text-center small">
    <div class="mb-2">🌸 Sofia Baby Spa</div>
    <div class="mb-2">
      <a href="/privacy">Kebijakan Privasi</a>
      @if(($settings['landing_email'] ?? ''))
        · <a href="mailto:{{ $settings['landing_email'] }}">{{ $settings['landing_email'] }}</a>
      @endif
    </div>
    <div class="opacity-75">&copy; {{ date('Y') }} Sofia Baby Spa. Hak cipta dilindungi.</div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
