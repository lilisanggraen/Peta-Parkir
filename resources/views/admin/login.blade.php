<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Peta Parkir Salatiga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            background: #0b1120;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #111827;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 18px;
            padding: 40px 36px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }
        .logo-wrap {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin: 0 auto 20px;
        }
        .login-title {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 4px;
        }
        .login-sub {
            color: rgba(255,255,255,0.35);
            font-size: 0.8rem;
            text-align: center;
            margin-bottom: 28px;
        }
        .form-label {
            color: rgba(255,255,255,0.6);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .form-control {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 0.88rem;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.08);
            border-color: rgba(99,102,241,0.5);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }
        .form-control::placeholder { color: rgba(255,255,255,0.2); }
        .btn-login {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 11px;
            border-radius: 10px;
            font-size: 0.9rem;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(99,102,241,0.3);
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: rgba(255,255,255,0.3);
            font-size: 0.78rem;
            text-decoration: none;
            transition: color 0.15s;
        }
        .back-link:hover { color: rgba(255,255,255,0.6); }
        .alert-danger {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.2);
            color: #fca5a5;
            border-radius: 10px;
            font-size: 0.82rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-wrap">🅿️</div>
        <div class="login-title">Login Admin</div>
        <div class="login-sub">Peta Parkir Kota Salatiga</div>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-circle me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="admin@example.com"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="••••••••"
                    required
                >
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-shield-lock me-1"></i> Masuk ke Panel Admin
            </button>
        </form>

        <a href="{{ route('map') }}" class="back-link">
            ← Kembali ke Peta Publik
        </a>
    </div>
</body>
</html>
