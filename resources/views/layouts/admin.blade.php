<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Peta Parkir Salatiga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family:'Plus Jakarta Sans',sans-serif; }
        body { background:#f1f5f9; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            min-height:100vh; width:250px;
            position:fixed; top:0; left:0;
            background:#0b1120;
            padding:0; z-index:100;
            display:flex; flex-direction:column;
            border-right:1px solid rgba(255,255,255,0.05);
        }
        .sidebar-brand {
            padding:18px 20px;
            border-bottom:1px solid rgba(255,255,255,0.06);
            display:flex; align-items:center; gap:10px;
        }
        .sidebar-brand .logo {
            width:34px; height:34px;
            background:linear-gradient(135deg,#f59e0b,#ef4444);
            border-radius:9px;
            display:flex; align-items:center; justify-content:center;
            font-size:16px; flex-shrink:0;
        }
        .sidebar-brand .brand-text { color:#fff; font-weight:700; font-size:0.9rem; line-height:1.2; }
        .sidebar-brand .brand-sub { color:rgba(255,255,255,0.35); font-size:0.68rem; }

        .sidebar-nav { padding:12px 10px; flex:1; }
        .nav-label {
            color:rgba(255,255,255,0.25); font-size:0.65rem;
            font-weight:700; letter-spacing:0.1em;
            text-transform:uppercase; padding:10px 10px 5px;
        }
        .sidebar .nav-link {
            color:rgba(255,255,255,0.55);
            border-radius:9px; padding:9px 12px;
            font-size:0.82rem; font-weight:500;
            display:flex; align-items:center; gap:9px;
            transition:all .15s; margin-bottom:2px;
        }
        .sidebar .nav-link:hover { color:#fff; background:rgba(255,255,255,0.07); }
        .sidebar .nav-link.active { color:#fff; background:rgba(59,130,246,0.2); }
        .sidebar .nav-link.active i { color:#60a5fa; }
        .sidebar .nav-link i { font-size:0.95rem; width:18px; text-align:center; }

        /* Tombol Lihat Peta — spesial */
        .btn-view-map {
            display:flex; align-items:center; gap:9px;
            margin:0 10px 10px;
            padding:10px 14px; border-radius:10px;
            background:linear-gradient(135deg,rgba(59,130,246,0.2),rgba(99,102,241,0.2));
            border:1px solid rgba(99,102,241,0.3);
            color:#a5b4fc; font-size:0.82rem; font-weight:600;
            text-decoration:none; transition:all .2s;
        }
        .btn-view-map:hover {
            background:linear-gradient(135deg,rgba(59,130,246,0.35),rgba(99,102,241,0.35));
            color:#c7d2fe; border-color:rgba(99,102,241,0.5);
            transform:translateY(-1px);
        }
        .btn-view-map i { font-size:1rem; }
        .btn-view-map .arrow { margin-left:auto; font-size:0.7rem; opacity:0.6; }

        .sidebar-footer {
            padding:12px 10px;
            border-top:1px solid rgba(255,255,255,0.06);
        }
        .logout-btn {
            display:flex; align-items:center; gap:9px;
            width:100%; padding:9px 12px; border-radius:9px;
            color:rgba(239,68,68,0.7); font-size:0.82rem; font-weight:500;
            background:none; border:none; cursor:pointer;
            transition:all .15s; text-align:left;
        }
        .logout-btn:hover { color:#fca5a5; background:rgba(239,68,68,0.1); }

        /* ===== MAIN CONTENT ===== */
        .main-content { margin-left:250px; min-height:100vh; }

        /* ===== TOPBAR ===== */
        .topbar {
            background:#fff;
            border-bottom:1px solid #e2e8f0;
            padding:0 28px;
            height:60px;
            display:flex; align-items:center; justify-content:space-between;
            position:sticky; top:0; z-index:50;
        }
        .page-title { font-size:1.1rem; font-weight:700; color:#0f172a; }
        .page-subtitle { font-size:0.75rem; color:#94a3b8; }
        .user-pill {
            display:flex; align-items:center; gap:8px;
            background:#f8fafc; border:1px solid #e2e8f0;
            border-radius:99px; padding:5px 14px 5px 6px;
            font-size:0.8rem; color:#374151; font-weight:500;
        }
        .user-avatar {
            width:28px; height:28px; border-radius:50%;
            background:linear-gradient(135deg,#6366f1,#8b5cf6);
            display:flex; align-items:center; justify-content:center;
            color:#fff; font-size:0.72rem; font-weight:700;
        }

        /* ===== PAGE BODY ===== */
        .page-body { padding:24px 28px; }

        /* ===== CARDS ===== */
        .card { border:none; border-radius:14px; box-shadow:0 1px 3px rgba(0,0,0,0.06); }
        .stat-card {
            border-radius:14px; padding:20px;
            color:#fff; position:relative; overflow:hidden;
        }
        .stat-card .bg-icon {
            position:absolute; right:12px; top:12px;
            font-size:2.5rem; opacity:0.15;
        }
        .stat-card .num { font-size:2rem; font-weight:700; line-height:1; }
        .stat-card .lbl { font-size:0.75rem; opacity:0.8; margin-top:5px; }

        /* ===== ALERTS ===== */
        .alert { border:none; border-radius:10px; }
        .alert-success { background:#f0fdf4; color:#166534; border-left:3px solid #22c55e; }

        /* ===== PETA MINI ===== */
        #mini-map { width:100%; height:100%; border-radius:12px; }
        .map-card { height:360px; overflow:hidden; position:relative; }
        .map-card .leaflet-container { border-radius:12px; }

        @media (max-width:768px) {
            .sidebar { display:none; }
            .main-content { margin-left:0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <div class="logo">🅿️</div>
        <div>
            <div class="brand-text">Peta Parkir</div>
            <div class="brand-sub">Kota Salatiga</div>
        </div>
    </div>

    <div class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="{{ route('admin.parking.index') }}"
           class="nav-link @if(request()->routeIs('admin.parking.*')) active @endif">
            <i class="bi bi-p-circle-fill"></i> Data Parkir
        </a>
        <a href="{{ route('admin.parking.create') }}"
           class="nav-link @if(request()->routeIs('admin.parking.create')) active @endif">
            <i class="bi bi-plus-circle"></i> Tambah Parkir
        </a>
    </div>

    {{-- Tombol Lihat Peta --}}
    <a href="{{ route('map') }}" target="_blank" class="btn-view-map">
        <i class="bi bi-map-fill"></i>
        <span>Buka Peta Publik</span>
        <span class="arrow">↗</span>
    </a>

    <div class="sidebar-footer">
        <div style="font-size:0.68rem;color:rgba(255,255,255,0.2);padding:0 4px 8px;text-transform:uppercase;letter-spacing:.06em">Akun</div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div>
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
            <div class="page-subtitle">@yield('page-subtitle', 'Sistem Informasi Peta Parkir Salatiga')</div>
        </div>
        <div class="user-pill">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            {{ auth()->user()->name ?? 'Admin' }}
        </div>
    </div>

    <div class="page-body">
        @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
