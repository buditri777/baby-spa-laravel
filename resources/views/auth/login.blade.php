<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Login — Sofia Baby Spa</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <style>
    :root { --brand:#e83e8c; --brand-dark:#c62d78; --brand-muted:#fdf0f6; --border:#e8e7f0; }
    body { background:var(--brand-muted); font-family:'Public Sans',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; }
    .auth-wrap { width:100%; max-width:420px; padding:1rem; }
    .auth-card { background:#fff; border-radius:1rem; padding:2.5rem 2rem; box-shadow:0 4px 24px rgba(0,0,0,.08); }
    .brand-icon { font-size:3rem; color:var(--brand); display:block; text-align:center; }
    .brand-title { color:var(--brand); font-size:1.35rem; font-weight:700; text-align:center; margin-bottom:.25rem; }
    .brand-sub { color:#6e6b7b; font-size:.85rem; text-align:center; margin-bottom:2rem; }
    .form-label { font-size:.82rem; font-weight:600; color:#3a3a4c; }
    .form-control { font-size:.875rem; border-color:var(--border); border-radius:.45rem; }
    .form-control:focus { border-color:var(--brand); box-shadow:0 0 0 3px rgba(232,62,140,.15); }
    .btn-brand { background:var(--brand); border:none; color:#fff; font-weight:600; border-radius:.45rem; padding:.55rem 1rem; width:100%; transition:background .15s; }
    .btn-brand:hover { background:var(--brand-dark); color:#fff; }
    .divider { text-align:center; color:#aaa; font-size:.8rem; margin:1rem 0; position:relative; }
    .divider::before,.divider::after { content:''; position:absolute; top:50%; width:42%; height:1px; background:var(--border); }
    .divider::before { left:0; } .divider::after { right:0; }
    .alert { border-radius:.5rem; font-size:.875rem; border:none; }
    .alert-danger { background:#fee2e2; color:#991b1b; }
  </style>
</head>
<body>
<div class="auth-wrap">
  <div class="auth-card">
    <span class="brand-icon">🌸</span>
    <div class="brand-title">Sofia Baby Spa</div>
    <div class="brand-sub">Masuk ke akun Anda</div>

    @if($errors->any())
    <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
    @endif

    @if(session('status'))
    <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Email / No. HP</label>
        <input type="text" name="login" class="form-control @error('login') is-invalid @enderror"
               value="{{ old('login') }}" placeholder="email@example.com atau 081234…"
               required autofocus/>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
          <input type="password" name="password" id="pwd" class="form-control" required/>
          <button type="button" class="btn btn-outline-secondary" onclick="togglePwd()" tabindex="-1">
            <span id="eyeIcon">👁</span>
          </button>
        </div>
      </div>
      <div class="mb-4 d-flex justify-content-between align-items-center">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" name="remember" id="remember"/>
          <label class="form-check-label small" for="remember">Ingat saya</label>
        </div>
      </div>
      <button type="submit" class="btn-brand">Masuk</button>
    </form>

    <div class="divider">atau</div>
    <div class="text-center small">
      Belum punya akun?
      <a href="{{ route('register') }}" style="color:var(--brand);font-weight:600">Daftar sekarang</a>
    </div>
  </div>
</div>
<script>
function togglePwd() {
  const p = document.getElementById('pwd');
  p.type = p.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
