@extends('layouts.admin')
@section('page-title', 'Data Parkir')
@section('page-subtitle', 'Kelola semua lokasi parkir di Kota Salatiga')

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @foreach([
        ['aktif','Aktif','#059669','check-circle-fill'],
        ['habis_kontrak','Habis Kontrak','#d97706','clock-history'],
        ['tidak_aktif','Tidak Aktif','#dc2626','x-circle-fill'],
    ] as [$key, $label, $clr, $icon])
    <div class="col-4">
        <div class="card">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div style="width:38px;height:38px;background:{{ $clr }}20;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-{{ $icon }}" style="color:{{ $clr }};font-size:1.1rem"></i>
                </div>
                <div>
                    <div style="font-size:1.4rem;font-weight:700;color:#1e293b;line-height:1">{{ $stats[$key] }}</div>
                    <div style="font-size:0.75rem;color:#64748b">{{ $label }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Filter & Search --}}
<div class="card mb-4">
    <div class="card-body py-3 px-4">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0"
                           placeholder="Cari nama lokasi..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
                    <option value="habis_kontrak" {{ request('status')=='habis_kontrak'?'selected':'' }}>Habis Kontrak</option>
                    <option value="tidak_aktif" {{ request('status')=='tidak_aktif'?'selected':'' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2 text-end">
                <a href="{{ route('admin.parking.create') }}" class="btn btn-success w-100">
                    <i class="bi bi-plus-lg me-1"></i>Tambah
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel --}}
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr style="background:#f8fafc;font-size:.8rem;color:#64748b;text-transform:uppercase;letter-spacing:.04em">
                        <th class="px-4 py-3">#</th>
                        <th>Nama Lokasi</th>
                        <th>Tipe</th>
                        <th>Penanggung Jawab</th>
                        <th>Kontrak Berakhir</th>
                        <th>Status</th>
                        <th class="px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($spots as $spot)
                <tr>
                    <td class="px-4 text-muted" style="font-size:.85rem">{{ $spots->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:.9rem">{{ $spot->nama }}</div>
                        <div style="font-size:.78rem;color:#94a3b8">{{ Str::limit($spot->alamat, 45) }}</div>
                    </td>
                    <td>
                        @php
                            $tipeConf = [
                                'point'    => ['bg-info text-dark',    'bi-geo-alt-fill',              'Point'],
                                'polyline' => ['bg-warning text-dark', 'bi-arrows-collapse-vertical',  'Polyline'],
                                'polygon'  => ['bg-success',           'bi-pentagon-fill',             'Polygon'],
                            ];
                            [$cls,$ico,$lbl] = $tipeConf[$spot->tipe] ?? ['bg-secondary','bi-question','?'];
                        @endphp
                        <span class="badge {{ $cls }} d-inline-flex align-items-center gap-1" style="font-size:.75rem">
                            <i class="bi {{ $ico }}"></i>{{ $lbl }}
                        </span>
                    </td>
                    <td style="font-size:.875rem">{{ $spot->penanggung_jawab }}</td>
                    <td>
                        <span style="font-size:.82rem; color:{{ $spot->tanggal_akhir < now() ? '#dc2626' : '#374151' }}; font-weight:{{ $spot->tanggal_akhir < now() ? '600' : '400' }}">
                            @if($spot->tanggal_akhir < now())
                                <i class="bi bi-exclamation-circle me-1"></i>
                            @endif
                            {{ $spot->tanggal_akhir->format('d M Y') }}
                        </span>
                    </td>
                    <td>
                        @php
                            $stConf = [
                                'aktif'         => ['#dcfce7','#166534','Aktif'],
                                'tidak_aktif'   => ['#fee2e2','#991b1b','Tidak Aktif'],
                                'habis_kontrak' => ['#fef9c3','#92400e','Habis Kontrak'],
                            ];
                            [$bg,$tc,$sl] = $stConf[$spot->status] ?? ['#f1f5f9','#475569',$spot->status];
                        @endphp
                        <span style="background:{{ $bg }};color:{{ $tc }};padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600">
                            {{ $sl }}
                        </span>
                    </td>
                    <td class="px-4">
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.parking.edit', $spot) }}"
                               class="btn btn-sm" style="background:#eff6ff;color:#2563eb;border:none" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.parking.destroy', $spot) }}" method="POST"
                                  onsubmit="return confirm('Hapus data parkir ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm" style="background:#fff1f2;color:#e11d48;border:none" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-inbox display-5 text-muted d-block mb-2"></i>
                        <span class="text-muted">Belum ada data. </span>
                        <a href="{{ route('admin.parking.create') }}">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($spots->hasPages())
    <div class="card-footer bg-white border-top py-3 px-4">
        {{ $spots->links() }}
    </div>
    @endif
</div>
@endsection
