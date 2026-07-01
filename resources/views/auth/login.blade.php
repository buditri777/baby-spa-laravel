<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Login — Sofia Baby Spa</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css"/>
  <style>
    body{background:#f5f5f9;font-family:'Public Sans',sans-serif;}
    .auth-card{max-width:420px;margin:80px auto;background:#fff;border-radius:1rem;padding:2rem;box-shadow:0 4px 24px rgba(0,0,0,.06);}
    .brand{text-align:center;margin-bottom:1.5rem;}
    .brand-title{color:#e83e8c;font-size:1.5rem;font-weight:700;}
    .btn-primary{background:#e83e8c;border-color:#e83e8c;}
    .btn-primary:hover{background:#d63384;border-color:#d63384;}
  </style>
</head>
<body>
<div class="auth-card">
  <div class="brand">
    <i class='bx bx-heart fs-1 text-danger'></i>
    <div class="brand-title">Sofia Baby Spa</div>
    <p class="text-muted small">Masuk ke akun Anda</p>
  </div>
  @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Email / No. HP</label>
      <input type="text" name="login" class="form-control @error('login') is-invalid @enderror"
             value="{{ old('login') }}" placeholder="email@example.com atau 081234..." required autofocus/>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <div class="input-group">
        <input type="password" name="password" id="pwd" class="form-control" required/>
        <button type="button" class="btn btn-outline-secondary" onclick="togglePwd()">
          <i class='bx bx-show' id="eye-icon"></i>
        </button>
      </div>
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" name="remember" id="remember"/>
      <label class="form-check-label" for="remember">Ingat saya</label>
    </div>
    <button type="submit" class="btn btn-primary w-100">Masuk</button>
  </form>
  <hr/>
  <p class="text-center small">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
  <p class="text-center small text-muted">Lupa password? Hubungi admin.</p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd(){
  const p=document.getElementById('pwd'),e=document.getElementById('eye-icon');
  p.type=p.type==='password'?'text':'password';
  e.className=p.type==='password'?'bx bx-show':'bx bx-hide';
}
</script>
</body>
</html>
