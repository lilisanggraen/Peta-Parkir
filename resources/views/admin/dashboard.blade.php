@extends('layouts.admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data parkir Kota Salatiga')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
    #mini-map { width:100%; height:340px; border-radius:12px; z-index:1; }
    @keyframes pulse-ring {
        0% { transform:translate(-50%,-50%) scale(0.5); opacity:0.6; }
        100% { transform:translate(-50%,-50%) scale(2.5); opacity:0; }
    }
</style>
@endpush

@section('content')
@php
    $aktif  = \App\Models\ParkingSpot::where('status','aktif')->count();
    $habis  = \App\Models\ParkingSpot::where('status','habis_kontrak')->count();
    $tidak  = \App\Models\ParkingSpot::where('status','tidak_aktif')->count();
    $total  = $aktif + $habis + $tidak;
@endphp

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#1d4ed8,#3b82f6)">
            <div class="bg-icon"><i class="bi bi-geo-alt"></i></div>
            <div class="num">{{ $total }}</div>
            <div class="lbl">Total Lokasi</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#059669,#10b981)">
            <div class="bg-icon"><i class="bi bi-check-circle"></i></div>
            <div class="num">{{ $aktif }}</div>
            <div class="lbl">Aktif</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#b45309,#f59e0b)">
            <div class="bg-icon"><i class="bi bi-clock-history"></i></div>
            <div class="num">{{ $habis }}</div>
            <div class="lbl">Habis Kontrak</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#be123c,#f43f5e)">
            <div class="bg-icon"><i class="bi bi-x-circle"></i></div>
            <div class="num">{{ $tidak }}</div>
            <div class="lbl">Tidak Aktif</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <div class="fw-bold" style="font-size:.9rem;color:#0f172a">Peta Semua Lokasi Parkir</div>
                        <div style="font-size:.72rem;color:#94a3b8">Admin dapat melihat semua status</div>
                    </div>
                    <a href="{{ route('map') }}" target="_blank"
                       class="btn btn-sm" style="background:#eff6ff;color:#2563eb;border:none;font-size:.75rem">
                        <i class="bi bi-arrows-fullscreen me-1"></i>Peta Publik
                    </a>
                </div>

                {{-- Legenda peta admin --}}
                <div class="d-flex gap-3 mb-2 flex-wrap" style="font-size:.72rem">
                    <span class="d-flex align-items-center gap-1">
                        <span style="width:10px;height:10px;border-radius:50%;background:#10b981;display:inline-block"></span>
                        Aktif
                    </span>
                    <span class="d-flex align-items-center gap-1">
                        <span style="width:10px;height:10px;border-radius:50%;background:#f59e0b;display:inline-block"></span>
                        Habis Kontrak
                    </span>
                    <span class="d-flex align-items-center gap-1">
                        <span style="width:10px;height:10px;border-radius:50%;background:#ef4444;display:inline-block"></span>
                        Tidak Aktif
                    </span>
                    <span class="d-flex align-items-center gap-1" style="color:#94a3b8">
                        <span style="width:16px;height:3px;background:#10b981;display:inline-block;border-radius:2px"></span>
                        Polyline
                    </span>
                    <span class="d-flex align-items-center gap-1" style="color:#94a3b8">
                        <span style="width:14px;height:10px;background:rgba(16,185,129,0.25);border:2px dashed #059669;display:inline-block;border-radius:2px"></span>
                        Polygon
                    </span>
                </div>

                <div id="mini-map"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-5 d-flex flex-column gap-4">
        <div class="card">
            <div class="card-body p-4">
                <div class="fw-bold mb-3" style="font-size:.88rem;color:#0f172a">Aksi Cepat</div>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.parking.create') }}" class="btn btn-primary" style="font-size:.85rem">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Lokasi Parkir
                    </a>
                    <a href="{{ route('map') }}" target="_blank" class="btn btn-outline-secondary" style="font-size:.85rem">
                        <i class="bi bi-map me-2"></i>Buka Peta Publik
                    </a>
                    <a href="{{ route('admin.parking.index') }}?status=habis_kontrak"
                       class="btn btn-outline-warning" style="font-size:.85rem">
                        <i class="bi bi-exclamation-triangle me-2"></i>Cek Kontrak Habis ({{ $habis }})
                    </a>
                    <a href="{{ route('admin.parking.index') }}?status=tidak_aktif"
                       class="btn btn-outline-danger" style="font-size:.85rem">
                        <i class="bi bi-x-circle me-2"></i>Cek Tidak Aktif ({{ $tidak }})
                    </a>
                </div>
            </div>
        </div>

        <div class="card flex-fill">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="fw-bold" style="font-size:.88rem;color:#0f172a">Data Terbaru</div>
                    <a href="{{ route('admin.parking.index') }}" style="font-size:.75rem;color:#3b82f6;text-decoration:none">Lihat Semua →</a>
                </div>
                @forelse(\App\Models\ParkingSpot::latest()->take(5)->get() as $s)
                <div class="d-flex align-items-center gap-3 py-2"
                     style="border-bottom:1px solid #f1f5f9;{{ $loop->last ? 'border:none' : '' }}">
                    @php
                        $clr = ['aktif'=>'#10b981','tidak_aktif'=>'#ef4444','habis_kontrak'=>'#f59e0b'];
                        $c = $clr[$s->status] ?? '#94a3b8';
                    @endphp
                    <div style="width:8px;height:8px;border-radius:50%;background:{{ $c }};flex-shrink:0"></div>
                    <div style="flex:1;min-width:0">
                        <div style="font-size:.82rem;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $s->nama }}</div>
                        <div style="font-size:.72rem;color:#94a3b8">{{ $s->tanggal_akhir->format('d M Y') }}</div>
                    </div>
                    <a href="{{ route('admin.parking.edit', $s) }}" style="font-size:.7rem;color:#3b82f6;text-decoration:none;flex-shrink:0">Edit</a>
                </div>
                @empty
                <div style="font-size:.82rem;color:#94a3b8;text-align:center;padding:20px 0">Belum ada data</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const miniMap = L.map('mini-map', {
    center:[-7.3305,110.5084], zoom:13,
    zoomControl:true, scrollWheelZoom:false
});
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom:19 }).addTo(miniMap);

const colors = {
    aktif:         { fill:'#10b981', border:'#059669' },
    tidak_aktif:   { fill:'#ef4444', border:'#dc2626' },
    habis_kontrak: { fill:'#f59e0b', border:'#d97706' },
};

function makeIcon(color) {
    return L.divIcon({
        className:'',
        html:`<div style="position:relative;width:14px;height:14px;">
            <div style="position:absolute;top:50%;left:50%;width:22px;height:22px;border-radius:50%;background:${color};opacity:0.25;animation:pulse-ring 2s ease-out infinite;transform:translate(-50%,-50%)"></div>
            <div style="width:14px;height:14px;border-radius:50%;background:${color};border:2.5px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,0.3)"></div>
        </div>`,
        iconSize:[14,14], iconAnchor:[7,7], popupAnchor:[0,-8]
    });
}

// Admin: tampilkan SEMUA status
fetch('{{ route("api.map-data") }}')
    .then(r => r.json())
    .then(data => {
        data.forEach(spot => {
            const c = colors[spot.status] || colors.aktif;
            const stLabel = { aktif:'Aktif', tidak_aktif:'Tidak Aktif', habis_kontrak:'Habis Kontrak' };
            const popupContent = `<strong style="font-size:.85rem">${spot.nama}</strong>
                <br><small style="color:#64748b">${spot.alamat}</small>
                <br><span style="font-size:.72rem;padding:1px 7px;border-radius:99px;background:${c.fill}20;color:${c.border};font-weight:600">${stLabel[spot.status]||spot.status}</span>`;

            if (spot.tipe === 'point' && spot.lat && spot.lng) {
                L.marker([spot.lat, spot.lng], { icon: makeIcon(c.fill) })
                    .addTo(miniMap).bindPopup(popupContent);

            } else if (spot.tipe === 'polyline' && spot.koordinat) {
                L.polyline(spot.koordinat, { color:c.fill, weight:5, opacity:0.85, lineCap:'round' })
                    .addTo(miniMap).bindPopup(popupContent);

            } else if (spot.tipe === 'polygon' && spot.koordinat) {
                L.polygon(spot.koordinat, { color:c.border, fillColor:c.fill, fillOpacity:0.25, weight:2, dashArray:'6,4' })
                    .addTo(miniMap).bindPopup(popupContent);
            }
        });
    });
</script>
@endpush
