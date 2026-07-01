<!DOCTYPE html>
<html lang="id" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Sofia Baby Spa')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" />
  <!-- Sneat CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <style>
    :root { --bs-primary: #e83e8c; --bs-primary-rgb: 232,62,140; }
    body { font-family: 'Public Sans', sans-serif; background: #f5f5f9; }
    .app-brand { display:flex; align-items:center; gap:.5rem; padding:1.5rem 1rem; }
    .app-brand-text { font-size:1.25rem; font-weight:700; color:#e83e8c; }
    .layout-menu { width:260px; background:#fff; min-height:100vh; border-right:1px solid #e0e0e0; position:fixed; top:0; left:0; z-index:1000; overflow-y:auto; }
    .layout-page { margin-left:260px; }
    .navbar-top { background:#fff; border-bottom:1px solid #e0e0e0; padding:.75rem 1.5rem; display:flex; align-items:center; justify-content:space-between; }
    .menu-item a { display:flex; align-items:center; gap:.75rem; padding:.6rem 1.25rem; color:#697a8d; text-decoration:none; border-radius:.375rem; margin:.1rem .75rem; transition:all .15s; }
    .menu-item a:hover, .menu-item a.active { background:#fce4f0; color:#e83e8c; }
    .menu-header { font-size:.7rem; font-weight:700; letter-spacing:.08em; color:#a1acb8; text-transform:uppercase; padding:.75rem 1.25rem .25rem; }
    .stat-card { border-radius:.75rem; padding:1.25rem; color:#fff; }
    @media(max-width:991px) { .layout-menu{transform:translateX(-100%);transition:.3s;} .layout-page{margin-left:0;} }
  </style>
  @stack('styles')
</head>
<body>
<div class="d-flex">
  <!-- Sidebar -->
  <div class="layout-menu">
    <div class="app-brand">
      <span class="bx bx-heart fs-3 text-pink"></span>
      <span class="app-brand-text">Sofia Baby Spa</span>
    </div>
    <ul class="list-unstyled mb-0">
      @include('layouts.sidebar')
    </ul>
  </div>
  <!-- Main -->
  <div class="layout-page w-100">
    <nav class="navbar-top">
      <span class="fw-semibold text-muted">@yield('page-title', 'Dashboard')</span>
      <div class="d-flex align-items-center gap-3">
        <span class="text-muted small">{{ auth()->user()->name }}</span>
        <span class="badge bg-pink text-white">{{ auth()->user()->role }}</span>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button class="btn btn-sm btn-outline-secondary">
            <i class='bx bx-log-out'></i> Keluar
          </button>
        </form>
      </div>
    </nav>
    <div class="container-fluid p-4">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
          {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
          {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif
      @yield('content')
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
