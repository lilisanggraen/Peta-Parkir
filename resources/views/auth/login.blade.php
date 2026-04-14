<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Peta Parkir Salatiga</title>
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

        /* Latar dekoratif */
        .bg-deco {
            position:absolute; inset:0; overflow:hidden; pointer-events:none;
        }
        .bg-circle {
            position:absolute; border-radius:50%;
            background:radial-gradient(circle, rgba(59,130,246,0.12), transparent 70%);
        }
        .bg-circle-1 { width:600px; height:600px; top:-150px; right:-100px; }
        .bg-circle-2 { width:400px; height:400px; bottom:-100px; left:-100px; background:radial-gradient(circle, rgba(245,158,11,0.08), transparent 70%); }
        .bg-grid {
            position:absolute; inset:0;
            background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .card-wrap {
            position:relative; z-index:10;
            width:100%; max-width:420px;
            padding:20px;
        }

        /* Logo area */
        .logo-area {
            text-align:center; margin-bottom:28px;
        }
        .logo-mark {
            display:inline-flex; flex-direction:column;
            align-items:center; gap:12px;
        }
        .logo-icon-wrap {
            width:72px; height:72px; border-radius:20px;
            background:linear-gradient(135deg,#f59e0b,#ef4444);
            display:flex; align-items:center; justify-content:center;
            position:relative;
            box-shadow:0 8px 32px rgba(245,158,11,0.3);
        }
        /* SVG ikon peta parkir custom */
        .logo-icon-wrap svg { width:42px; height:42px; }
        .logo-title {
            font-size:1.35rem; font-weight:800; color:#fff; line-height:1.1;
            letter-spacing:-0.02em;
        }
        .logo-sub { font-size:0.78rem; color:rgba(255,255,255,0.4); font-weight:400; }

        /* Form card */
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
            transition:border-color .2s, background .2s;
        }
        .form-control:focus {
            background:rgba(255,255,255,0.09) !important;
            border-color:rgba(59,130,246,0.5) !important;
            box-shadow:0 0 0 3px rgba(59,130,246,0.15) !important;
            color:#fff !important;
        }
        .form-control::placeholder { color:rgba(255,255,255,0.25) !important; }
        .form-check-input {
            background-color:rgba(255,255,255,0.06);
            border-color:rgba(255,255,255,0.2);
        }
        .form-check-label { font-size:0.82rem; color:rgba(255,255,255,0.55); }
        .btn-login {
            width:100%; padding:11px;
            background:linear-gradient(135deg,#3b82f6,#1d4ed8);
            border:none; border-radius:10px;
            color:#fff; font-weight:700; font-size:0.9rem;
            cursor:pointer; transition:all .2s;
            box-shadow:0 4px 16px rgba(59,130,246,0.3);
        }
        .btn-login:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(59,130,246,0.4); }
        .link-muted { font-size:0.8rem; color:rgba(255,255,255,0.4); text-decoration:none; }
        .link-muted:hover { color:rgba(255,255,255,0.7); }
        .link-blue { color:#60a5fa; text-decoration:none; font-size:0.8rem; font-weight:600; }
        .link-blue:hover { color:#93c5fd; }
        .invalid-feedback { font-size:0.78rem; color:#fca5a5; }
        .alert-err { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:10px; padding:10px 14px; font-size:0.82rem; color:#fca5a5; margin-bottom:16px; }
        .divider-or { display:flex; align-items:center; gap:12px; margin:16px 0; }
        .divider-or::before, .divider-or::after { content:''; flex:1; height:1px; background:rgba(255,255,255,0.08); }
        .divider-or span { font-size:0.72rem; color:rgba(255,255,255,0.3); }

        .back-link {
            display:inline-flex; align-items:center; gap:6px;
            font-size:0.78rem; color:rgba(255,255,255,0.4);
            text-decoration:none; margin-bottom:20px;
            transition:color .2s;
        }
        .back-link:hover { color:rgba(255,255,255,0.7); }
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
                {{-- SVG Logo Peta Parkir Salatiga --}}
                <svg viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Pin lokasi -->
                    <path d="M21 4C15.477 4 11 8.477 11 14C11 20.5 21 32 21 32C21 32 31 20.5 31 14C31 8.477 26.523 4 21 4Z" fill="white" fill-opacity="0.95"/>
                    <!-- Lingkaran dalam pin -->
                    <circle cx="21" cy="14" r="5" fill="#ef4444"/>
                    <!-- Huruf P parkir -->
                    <text x="18.5" y="17.5" font-family="Arial" font-weight="900" font-size="7" fill="white">P</text>
                    <!-- Garis jalan bawah -->
                    <rect x="8" y="34" width="26" height="3" rx="1.5" fill="white" fill-opacity="0.6"/>
                    <rect x="13" y="34" width="2" height="3" fill="#0b1120" fill-opacity="0.4"/>
                    <rect x="19.5" y="34" width="2" height="3" fill="#0b1120" fill-opacity="0.4"/>
                    <rect x="26" y="34" width="2" height="3" fill="#0b1120" fill-opacity="0.4"/>
                </svg>
            </div>
            <div>
                <div class="logo-title">Peta Parkir</div>
                <div class="logo-sub">Kota Salatiga — Admin Panel</div>
            </div>
        </div>
    </div>

    <div class="form-card">
        @if ($errors->any())
        <div class="alert-err">
            <i class="bi bi-exclamation-circle me-1"></i>
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label mb-0">Password</label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link-muted">Lupa password?</a>
                    @endif
                </div>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Dashboard
            </button>
        </form>

        <div class="divider-or"><span>atau</span></div>

        <div class="text-center">
            <span style="font-size:.8rem;color:rgba(255,255,255,0.35)">Belum punya akun? </span>
            <a href="{{ route('register') }}" class="link-blue">Daftar di sini</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
