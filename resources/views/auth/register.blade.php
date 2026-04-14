<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Peta Parkir Salatiga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family:'Plus Jakarta Sans',sans-serif; box-sizing:border-box; }
        body {
            min-height:100vh; margin:0;
            background:#0b1120;
            display:flex; align-items:center; justify-content:center;
            position:relative; overflow:hidden;
        }
        .bg-deco { position:absolute; inset:0; overflow:hidden; pointer-events:none; }
        .bg-circle { position:absolute; border-radius:50%; }
        .bg-circle-1 { width:600px; height:600px; top:-150px; right:-100px; background:radial-gradient(circle, rgba(99,102,241,0.1), transparent 70%); }
        .bg-circle-2 { width:400px; height:400px; bottom:-100px; left:-100px; background:radial-gradient(circle, rgba(245,158,11,0.07), transparent 70%); }
        .bg-grid {
            position:absolute; inset:0;
            background-image: linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .card-wrap { position:relative; z-index:10; width:100%; max-width:440px; padding:20px; }
        .logo-area { text-align:center; margin-bottom:24px; }
        .logo-mark { display:inline-flex; flex-direction:column; align-items:center; gap:12px; }
        .logo-icon-wrap {
            width:72px; height:72px; border-radius:20px;
            background:linear-gradient(135deg,#f59e0b,#ef4444);
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 8px 32px rgba(245,158,11,0.3);
        }
        .logo-icon-wrap svg { width:42px; height:42px; }
        .logo-title { font-size:1.35rem; font-weight:800; color:#fff; line-height:1.1; letter-spacing:-0.02em; }
        .logo-sub { font-size:0.78rem; color:rgba(255,255,255,0.4); font-weight:400; }
        .form-card {
            background:rgba(255,255,255,0.04);
            border:1px solid rgba(255,255,255,0.08);
            border-radius:20px; padding:28px;
        }
        .form-label { font-size:0.82rem; font-weight:600; color:rgba(255,255,255,0.7); margin-bottom:6px; }
        .form-control {
            background:rgba(255,255,255,0.06) !important;
            border:1px solid rgba(255,255,255,0.1) !important;
            border-radius:10px !important; color:#fff !important;
            font-size:0.88rem; padding:10px 14px;
            transition:border-color .2s;
        }
        .form-control:focus {
            background:rgba(255,255,255,0.09) !important;
            border-color:rgba(59,130,246,0.5) !important;
            box-shadow:0 0 0 3px rgba(59,130,246,0.15) !important;
            color:#fff !important;
        }
        .form-control::placeholder { color:rgba(255,255,255,0.25) !important; }
        .btn-register {
            width:100%; padding:11px;
            background:linear-gradient(135deg,#f59e0b,#ef4444);
            border:none; border-radius:10px;
            color:#fff; font-weight:700; font-size:0.9rem;
            cursor:pointer; transition:all .2s;
            box-shadow:0 4px 16px rgba(245,158,11,0.3);
        }
        .btn-register:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(245,158,11,0.4); }
        .invalid-feedback { font-size:0.78rem; color:#fca5a5; }
        .link-blue { color:#60a5fa; text-decoration:none; font-size:0.8rem; font-weight:600; }
        .link-blue:hover { color:#93c5fd; }
        .divider-or { display:flex; align-items:center; gap:12px; margin:16px 0; }
        .divider-or::before, .divider-or::after { content:''; flex:1; height:1px; background:rgba(255,255,255,0.08); }
        .divider-or span { font-size:0.72rem; color:rgba(255,255,255,0.3); }
        .back-link {
            display:inline-flex; align-items:center; gap:6px;
            font-size:0.78rem; color:rgba(255,255,255,0.4);
            text-decoration:none; margin-bottom:20px; transition:color .2s;
        }
        .back-link:hover { color:rgba(255,255,255,0.7); }
        .hint-text { font-size:0.72rem; color:rgba(255,255,255,0.3); margin-top:4px; }
    </style>
</head>
<body>
<div class="bg-deco">
    <div class="bg-grid"></div>
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>
</div>

<div class="card-wrap">
    <a href="/" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke Peta
    </a>

    <div class="logo-area">
        <div class="logo-mark">
            <div class="logo-icon-wrap">
                <svg viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 4C15.477 4 11 8.477 11 14C11 20.5 21 32 21 32C21 32 31 20.5 31 14C31 8.477 26.523 4 21 4Z" fill="white" fill-opacity="0.95"/>
                    <circle cx="21" cy="14" r="5" fill="#ef4444"/>
                    <text x="18.5" y="17.5" font-family="Arial" font-weight="900" font-size="7" fill="white">P</text>
                    <rect x="8" y="34" width="26" height="3" rx="1.5" fill="white" fill-opacity="0.6"/>
                    <rect x="13" y="34" width="2" height="3" fill="#0b1120" fill-opacity="0.4"/>
                    <rect x="19.5" y="34" width="2" height="3" fill="#0b1120" fill-opacity="0.4"/>
                    <rect x="26" y="34" width="2" height="3" fill="#0b1120" fill-opacity="0.4"/>
                </svg>
            </div>
            <div>
                <div class="logo-title">Daftar Akun</div>
                <div class="logo-sub">Peta Parkir Salatiga — Admin</div>
            </div>
        </div>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Nama lengkap admin" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="admin@example.com" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="Minimal 8 karakter" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="hint-text">Gunakan kombinasi huruf, angka, dan simbol</div>
            </div>
            <div class="mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus me-2"></i>Buat Akun Admin
            </button>
        </form>

        <div class="divider-or"><span>atau</span></div>

        <div class="text-center">
            <span style="font-size:.8rem;color:rgba(255,255,255,0.35)">Sudah punya akun? </span>
            <a href="{{ route('login') }}" class="link-blue">Masuk di sini</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
