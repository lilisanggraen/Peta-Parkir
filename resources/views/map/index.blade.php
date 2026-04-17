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
            --bg-navbar:rgba(10,15,28,0.95); --bg-panel:rgba(10,15,28,0.88);
            --text-primary:#ffffff; --text-secondary:rgba(255,255,255,0.6);
            --text-muted:rgba(255,255,255,0.3); --border:rgba(255,255,255,0.08);
            --border-hover:rgba(255,255,255,0.18); --btn-bg:rgba(255,255,255,0.06);
            --btn-hover:rgba(255,255,255,0.12); --input-bg:rgba(255,255,255,0.07);
            --popup-bg:#0f1623; --popup-border:rgba(255,255,255,0.1);
            --legend-sep:rgba(255,255,255,0.07); --loading-bg:#0d1117;
            --spinner-border:rgba(255,255,255,0.1);
        }
        :root[data-theme="light"] {
            --bg-navbar:rgba(255,255,255,0.97); --bg-panel:rgba(255,255,255,0.95);
            --text-primary:#0f172a; --text-secondary:#475569;
            --text-muted:#94a3b8; --border:rgba(0,0,0,0.09);
            --border-hover:rgba(0,0,0,0.18); --btn-bg:rgba(0,0,0,0.04);
            --btn-hover:rgba(0,0,0,0.08); --input-bg:rgba(0,0,0,0.04);
            --popup-bg:#ffffff; --popup-border:rgba(0,0,0,0.1);
            --legend-sep:rgba(0,0,0,0.07); --loading-bg:#f8fafc;
            --spinner-border:rgba(0,0,0,0.1);
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Plus Jakarta Sans',sans-serif;overflow:hidden;}
        .topbar{position:fixed;top:0;left:0;right:0;z-index:1000;height:56px;
            background:var(--bg-navbar);backdrop-filter:blur(16px);
            border-bottom:1px solid var(--border);
            display:flex;align-items:center;padding:0 20px;gap:12px;transition:background .3s;}
        .brand{display:flex;align-items:center;gap:10px;text-decoration:none;}
        .brand-icon{width:34px;height:34px;border-radius:9px;
            background:linear-gradient(135deg,#f59e0b,#ef4444);
            display:flex;align-items:center;justify-content:center;font-size:16px;}
        .brand-text{font-weight:700;font-size:.9rem;line-height:1.1;color:var(--text-primary);}
        .brand-sub{font-size:.65rem;color:var(--text-muted);}
        .divider{width:1px;height:20px;background:var(--border);}
        .chip{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;
            border-radius:99px;font-size:.72rem;font-weight:600;border:1px solid transparent;}
        .chip-dot{width:6px;height:6px;border-radius:50%;}
        .chip-green{background:rgba(16,185,129,.12);border-color:rgba(16,185,129,.2);}
        [data-theme="dark"] .chip-green{color:#6ee7b7;}
        [data-theme="light"] .chip-green{color:#059669;}
        .chip-green .chip-dot{background:#10b981;}
        .topbar-right{margin-left:auto;display:flex;align-items:center;gap:8px;}
        .theme-toggle{width:36px;height:36px;border-radius:9px;background:var(--btn-bg);
            border:1px solid var(--border);color:var(--text-primary);cursor:pointer;
            display:flex;align-items:center;justify-content:center;font-size:15px;transition:all .2s;}
        .theme-toggle:hover{background:var(--btn-hover);}

        #map{position:fixed;top:56px;left:0;right:0;bottom:0;}
        .side-panel{position:fixed;top:72px;left:16px;bottom:16px;width:272px;z-index:500;
            display:flex;flex-direction:column;gap:10px;pointer-events:none;}
        .panel-card{background:var(--bg-panel);backdrop-filter:blur(16px);
            border:1px solid var(--border);border-radius:14px;padding:14px 16px;
            pointer-events:all;transition:background .3s;}
        .panel-title{font-size:.68rem;font-weight:700;color:var(--text-muted);
            text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;}
        .legend-row{display:flex;align-items:center;gap:10px;margin-bottom:10px;}
        .legend-row:last-child{margin-bottom:0;}
        .legend-sep{border:none;border-top:1px solid var(--legend-sep);margin:9px 0;}
        .publik-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;
            border-radius:99px;font-size:.7rem;font-weight:600;
            background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.2);margin-bottom:10px;}
        [data-theme="dark"] .publik-badge{color:#6ee7b7;}
        [data-theme="light"] .publik-badge{color:#059669;}
        .search-wrap{position:relative;}
        .search-input{width:100%;padding:8px 12px 8px 34px;background:var(--input-bg);
            border:1px solid var(--border);border-radius:8px;color:var(--text-primary);
            font-size:.82rem;outline:none;font-family:'Plus Jakarta Sans',sans-serif;transition:border .2s;}
        .search-input::placeholder{color:var(--text-muted);}
        .search-input:focus{border-color:rgba(59,130,246,.5);}
        .search-icon{position:absolute;left:10px;top:50%;transform:translateY(-50%);
            color:var(--text-muted);font-size:13px;}
        .map-loading{position:fixed;top:56px;left:0;right:0;bottom:0;
            background:var(--loading-bg);z-index:600;
            display:flex;align-items:center;justify-content:center;flex-direction:column;gap:14px;}
        .spinner{width:34px;height:34px;border:2px solid var(--spinner-border);
            border-top:2px solid #3b82f6;border-radius:50%;animation:spin .7s linear infinite;}
        .loading-text{font-size:.82rem;color:var(--text-muted);}
        @keyframes spin{to{transform:rotate(360deg);}}
        @keyframes pulse-ring{
            0%{transform:translate(-50%,-50%) scale(.3);opacity:.55;}
            100%{transform:translate(-50%,-50%) scale(2.8);opacity:0;}}
        @keyframes bob{
            0%,100%{transform:translateY(0);}
            50%{transform:translateY(-4px);}}
        .leaflet-popup-content-wrapper{border-radius:14px !important;padding:0 !important;
            overflow:hidden;min-width:240px;background:var(--popup-bg) !important;
            border:1px solid var(--popup-border) !important;
            box-shadow:0 16px 48px rgba(0,0,0,.25) !important;}
        .leaflet-popup-content{margin:0 !important;width:100% !important;}
        .leaflet-popup-tip{background:var(--popup-bg) !important;}
        .leaflet-popup-close-button{color:var(--text-muted) !important;top:8px !important;right:10px !important;}
        .popup-img{width:100%;height:130px;object-fit:cover;}
        .popup-body{padding:14px 16px;background:var(--popup-bg);}
        .popup-title{font-weight:700;font-size:.95rem;color:var(--text-primary);margin-bottom:6px;}
        .popup-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;
            border-radius:99px;font-size:.7rem;font-weight:600;margin-bottom:10px;}
        .popup-row{display:flex;align-items:flex-start;gap:7px;margin-bottom:5px;
            font-size:.78rem;color:var(--text-secondary);}
        .popup-row i{flex-shrink:0;margin-top:1px;color:var(--text-muted);}
        .popup-note{margin-top:8px;padding:8px 10px;background:var(--input-bg);
            border-radius:8px;font-size:.74rem;color:var(--text-muted);}
        .leaflet-control-zoom{border:none !important;}
        .leaflet-control-zoom a{background:var(--bg-panel) !important;
            backdrop-filter:blur(12px) !important;color:var(--text-primary) !important;
            border:1px solid var(--border) !important;
            width:32px !important;height:32px !important;line-height:30px !important;}
        @media(max-width:600px){.side-panel{display:none;}}
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
    <span class="chip chip-green">
        <span class="chip-dot"></span>
        {{ $totalAktif }} Lokasi Aktif
    </span>
    <div class="topbar-right">
        <button class="theme-toggle" onclick="toggleTheme()" id="theme-btn" title="Ganti tema">
            <i class="bi bi-sun-fill" id="theme-icon"></i>
        </button>
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
        <div class="panel-title">Penanda di Peta</div>

        {{-- Point: papan kotak P --}}
        <div class="legend-row">
            <svg width="30" height="38" viewBox="0 0 30 38" fill="none">
                <rect x="1" y="1" width="28" height="26" rx="7" fill="#10b981"/>
                <rect x="1" y="1" width="28" height="11" rx="7" fill="white" fill-opacity="0.15"/>
                <rect x="4" y="4" width="22" height="20" rx="4" fill="none" stroke="white" stroke-opacity="0.2" stroke-width="1"/>
                <text x="15" y="20" text-anchor="middle" font-family="Arial Black,Arial" font-weight="900" font-size="15" fill="white">P</text>
                <polygon points="15,37 9,27 21,27" fill="#10b981"/>
                <circle cx="15" cy="36.5" r="2" fill="white" fill-opacity="0.85"/>
            </svg>
            <div>
                <div style="font-size:.82rem;font-weight:600;color:var(--text-primary)">Titik Parkir</div>
                <div style="font-size:.71rem;color:var(--text-muted)">Point — 1 lokasi spesifik</div>
            </div>
        </div>

        <hr class="legend-sep">

        {{-- Polyline: ikon jalan --}}
        <div class="legend-row">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                <rect x="1" y="8" width="28" height="14" rx="4" fill="#10b981" fill-opacity="0.2" stroke="#10b981" stroke-width="1.5"/>
                <line x1="5" y1="15" x2="10" y2="15" stroke="white" stroke-opacity="0.6" stroke-width="2" stroke-linecap="round"/>
                <line x1="13" y1="15" x2="17" y2="15" stroke="white" stroke-opacity="0.6" stroke-width="2" stroke-linecap="round"/>
                <line x1="20" y1="15" x2="25" y2="15" stroke="white" stroke-opacity="0.6" stroke-width="2" stroke-linecap="round"/>
                <text x="15" y="13" text-anchor="middle" font-family="Arial Black,Arial" font-weight="900" font-size="7" fill="#10b981">P</text>
            </svg>
            <div>
                <div style="font-size:.82rem;font-weight:600;color:var(--text-primary)">Ruas Jalan</div>
                <div style="font-size:.71rem;color:var(--text-muted)">Polyline — sepanjang jalan</div>
            </div>
        </div>

        <hr class="legend-sep">

        {{-- Polygon: ikon area --}}
        <div class="legend-row">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                <rect x="2" y="4" width="26" height="22" rx="5" fill="#10b981" fill-opacity="0.18" stroke="#10b981" stroke-width="1.5" stroke-dasharray="4 2.5"/>
                <circle cx="15" cy="15" r="7" fill="#10b981" fill-opacity="0.25"/>
                <text x="15" y="19" text-anchor="middle" font-family="Arial Black,Arial" font-weight="900" font-size="10" fill="#10b981">P</text>
            </svg>
            <div>
                <div style="font-size:.82rem;font-weight:600;color:var(--text-primary)">Area Parkir</div>
                <div style="font-size:.71rem;color:var(--text-muted)">Polygon — area luas</div>
            </div>
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
const map = L.map('map', {center:[-7.3305,110.5084],zoom:14,zoomControl:false});
L.control.zoom({position:'bottomright'}).addTo(map);
tileLayer = L.tileLayer(currentTheme === 'dark' ? tileDark : tileLight, {
    attribution:'© OpenStreetMap © CARTO | Peta Parkir Salatiga', maxZoom:19
}).addTo(map);

// ── POINT: Papan parkir kotak + ekor + pulse ──
function makePointIcon(color) {
    return L.divIcon({
        className:'',
        html:`<div style="position:relative;width:36px;height:46px;animation:bob 2.8s ease-in-out infinite;">
            <div style="position:absolute;top:13px;left:50%;width:40px;height:40px;border-radius:50%;
                background:${color};opacity:.2;
                animation:pulse-ring 2.2s ease-out infinite;
                transform:translate(-50%,-50%)"></div>
            <svg width="36" height="46" viewBox="0 0 36 46" fill="none" style="filter:drop-shadow(0 4px 8px rgba(0,0,0,.5))">
                <rect x="2" y="2" width="32" height="28" rx="8" fill="${color}"/>
                <rect x="2" y="2" width="32" height="12" rx="8" fill="white" fill-opacity=".18"/>
                <rect x="5" y="5" width="26" height="22" rx="5" fill="none" stroke="white" stroke-opacity=".2" stroke-width="1.2"/>
                <text x="18" y="22" text-anchor="middle"
                    font-family="Arial Black,Arial" font-weight="900"
                    font-size="17" fill="white">P</text>
                <polygon points="18,46 11,30 25,30" fill="${color}"/>
                <circle cx="18" cy="44.5" r="2.5" fill="white" fill-opacity=".9"/>
            </svg>
        </div>`,
        iconSize:[36,46], iconAnchor:[18,46], popupAnchor:[0,-48]
    });
}

// ── POLYLINE: Garis jalan tebal + marka putih ──
function addPolyline(latlngs, color) {
    const base  = L.polyline(latlngs, {color, weight:8, opacity:.85, lineCap:'round', lineJoin:'round'});
    const marka = L.polyline(latlngs, {color:'white', weight:1.5, opacity:.5, dashArray:'10,14', lineCap:'round'});
    return {base, marka};
}

// ── POLYGON: Area dashed + label P bulat di tengah ──
function addPolygon(latlngs, color, border) {
    const poly = L.polygon(latlngs, {
        color:border, fillColor:color, fillOpacity:.2,
        weight:2.5, dashArray:'10,6', lineCap:'round', lineJoin:'round'
    });
    return poly;
}
function makeLabelIcon(color) {
    return L.divIcon({
        className:'',
        html:`<div style="width:34px;height:34px;border-radius:50%;
            background:${color};border:3px solid white;
            display:flex;align-items:center;justify-content:center;
            box-shadow:0 3px 10px rgba(0,0,0,.4);
            font-family:'Arial Black',Arial;font-weight:900;font-size:15px;color:white;
            animation:bob 3s ease-in-out infinite;">P</div>`,
        iconSize:[34,34], iconAnchor:[17,17]
    });
}

function buildPopup(spot) {
    return `
    <img src="${spot.foto_url}" class="popup-img" onerror="this.style.display='none'" alt="${spot.nama}">
    <div class="popup-body">
        <div class="popup-title">${spot.nama}</div>
        <div class="popup-badge" style="background:rgba(16,185,129,.15);color:#059669">
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
        data.filter(s => s.status === 'aktif').forEach(spot => {
            const color  = '#10b981';
            const border = '#059669';
            const popup  = L.popup({maxWidth:280}).setContent(buildPopup(spot));
            let layer;

            if (spot.tipe === 'point' && spot.lat && spot.lng) {
                layer = L.marker([spot.lat, spot.lng], {icon:makePointIcon(color)})
                    .addTo(map).bindPopup(popup);

            } else if (spot.tipe === 'polyline' && spot.koordinat) {
                const {base, marka} = addPolyline(spot.koordinat, color);
                base.addTo(map).bindPopup(popup);
                marka.addTo(map);
                layer = base;

            } else if (spot.tipe === 'polygon' && spot.koordinat) {
                layer = addPolygon(spot.koordinat, color, border).addTo(map).bindPopup(popup);
                const center = layer.getBounds().getCenter();
                const lbl = L.marker(center, {icon:makeLabelIcon(color), interactive:false}).addTo(map);
            }
            if (layer) allMarkers.push({layer, nama:spot.nama.toLowerCase()});
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
</body>
</html>
