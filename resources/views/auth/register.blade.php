<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Daftar — Sofia Baby Spa</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600&display=swap"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <style>
    :root { --brand:#e83e8c; --brand-dark:#c62d78; --brand-muted:#fdf0f6; --border:#e8e7f0; }
    body { background:var(--brand-muted); font-family:'Public Sans',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:2rem 1rem; }
    .auth-wrap { width:100%; max-width:440px; }
    .auth-card { background:#fff; border-radius:1rem; padding:2.5rem 2rem; box-shadow:0 4px 24px rgba(0,0,0,.08); }
    .brand-title { color:var(--brand); font-size:1.35rem; font-weight:700; text-align:center; margin-bottom:.25rem; }
    .brand-sub { color:#6e6b7b; font-size:.85rem; text-align:center; margin-bottom:2rem; }
    .form-label { font-size:.82rem; font-weight:600; color:#3a3a4c; }
    .form-control, .form-select { font-size:.875rem; border-color:var(--border); border-radius:.45rem; }
    .form-control:focus, .form-select:focus { border-color:var(--brand); box-shadow:0 0 0 3px rgba(232,62,140,.15); }
    .btn-brand { background:var(--brand); border:none; color:#fff; font-weight:600; border-radius:.45rem; padding:.55rem 1rem; width:100%; transition:background .15s; }
    .btn-brand:hover { background:var(--brand-dark); color:#fff; }
    .alert { border-radius:.5rem; font-size:.875rem; border:none; }
    .alert-danger { background:#fee2e2; color:#991b1b; }
  </style>
</head>
<body>
<div class="auth-wrap">
  <div class="auth-card">
    <div class="brand-title">🌸 Sofia Baby Spa</div>
    <div class="brand-sub">Buat akun baru</div>

    @if($errors->any())
    <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required/>
        </div>
        <div class="col-md-6">
          <label class="form-label">No. HP</label>
          <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                 placeholder="08xxxxxxxxxx" required/>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email <span class="text-muted fw-normal">(opsional)</span></label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}"/>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required minlength="6"/>
        </div>
        <div class="col-md-6">
          <label class="form-label">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" class="form-control" required/>
        </div>
        <div class="col-12">
          <label class="form-label">Darimana tahu Sofia Baby Spa?</label>
          <select name="referral_source" class="form-select">
            <option value="">— Pilih —</option>
            <option value="Instagram" @selected(old('referral_source')==='Instagram')>Instagram</option>
            <option value="Teman/Keluarga" @selected(old('referral_source')==='Teman/Keluarga')>Teman/Keluarga</option>
            <option value="Google" @selected(old('referral_source')==='Google')>Google</option>
            <option value="TikTok" @selected(old('referral_source')==='TikTok')>TikTok</option>
            <option value="Lainnya" @selected(old('referral_source')==='Lainnya')>Lainnya</option>
          </select>
        </div>
      </div>
      <div class="mt-4">
        <button type="submit" class="btn-brand">Daftar Sekarang</button>
      </div>
    </form>

    <div class="text-center small mt-3">
      Sudah punya akun?
      <a href="{{ route('login') }}" style="color:var(--brand);font-weight:600">Masuk di sini</a>
    </div>
  </div>
</div>
</body>
</html>
