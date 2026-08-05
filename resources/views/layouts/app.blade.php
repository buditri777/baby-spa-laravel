<!doctype html>
<html lang="id" class="layout-menu-fixed" data-assets-path="{{ asset('sneat/') }}" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>@yield('title', 'Sofia Baby Spa')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Sneat Core -->
  <link rel="stylesheet" href="{{ asset('sneat/vendor/fonts/iconify-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('sneat/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('sneat/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('sneat/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

  <!-- Brand design tokens + component overrides -->
  <style>
    /* ── Design Tokens ── */
    :root {
      --brand:        #e83e8c;
      --brand-rgb:    232,62,140;
      --brand-dark:   #c62d78;
      --brand-light:  #fce4ef;
      --brand-muted:  #fdf0f6;

      --bs-primary:          var(--brand) !important;
      --bs-primary-rgb:      var(--brand-rgb) !important;
      --bs-body-font-family: 'Public Sans', system-ui, sans-serif;
      --bs-body-font-size:   0.9rem;
      --bs-body-color:       #3a3a4c;
      --bs-border-radius:    0.5rem;

      --surface:     #fff;
      --surface-2:   #f8f7fb;
      --ink:         #3a3a4c;
      --ink-muted:   #6e6b7b;
      --border:      #e8e7f0;

      /* Semantic status colors */
      --status-confirmed: #0d6efd;
      --status-completed: #198754;
      --status-cancelled: #dc3545;
      --status-noshow:    #6c757d;
      --status-pending:   #fd7e14;
    }

    /* ── Base ── */
    body { color: var(--ink); background: var(--surface-2); }

    /* ── Brand buttons ── */
    .btn-primary,
    .btn-pink {
      background-color: var(--brand) !important;
      border-color: var(--brand) !important;
      color: #fff !important;
      font-weight: 500;
    }
    .btn-primary:hover, .btn-pink:hover {
      background-color: var(--brand-dark) !important;
      border-color: var(--brand-dark) !important;
    }
    .btn-outline-primary {
      color: var(--brand) !important;
      border-color: var(--brand) !important;
    }
    .btn-outline-primary:hover {
      background-color: var(--brand) !important;
      color: #fff !important;
    }
    .text-primary { color: var(--brand) !important; }
    .bg-primary   { background-color: var(--brand) !important; }

    /* ── Sidebar ── */
    .layout-menu { border-right: 1px solid var(--border); }
    .menu-item.active > .menu-link,
    .menu-link.active {
      color: var(--brand) !important;
      background: var(--brand-muted) !important;
      border-radius: 0.4rem;
    }
    .menu-link:hover { background: var(--brand-muted) !important; border-radius: 0.4rem; }
    .menu-header-text { color: var(--ink-muted) !important; font-size: 0.7rem; letter-spacing: 0.06em; font-weight: 600; }
    .app-brand-text { color: var(--brand) !important; font-weight: 700; font-size: 1rem; }

    /* ── Navbar ── */
    .layout-navbar { border-bottom: 1px solid var(--border); background: var(--surface) !important; }

    /* ── Cards ── */
    .card {
      border: 1px solid var(--border);
      border-radius: 0.75rem;
      box-shadow: 0 1px 4px rgba(0,0,0,0.06) !important;
    }
    .card-header {
      background: var(--surface) !important;
      border-bottom: 1px solid var(--border);
      padding: 1rem 1.25rem;
      font-weight: 600;
      font-size: 0.9rem;
      color: var(--ink);
      border-radius: 0.75rem 0.75rem 0 0 !important;
    }
    .card-body { padding: 1.25rem; }

    /* ── Stat cards ── */
    .stat-card {
      border-radius: 0.75rem;
      padding: 1rem 1.25rem;
      color: #fff;
      min-height: 80px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    }
    .stat-card .stat-label { font-size: 0.78rem; opacity: 0.88; font-weight: 500; }
    .stat-card .stat-value { font-size: 1.5rem; font-weight: 700; line-height: 1.2; }
    .stat-card.brand  { background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%); }
    .stat-card.green  { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); }
    .stat-card.purple { background: linear-gradient(135deg, #6f42c1 0%, #563d7c 100%); }
    .stat-card.teal   { background: linear-gradient(135deg, #20c997 0%, #17a589 100%); }

    /* ── Tables ── */
    .table { font-size: 0.855rem; }
    .table thead th {
      background: var(--surface-2);
      color: var(--ink-muted);
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      border-bottom: 1px solid var(--border);
      padding: 0.65rem 0.75rem;
      white-space: nowrap;
    }
    .table tbody tr { border-bottom: 1px solid var(--border); }
    .table tbody tr:last-child { border-bottom: none; }
    .table tbody td { padding: 0.7rem 0.75rem; vertical-align: middle; }
    .table-hover tbody tr:hover { background: var(--brand-muted); }
    /* Remove table-light override */
    .table-light > * { background: transparent !important; }

    /* ── Badges ── */
    .badge { font-size: 0.72rem; font-weight: 600; padding: 0.3em 0.65em; border-radius: 0.4em; }
    .badge-completed { background: #d1fae5; color: #065f46; }
    .badge-confirmed { background: #dbeafe; color: #1e40af; }
    .badge-cancelled { background: #fee2e2; color: #991b1b; }
    .badge-noshow    { background: #f3f4f6; color: #374151; }
    .badge-pending   { background: #fff3cd; color: #92400e; }
    .badge-active    { background: #d1fae5; color: #065f46; }
    .badge-inactive  { background: #f3f4f6; color: #6b7280; }

    /* ── Forms ── */
    .form-label { font-size: 0.82rem; font-weight: 600; color: var(--ink); margin-bottom: 0.3rem; }
    .form-control, .form-select {
      font-size: 0.875rem;
      border-color: var(--border);
      border-radius: 0.45rem;
      padding: 0.45rem 0.75rem;
      color: var(--ink);
      transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--brand);
      box-shadow: 0 0 0 3px rgba(var(--brand-rgb), 0.15);
    }
    .form-control-sm, .form-select-sm { font-size: 0.825rem; padding: 0.35rem 0.65rem; }

    /* ── Page header ── */
    .page-header { margin-bottom: 1.5rem; }
    .page-header h4, .page-header h5 {
      font-size: 1.15rem; font-weight: 700; color: var(--ink); margin-bottom: 0.2rem;
    }
    .page-sub { font-size: 0.82rem; color: var(--ink-muted); margin: 0; }

    /* ── Alerts ── */
    .alert { border-radius: 0.6rem; font-size: 0.875rem; border: none; }
    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-danger  { background: #fee2e2; color: #991b1b; }
    .alert-info    { background: #dbeafe; color: #1e40af; }
    .alert-warning { background: #fff3cd; color: #92400e; }

    /* ── Avatar ── */
    .avatar-initial { background: var(--brand) !important; font-weight: 600; }

    /* ── Utility ── */
    .text-muted { color: var(--ink-muted) !important; }
    .border-brand { border-color: var(--brand) !important; }
    .bg-brand-light { background: var(--brand-light) !important; }

    /* ── Reduced motion ── */
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { transition: none !important; animation: none !important; }
    }
  </style>

  <script src="{{ asset('sneat/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('sneat/js/config.js') }}"></script>
  @stack('styles')
</head>
<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <!-- Sidebar Menu -->
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo me-1">
              <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C10.477 0 6 4.477 6 10C6 15.523 10.477 20 16 20C21.523 20 26 15.523 26 10C26 4.477 21.523 0 16 0Z" fill="#e83e8c"/>
                <path d="M16 4C12.686 4 10 6.686 10 10C10 13.314 12.686 16 16 16C19.314 16 22 13.314 22 10C22 6.686 19.314 4 16 4Z" fill="white"/>
              </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold">Sofia Baby Spa</span>
          </a>
          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="menu-toggle-icon d-xl-none align-middle" height="20" width="20">
              <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          @include('layouts.sidebar')
        </ul>
      </aside>
      <!-- / Sidebar -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="menu-toggle-icon align-middle" height="24" width="24">
                <line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>
              </svg>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">
            <div class="navbar-nav align-items-center">
              <span class="nav-item nav-link fw-semibold text-muted">@yield('page-title', 'Dashboard')</span>
            </div>
            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <span class="avatar-initial rounded-circle bg-primary">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="{{ route('akun') }}">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <span class="avatar-initial rounded-circle bg-primary">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                          <small class="text-muted">{{ auth()->user()->role }}</small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li><div class="dropdown-divider"></div></li>
                  <li>
                    <a class="dropdown-item" href="{{ route('akun') }}">
                      <span class="iconify me-2" data-icon="tabler:user-cog"></span> Profil
                    </a>
                  </li>
                  <li><div class="dropdown-divider"></div></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="dropdown-item text-danger">
                        <span class="iconify me-2" data-icon="tabler:logout"></span> Keluar
                      </button>
                    </form>
                  </li>
                </ul>
              </li>
              <!-- /User -->
            </ul>
          </div>
        </nav>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">

            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="iconify me-2" data-icon="tabler:check"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="iconify me-2" data-icon="tabler:alert-circle"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            @yield('content')

          </div>
          <div class="content-backdrop fade"></div>
        </div>
        <!-- / Content wrapper -->

      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <script src="{{ asset('sneat/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('sneat/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('sneat/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('sneat/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('sneat/vendor/js/menu.js') }}"></script>
  <script src="{{ asset('sneat/js/main.js') }}"></script>
  <script src="{{ asset('sneat/fonts/iconify/iconify.js') }}"></script>
  @stack('scripts')
</body>
</html>
