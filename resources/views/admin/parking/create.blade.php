@extends('layouts.admin')
@section('page-title', 'Tambah Data Parkir')
@section('page-subtitle', 'Tambahkan lokasi parkir baru ke peta')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.parking.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<form action="{{ route('admin.parking.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4" style="color:#1e293b">
                        <i class="bi bi-info-circle text-primary me-2"></i>Informasi Lokasi
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.875rem">Nama Lokasi <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}" placeholder="Contoh: Parkir Ruko Jl. Sudirman">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.875rem">Tipe Geometri <span class="text-danger">*</span></label>
                        <select name="tipe" id="tipe-select" class="form-select @error('tipe') is-invalid @enderror">
                            <option value="">— Pilih Tipe —</option>
                            <option value="point"    {{ old('tipe')=='point' ? 'selected':'' }}>📍 Point (Titik Lokasi)</option>
                            <option value="polyline" {{ old('tipe')=='polyline' ? 'selected':'' }}>〰️ Polyline (Ruas Jalan)</option>
                            <option value="polygon"  {{ old('tipe')=='polygon' ? 'selected':'' }}>⬡ Polygon (Area Parkir)</option>
                        </select>
                        @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div id="point-fields" style="display:none">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label" style="font-size:.85rem">Latitude</label>
                                <input type="text" name="lat" class="form-control" value="{{ old('lat') }}" placeholder="-7.3305">
                            </div>
                            <div class="col-6">
                                <label class="form-label" style="font-size:.85rem">Longitude</label>
                                <input type="text" name="lng" class="form-control" value="{{ old('lng') }}" placeholder="110.5084">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.875rem">Koordinat JSON <span class="text-danger">*</span></label>
                        <textarea name="koordinat" class="form-control font-monospace @error('koordinat') is-invalid @enderror"
                                  rows="4" placeholder="Point: [-7.3305, 110.5084]&#10;Polyline/Polygon: [[-7.33, 110.50], [-7.34, 110.51]]"
                                  style="font-size:.82rem">{{ old('koordinat') }}</textarea>
                        @error('koordinat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div style="font-size:.78rem;color:#64748b;margin-top:4px">
                            Format array koordinat [lat, lng] untuk Point, atau array of arrays untuk Polyline/Polygon.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.875rem">Alamat Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                               value="{{ old('alamat') }}" placeholder="Jl. Sudirman No.1, Salatiga">
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold" style="font-size:.875rem">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2"
                                  placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4" style="color:#1e293b">
                        <i class="bi bi-person-badge text-success me-2"></i>Pengelola & Kontrak
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.875rem">Penanggung Jawab <span class="text-danger">*</span></label>
                        <input type="text" name="penanggung_jawab"
                               class="form-control @error('penanggung_jawab') is-invalid @enderror"
                               value="{{ old('penanggung_jawab') }}" placeholder="Nama lengkap PJ">
                        @error('penanggung_jawab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem">Mulai Kontrak <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai"
                                   class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                   value="{{ old('tanggal_mulai') }}">
                            @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem">Akhir Kontrak <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_akhir"
                                   class="form-control @error('tanggal_akhir') is-invalid @enderror"
                                   value="{{ old('tanggal_akhir') }}">
                            @error('tanggal_akhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold" style="font-size:.875rem">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif"         {{ old('status','aktif')=='aktif'?'selected':'' }}>✅ Aktif</option>
                            <option value="tidak_aktif"   {{ old('status')=='tidak_aktif'?'selected':'' }}>❌ Tidak Aktif</option>
                            <option value="habis_kontrak" {{ old('status')=='habis_kontrak'?'selected':'' }}>⚠️ Habis Kontrak</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4" style="color:#1e293b">
                        <i class="bi bi-image text-warning me-2"></i>Foto Lokasi
                    </h6>
                    <div class="mb-3">
                        <label for="foto-input" class="form-label" style="font-size:.85rem">Upload Foto</label>
                        <input type="file" name="foto" id="foto-input"
                               class="form-control @error('foto') is-invalid @enderror"
                               accept="image/*" onchange="previewFoto(this)">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div style="font-size:.75rem;color:#94a3b8;margin-top:4px">JPG/PNG/WebP, maks. 2MB</div>
                    </div>
                    <div id="preview-wrap" style="display:none">
                        <img id="foto-preview" src="#" alt="Preview"
                             class="img-fluid rounded" style="max-height:180px;width:100%;object-fit:cover">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary px-5">
            <i class="bi bi-save2 me-2"></i>Simpan Data
        </button>
        <a href="{{ route('admin.parking.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewFoto(input) {
    const wrap = document.getElementById('preview-wrap');
    const preview = document.getElementById('foto-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; wrap.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('tipe-select').addEventListener('change', function () {
    document.getElementById('point-fields').style.display = this.value === 'point' ? 'block' : 'none';
});

// Restore if old value = point
if ('{{ old("tipe") }}' === 'point') {
    document.getElementById('point-fields').style.display = 'block';
}
</script>
@endpush
