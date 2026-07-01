<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Spa — Selamat Datang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { background: #fff5f8; }
        .hero { background: linear-gradient(135deg, #e91e8c 0%, #ff6eb4 100%); color: #fff; padding: 80px 0 60px; }
        .hero h1 { font-size: 2.5rem; font-weight: 700; }
        .hero p { font-size: 1.15rem; opacity: .9; }
        .card-service { border: none; border-radius: 16px; box-shadow: 0 2px 16px rgba(233,30,140,.1); transition: transform .2s; }
        .card-service:hover { transform: translateY(-4px); }
        .badge-price { background: #fff0f8; color: #e91e8c; font-size: .95rem; border-radius: 8px; padding: 4px 12px; }
        footer { background: #e91e8c; color: #fff; padding: 24px 0; }
    </style>
</head>
<body>

{{-- Hero --}}
<section class="hero text-center">
    <div class="container">
        <h1>🌸 Baby Spa</h1>
        <p class="mb-4">Layanan perawatan & tumbuh kembang si kecil, penuh kasih sayang</p>
        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5 fw-semibold" style="color:#e91e8c">
            Masuk ke Aplikasi
        </a>
        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5 ms-2">
            Daftar Sekarang
        </a>
    </div>
</section>

{{-- Layanan --}}
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4" style="color:#e91e8c">Layanan Kami</h2>
        <div class="row g-4 justify-content-center">
            @php
                $layanan = [
                    ['icon'=>'🤲','nama'=>'Pijat Bayi','desc'=>'Pijat relaksasi untuk bayi 0–12 bulan','harga'=>'Rp 150.000'],
                    ['icon'=>'🏊','nama'=>'Renang Bayi','desc'=>'Terapi air menyenangkan untuk bayi','harga'=>'Rp 100.000'],
                    ['icon'=>'🤸','nama'=>'Senam Bayi','desc'=>'Stimulasi motorik bayi 3–12 bulan','harga'=>'Rp 120.000'],
                    ['icon'=>'🌱','nama'=>'Stimulasi Tumbuh Kembang','desc'=>'Stimulasi sensorik & motorik terarah','harga'=>'Rp 175.000'],
                    ['icon'=>'🏠','nama'=>'Pijat Homecare','desc'=>'Layanan pijat di rumah pelanggan','harga'=>'Rp 200.000'],
                ];
            @endphp
            @foreach($layanan as $l)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card card-service h-100 p-3 text-center">
                    <div style="font-size:2.5rem">{{ $l['icon'] }}</div>
                    <h5 class="fw-bold mt-2 mb-1">{{ $l['nama'] }}</h5>
                    <p class="text-muted small mb-2">{{ $l['desc'] }}</p>
                    <span class="badge-price">{{ $l['harga'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Keunggulan --}}
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center fw-bold mb-4" style="color:#e91e8c">Mengapa Pilih Kami?</h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="fs-1">👩‍⚕️</div>
                <h5 class="fw-bold">Terapis Terlatih</h5>
                <p class="text-muted">Semua terapis bersertifikat & berpengalaman menangani bayi</p>
            </div>
            <div class="col-md-4">
                <div class="fs-1">📱</div>
                <h5 class="fw-bold">Booking Online</h5>
                <p class="text-muted">Pesan sesi kapan saja lewat aplikasi atau WhatsApp</p>
            </div>
            <div class="col-md-4">
                <div class="fs-1">📊</div>
                <h5 class="fw-bold">Pantau Tumbuh Kembang</h5>
                <p class="text-muted">Rekam & pantau BB, TB, dan milestone si kecil</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-5 text-center" style="background:#fff5f8">
    <div class="container">
        <h3 class="fw-bold mb-3" style="color:#e91e8c">Siap memberi yang terbaik untuk si kecil?</h3>
        <a href="{{ route('register') }}" class="btn btn-lg px-5 fw-semibold" style="background:#e91e8c;color:#fff">
            Daftar Gratis Sekarang
        </a>
    </div>
</section>

<footer class="text-center">
    <p class="mb-0">&copy; {{ date('Y') }} Baby Spa. Semua hak dilindungi.</p>
</footer>

</body>
</html>
