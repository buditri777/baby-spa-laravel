<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sofia Baby Spa</title>
  <meta name="description" content="Sofia Baby Spa — Layanan perawatan & tumbuh kembang si kecil.">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    :root { --brand:#e83e8c; --brand-dark:#c62d78; --brand-light:#ff85b3; --brand-muted:#fdf0f6; }
    body { font-family:'Public Sans',sans-serif; margin:0; background:#fff; color:#3a3a4c; }
    .hero { background:linear-gradient(135deg,var(--brand) 0%,var(--brand-light) 100%); color:#fff; padding:120px 0 100px; text-align:center; }
    .hero h1 { font-size:3rem; font-weight:700; margin-bottom:1rem; }
    .hero p { font-size:1.2rem; opacity:.92; margin-bottom:2rem; max-width:600px; margin-left:auto;margin-right:auto; }
    .btn-hero { background:#fff; color:var(--brand); font-weight:600; border-radius:.5rem; padding:.7rem 2rem; border:none; font-size:1.05rem; transition:all .15s; text-decoration:none; display:inline-block; }
    .btn-hero:hover { background:#fff0f6; transform:translateY(-2px); }
    .btn-hero-outline { color:#fff; border:2px solid rgba(255,255,255,.7); border-radius:.5rem; padding:.65rem 2rem; font-weight:600; background:transparent; font-size:1.05rem; transition:all .15s; text-decoration:none; display:inline-block; }
    .btn-hero-outline:hover { background:rgba(255,255,255,.15); color:#fff; border-color:#fff; }
    .features { padding:80px 0; }
    .feat-card { text-align:center; padding:2rem 1.5rem; border-radius:1rem; background:var(--brand-muted); height:100%; }
    .feat-icon { font-size:2.5rem; margin-bottom:1rem; display:block; }
    .cta-section { padding:80px 0; text-align:center; background:var(--brand-muted); }
    footer { background:var(--brand); color:#fff; padding:2rem 0; text-align:center; }
    footer a { color:rgba(255,255,255,.8); text-decoration:none; }
    footer a:hover { color:#fff; }
  </style>
</head>
<body>

<section class="hero">
  <div class="container">
    <div style="font-size:4rem;margin-bottom:1rem">🌸</div>
    <h1>Sofia Baby Spa</h1>
    <p>Platform perawatan & monitoring tumbuh kembang si kecil, dari lahir hingga balita.</p>
    <div class="d-flex gap-3 justify-content-center flex-wrap">
      <a href="{{ route('login') }}" class="btn-hero">Masuk</a>
      <a href="{{ route('register') }}" class="btn-hero-outline">Daftar Gratis</a>
    </div>
  </div>
</section>

<section class="features">
  <div class="container">
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="feat-card">
          <span class="feat-icon">🤲</span>
          <h5 class="fw-semibold mb-2">Baby Spa & Pijat</h5>
          <p class="text-muted mb-0 small">Pijat relaksasi oleh terapis bersertifikat.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feat-card">
          <span class="feat-icon">📊</span>
          <h5 class="fw-semibold mb-2">Monitoring Tumbuh Kembang</h5>
          <p class="text-muted mb-0 small">Catat BB, TB, dan milestone perkembangan.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feat-card">
          <span class="feat-icon">🏠</span>
          <h5 class="fw-semibold mb-2">Layanan Homecare</h5>
          <p class="text-muted mb-0 small">Terapis datang ke rumah Anda.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta-section">
  <div class="container">
    <h3 class="fw-bold mb-3" style="color:var(--brand)">Mulai Sekarang</h3>
    <p class="text-muted mb-4">Daftar gratis dan booking layanan untuk si kecil.</p>
    <a href="{{ route('register') }}" class="btn-hero px-5">Daftar</a>
  </div>
</section>

<footer>
  <div class="container small">
    <div class="mb-2">&copy; {{ date('Y') }} Sofia Baby Spa</div>
    <a href="/privacy">Kebijakan Privasi</a>
  </div>
</footer>

</body>
</html>
