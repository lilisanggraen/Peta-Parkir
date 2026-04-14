<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Parkir Salatiga</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root[data-theme="dark"] {
            --bg-navbar: rgba(10,15,28,0.95);
            --bg-panel: rgba(10,15,28,0.88);
            --text-primary: #ffffff;
            --text-secondary: rgba(255,255,255,0.6);
            --text-muted: rgba(255,255,255,0.3);
            --border: rgba(255,255,255,0.08);
            --border-hover: rgba(255,255,255,0.18);
            --btn-bg: rgba(255,255,255,0.06);
            --btn-hover: rgba(255,255,255,0.12);
            --input-bg: rgba(255,255,255,0.07);
            --divider: rgba(255,255,255,0.07);
            --popup-bg: #0f1623;
            --popup-border: rgba(255,255,255,0.1);
            --legend-sep: rgba(255,255,255,0.07);
            --loading-bg: #0d1117;
            --spinner-border: rgba(255,255,255,0.1);
        }
        :root[data-theme="light"] {
            --bg-navbar: rgba(255,255,255,0.97);
            --bg-panel: rgba(255,255,255,0.95);
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border: rgba(0,0,0,0.09);
            --border-hover: rgba(0,0,0,0.18);
            --btn-bg: rgba(0,0,0,0.04);
            --btn-hover: rgba(0,0,0,0.08);
            --input-bg: rgba(0,0,0,0.04);
            --divider: rgba(0,0,0,0.07);
            --popup-bg: #ffffff;
            --popup-border: rgba(0,0,0,0.1);
            --legend-sep: rgba(0,0,0,0.07);
            --loading-bg: #f8fafc;
            --spinner-border: rgba(0,0,0,0.1);
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans',sans-serif; overflow:hidden; }

        .topbar {
            position:fixed; top:0; left:0; right:0; z-index:1000;
            height:56px;
            background: var(--bg-navbar);
            backdrop-filter:blur(16px);
            border-bottom:1px solid var(--border);
            display:flex; align-items:center; padding:0 20px; gap:12px;
            transition: background 0.3s, border-color 0.3s;
        }
        .brand { display:flex; align-items:center; gap:10px; text-decoration:none; }
        .brand-icon {
            width:34px; height:34px; border-radius:9px;
            background:linear-gradient(135deg,#f59e0b,#ef4444);
            display:flex; align-items:center; justify-content:center;
            font-size:16px; flex-shrink:0;
        }
        .brand-text { font-weight:700; font-size:0.9rem; line-height:1.1; color:var(--text-primary); transition:color .3s; }
        .brand-sub { font-size:0.65rem; color:var(--text-muted); transition:color .3s; }
        .divider { width:1px; height:20px; background:var(--border); }
        .stat-chips { display:flex; gap:6px; }
        .chip {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 10px; border-radius:99px;
            font-size:0.72rem; font-weight:600; border:1px solid transparent;
        }
        .chip-dot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
        .chip-green { background:rgba(16,185,129,0.12); border-color:rgba(16,185,129,0.2); }
        [data-theme="dark"] .chip-green { color:#6ee7b7; }
        [data-theme="light"] .chip-green { color:#059669; }
        .chip-green .chip-dot { background:#10b981; }

        .topbar-right { margin-left:auto; display:flex; align-items:center; gap:8px; }
        .theme-toggle {
            width:36px; height:36px; border-radius:9px;
            background:var(--btn-bg); border:1px solid var(--border);
            color:var(--text-primary); cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            font-size:15px; transition:all .2s;
        }
        .theme-toggle:hover { background:var(--btn-hover); }
        .btn-admin {
            display:inline-flex; align-items:center; gap:6px;
            padding:7px 14px; border-radius:8px; font-size:0.78rem; font-weight:600;
            text-decoration:none; transition:all .2s;
            border:1px solid var(--border); color:var(--text-primary); background:var(--btn-bg);
        }
        .btn-admin:hover { background:var(--btn-hover); color:var(--text-primary); }
        .btn-dashboard {
            display:inline-flex; align-items:center; gap:6px;
            padding:7px 14px; border-radius:8px; font-size:0.78rem; font-weight:600;
            text-decoration:none; transition:all .2s;
            background:linear-gradient(135deg,#3b82f6,#1d4ed8); color:#fff; border:none;
        }
        .btn-dashboard:hover { opacity:.9; color:#fff; }

        #map { position:fixed; top:56px; left:0; right:0; bottom:0; }

        .side-panel {
            position:fixed; top:72px; left:16px; bottom:16px;
            width:268px; z-index:500;
            display:flex; flex-direction:column; gap:10px; pointer-events:none;
        }
        .panel-card {
            background:var(--bg-panel); backdrop-filter:blur(16px);
            border:1px solid var(--border); border-radius:14px;
            padding:14px 16px; pointer-events:all;
            transition: background .3s, border-color .3s;
        }
        .panel-title {
            font-size:0.68rem; font-weight:700; color:var(--text-muted);
            text-transform:uppercase; letter-spacing:0.08em; margin-bottom:10px;
        }
        .legend-item {
            display:flex; align-items:center; gap:9px; margin-bottom:8px;
            font-size:0.8rem; color:var(--text-secondary);
        }
        .legend-dot { width:11px; height:11px; border-radius:50%; flex-shrink:0; }
        .legend-line { width:22px; height:4px; border-radius:2px; flex-shrink:0; }
        .legend-dashed { width:22px; height:0; border-top:3px dashed #10b981; flex-shrink:0; }
        .legend-area {
            width:18px; height:13px; border-radius:3px; flex-shrink:0;
            background:rgba(16,185,129,0.3); border:2px dashed #059669;
        }
        .legend-pulse {
            width:13px; height:13px; border-radius:50%; flex-shrink:0;
            background:#10b981; border:2.5px solid rgba(255,255,255,0.8);
            box-shadow:0 0 0 3px rgba(16,185,129,0.3);
        }
        .legend-sep { border:none; border-top:1px solid var(--legend-sep); margin:8px 0; }

        .publik-badge {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 10px; border-radius:99px; font-size:0.7rem; font-weight:600;
            background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.2);
            margin-bottom:10px;
        }
        [data-theme="dark"] .publik-badge { color:#6ee7b7; }
        [data-theme="light"] .publik-badge { color:#059669; }

        .search-wrap { position:relative; }
        .search-input {
            width:100%; padding:8px 12px 8px 34px;
            background:var(--input-bg); border:1px solid var(--border);
            border-radius:8px; color:var(--text-primary);
            font-size:0.82rem; outline:none;
            font-family:'Plus Jakarta Sans',sans-serif; transition:border .2s;
        }
        .search-input::placeholder { color:var(--text-muted); }
        .search-input:focus { border-color:rgba(59,130,246,0.5); }
        .search-icon { position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:13px; }

        .map-loading {
            position:fixed; top:56px; left:0; right:0; bottom:0;
            background:var(--loading-bg); z-index:600;
            display:flex; align-items:center; justify-content:center; flex-direction:column; gap:14px;
        }
        .spinner {
            width:34px; height:34px;
            border:2px solid var(--spinner-border);
            border-top:2px solid #3b82f6;
            border-radius:50%; animation:spin .7s linear infinite;
        }
        .loading-text { font-size:0.82rem; color:var(--text-muted); }
        @keyframes spin { to { transform:rotate(360deg); } }
        @keyframes pulse-ring {
            0% { transform:translate(-50%,-50%) scale(0.5); opacity:0.6; }
            100% { transform:translate(-50%,-50%) scale(2.5); opacity:0; }
        }

        .leaflet-popup-content-wrapper {
            border-radius:14px !important; padding:0 !important; overflow:hidden; min-width:240px;
            background:var(--popup-bg) !important;
            border:1px solid var(--popup-border) !important;
            box-shadow:0 16px 48px rgba(0,0,0,0.25) !important;
        }
        .leaflet-popup-content { margin:0 !important; width:100% !important; }
        .leaflet-popup-tip { background:var(--popup-bg) !important; }
        .leaflet-popup-close-button { color:var(--text-muted) !important; top:8px !important; right:10px !important; }
        .popup-img { width:100%; height:130px; object-fit:cover; }
        .popup-body { padding:14px 16px; background:var(--popup-bg); }
        .popup-title { font-weight:700; font-size:0.95rem; color:var(--text-primary); margin-bottom:6px; }
        .popup-badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:99px; font-size:0.7rem; font-weight:600; margin-bottom:10px; }
        .popup-row { display:flex; align-items:flex-start; gap:7px; margin-bottom:5px; font-size:0.78rem; color:var(--text-secondary); }
        .popup-row i { flex-shrink:0; margin-top:1px; color:var(--text-muted); }
        .popup-note { margin-top:8px; padding:8px 10px; background:var(--input-bg); border-radius:8px; font-size:0.74rem; color:var(--text-muted); }

        .leaflet-control-zoom { border:none !important; }
        .leaflet-control-zoom a {
            background:var(--bg-panel) !important; backdrop-filter:blur(12px) !important;
            color:var(--text-primary) !important; border:1px solid var(--border) !important;
            width:32px !important; height:32px !important; line-height:30px !important;
        }
        @media (max-width:600px) { .side-panel { display:none; } .stat-chips { display:none; } }
    </style>
</head>
<body>

<div class="topbar">
    <a href="/" class="brand">
        <div class="brand-icon">🅿️</div>
        <div>
            <div class="brand-text">Peta Parkir</div>
            <div class="brand-sub">Kota Salatiga</div>
        </div>
    </a>
    <div class="divider"></div>
    <div class="stat-chips">
        <span class="chip chip-green">
            <span class="chip-dot"></span>
            {{ $totalAktif }} Lokasi Aktif
        </span>
    </div>
    <div class="topbar-right">
        <button class="theme-toggle" onclick="toggleTheme()" id="theme-btn" title="Ganti tema">
            <i class="bi bi-sun-fill" id="theme-icon"></i>
        </button>
        @auth
        <a href="/admin/dashboard" class="btn-dashboard">
            <i class="bi bi-speedometer2"></i> Dashboard Admin
        </a>
        @else
        <a href="/login" class="btn-admin">
            <i class="bi bi-lock-fill"></i> Login Admin
        </a>
        @endauth
    </div>
</div>

<div class="map-loading" id="map-loading">
    <div class="spinner"></div>
    <div class="loading-text">Memuat peta parkir...</div>
</div>

<div id="map"></div>

<div class="side-panel">
    <div class="panel-card">
        <div class="panel-title">Cari Lokasi</div>
        <div class="search-wrap">
            <i class="bi bi-search search-icon"></i>
            <input type="text" class="search-input" id="search-input" placeholder="Ketik nama parkir...">
        </div>
    </div>
    <div class="panel-card">
        <div class="publik-badge">
            <i class="bi bi-eye-fill" style="font-size:10px"></i>
            Tampilan Publik — Parkir Aktif
        </div>
        <div class="panel-title">Jenis Penanda</div>
        <div class="legend-item">
            <div class="legend-pulse"></div>
            <span>Titik Parkir (Point)</span>
        </div>
        <div class="legend-item">
            <div class="legend-line" style="background:#10b981"></div>
            <span>Ruas Jalan (Polyline)</span>
        </div>
        <div class="legend-item">
            <div class="legend-area"></div>
            <span>Area Parkir (Polygon)</span>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const tileDark  = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';
const tileLight = 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
let currentTheme = localStorage.getItem('peta_theme') || 'dark';
let tileLayer;

document.documentElement.setAttribute('data-theme', currentTheme);

function updateIcon() {
    document.getElementById('theme-icon').className =
        currentTheme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
}
updateIcon();

function toggleTheme() {
    currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', currentTheme);
    localStorage.setItem('peta_theme', currentTheme);
    updateIcon();
    if (tileLayer) tileLayer.setUrl(currentTheme === 'dark' ? tileDark : tileLight);
}

const map = L.map('map', { center:[-7.3305,110.5084], zoom:14, zoomControl:false });
L.control.zoom({ position:'bottomright' }).addTo(map);
tileLayer = L.tileLayer(currentTheme === 'dark' ? tileDark : tileLight, {
    attribution:'© OpenStreetMap © CARTO | Peta Parkir Salatiga', maxZoom:19
}).addTo(map);

// Marker Point — animasi pulse
function makePointIcon(color) {
    return L.divIcon({
        className:'',
        html:`<div style="position:relative;width:18px;height:18px;">
            <div style="position:absolute;top:50%;left:50%;width:28px;height:28px;border-radius:50%;background:${color};opacity:0.3;animation:pulse-ring 1.8s ease-out infinite;transform:translate(-50%,-50%)"></div>
            <div style="position:absolute;top:0;left:0;width:18px;height:18px;border-radius:50%;background:${color};border:3px solid rgba(255,255,255,0.9);box-shadow:0 2px 8px rgba(0,0,0,0.4)"></div>
        </div>`,
        iconSize:[18,18], iconAnchor:[9,9], popupAnchor:[0,-10]
    });
}

// Polyline — garis solid tebal
function polylineOpts(color) {
    return { color, weight:6, opacity:0.85, lineCap:'round', lineJoin:'round' };
}

// Polygon — isi transparan + border dashed
function polygonOpts(color, border) {
    return { color:border, fillColor:color, fillOpacity:0.2, weight:2.5, dashArray:'8,5', lineCap:'round' };
}

function buildPopup(spot) {
    return `
    <img src="${spot.foto_url}" class="popup-img" onerror="this.style.display='none'" alt="${spot.nama}">
    <div class="popup-body">
        <div class="popup-title">${spot.nama}</div>
        <div class="popup-badge" style="background:rgba(16,185,129,0.15);color:#059669">
            <i class="bi bi-check-circle-fill" style="font-size:.65rem"></i> Aktif
        </div>
        <div class="popup-row"><i class="bi bi-geo-alt-fill"></i>${spot.alamat}</div>
        <div class="popup-row"><i class="bi bi-person-fill"></i>${spot.penanggung_jawab}</div>
        <div class="popup-row"><i class="bi bi-calendar3"></i>${spot.tanggal_mulai} — ${spot.tanggal_akhir}</div>
        ${spot.keterangan ? `<div class="popup-note">${spot.keterangan}</div>` : ''}
    </div>`;
}

let allMarkers = [];

fetch('{{ route("api.map-data") }}')
    .then(r => r.json())
    .then(data => {
        document.getElementById('map-loading').style.display = 'none';

        // Publik HANYA tampilkan status aktif
        data.filter(s => s.status === 'aktif').forEach(spot => {
            const color = '#10b981';
            const border = '#059669';
            const popup = L.popup({ maxWidth:280 }).setContent(buildPopup(spot));
            let layer;

            if (spot.tipe === 'point' && spot.lat && spot.lng) {
                layer = L.marker([spot.lat, spot.lng], { icon: makePointIcon(color) })
                    .addTo(map).bindPopup(popup);

            } else if (spot.tipe === 'polyline' && spot.koordinat) {
                layer = L.polyline(spot.koordinat, polylineOpts(color))
                    .addTo(map).bindPopup(popup);

            } else if (spot.tipe === 'polygon' && spot.koordinat) {
                layer = L.polygon(spot.koordinat, polygonOpts(color, border))
                    .addTo(map).bindPopup(popup);
            }
            if (layer) allMarkers.push({ layer, nama: spot.nama.toLowerCase() });
        });
    })
    .catch(() => { document.getElementById('map-loading').style.display = 'none'; });

document.getElementById('search-input').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    allMarkers.forEach(m => {
        if (!q || m.nama.includes(q)) m.layer.addTo(map);
        else map.removeLayer(m.layer);
    });
});
</script>
<style>
@keyframes pulse-ring {
    0% { transform:translate(-50%,-50%) scale(0.5); opacity:0.5; }
    100% { transform:translate(-50%,-50%) scale(2.8); opacity:0; }
}
</style>
</body>
</html>
