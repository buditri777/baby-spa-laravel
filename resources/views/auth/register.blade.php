<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/><meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Daftar — Sofia Baby Spa</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600&display=swap"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <style>
    body{background:#f5f5f9;font-family:'Public Sans',sans-serif;}
    .auth-card{max-width:440px;margin:60px auto;background:#fff;border-radius:1rem;padding:2rem;box-shadow:0 4px 24px rgba(0,0,0,.06);}
    .btn-primary{background:#e83e8c;border-color:#e83e8c;}
  </style>
</head>
<body>
<div class="auth-card">
  <h4 class="text-center mb-4" style="color:#e83e8c;">Daftar Akun</h4>
  @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif
  <form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Nama Lengkap</label>
      <input type="text" name="name" class="form-control" value="{{ old('name') }}" required/>
    </div>
    <div class="mb-3">
      <label class="form-label">No. HP</label>
      <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required/>
    </div>
    <div class="mb-3">
      <label class="form-label">Email (opsional)</label>
      <input type="email" name="email" class="form-control" value="{{ old('email') }}"/>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required/>
    </div>
    <div class="mb-3">
      <label class="form-label">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="form-control" required/>
    </div>
    <div class="mb-3">
      <label class="form-label">Darimana tahu Sofia Baby Spa?</label>
      <select name="referral_source" class="form-select">
        <option value="">-- Pilih --</option>
        <option value="Instagram">Instagram</option>
        <option value="Teman/Keluarga">Teman/Keluarga</option>
        <option value="Google">Google</option>
        <option value="TikTok">TikTok</option>
        <option value="Lainnya">Lainnya</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary w-100">Daftar</button>
  </form>
  <hr/>
  <p class="text-center small">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
