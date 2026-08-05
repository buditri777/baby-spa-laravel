<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kebijakan Privasi — Sofia Baby Spa</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;600;700&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    :root { --brand:#e83e8c; --brand-muted:#fdf0f6; }
    body { font-family:'Public Sans',sans-serif; background:var(--brand-muted); color:#3a3a4c; }
    .nav-brand { color:var(--brand) !important; font-weight:700; }
  </style>
</head>
<body>
<nav class="navbar navbar-light bg-white border-bottom px-4 py-3">
  <a class="navbar-brand nav-brand" href="/">🌸 Sofia Baby Spa</a>
  <a href="/login" class="btn btn-sm btn-outline-secondary">Masuk</a>
</nav>
<div class="container py-5" style="max-width:760px">
  <h1 class="fw-bold mb-4">Kebijakan Privasi</h1>
  @php
    $content = \App\Models\Setting::where('key','privacy_policy')->value('value');
  @endphp
  @if($content)
    <div class="card"><div class="card-body">{!! nl2br(e($content)) !!}</div></div>
  @else
  <div class="card">
    <div class="card-body">
      <h5 class="fw-semibold">1. Pengumpulan Data</h5>
      <p>Kami mengumpulkan data yang Anda berikan saat mendaftar dan menggunakan layanan Sofia Baby Spa, termasuk nama, nomor telepon, alamat email, dan data anak.</p>
      <h5 class="fw-semibold">2. Penggunaan Data</h5>
      <p>Data digunakan untuk mengelola booking, mengirim notifikasi layanan, dan meningkatkan kualitas pelayanan kami.</p>
      <h5 class="fw-semibold">3. Keamanan Data</h5>
      <p>Kami menjaga keamanan data Anda dengan enkripsi dan tidak membagikan data kepada pihak ketiga tanpa persetujuan Anda.</p>
      <h5 class="fw-semibold">4. Kontak</h5>
      <p>Pertanyaan terkait privasi dapat dikirim ke: <a href="mailto:admin@sofiababyspa.com" style="color:var(--brand)">admin@sofiababyspa.com</a></p>
      <p class="text-muted small mt-4">Terakhir diperbarui: {{ date('d F Y') }}</p>
    </div>
  </div>
  @endif
  <a href="/" class="btn btn-outline-secondary mt-4">&larr; Kembali</a>
</div>
</body>
</html>
