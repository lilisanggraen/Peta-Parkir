@extends('layouts.admin')
@section('page-title', 'Edit Data Parkir')
@section('page-subtitle', 'Perbarui informasi lokasi parkir')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.parking.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<form action="{{ route('admin.parking.update', $parking) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
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
                               value="{{ old('nama', $parking->nama) }}">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.875rem">Tipe Geometri <span class="text-danger">*</span></label>
                        <select name="tipe" id="tipe-select" class="form-select">
                            <option value="point"    {{ old('tipe',$parking->tipe)=='point'?'selected':'' }}>📍 Point</option>
                            <option value="polyline" {{ old('tipe',$parking->tipe)=='polyline'?'selected':'' }}>〰️ Polyline</option>
                            <option value="polygon"  {{ old('tipe',$parking->tipe)=='polygon'?'selected':'' }}>⬡ Polygon</option>
                        </select>
                    </div>

                    <div id="point-fields" style="display:{{ old('tipe',$parking->tipe)=='point'?'block':'none' }}">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label" style="font-size:.85rem">Latitude</label>
                                <input type="text" name="lat" class="form-control" value="{{ old('lat', $parking->lat) }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label" style="font-size:.85rem">Longitude</label>
                                <input type="text" name="lng" class="form-control" value="{{ old('lng', $parking->lng) }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.875rem">Koordinat JSON <span class="text-danger">*</span></label>
                        <textarea name="koordinat" class="form-control font-monospace" rows="4" style="font-size:.82rem">{{ old('koordinat', $parking->koordinat) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.875rem">Alamat <span class="text-danger">*</span></label>
                        <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $parking->alamat) }}">
                    </div>

                    <div>
                        <label class="form-label fw-semibold" style="font-size:.875rem">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $parking->keterangan) }}</textarea>
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
                        <label class="form-label fw-semibold" style="font-size:.875rem">Penanggung Jawab</label>
                        <input type="text" name="penanggung_jawab" class="form-control" value="{{ old('penanggung_jawab', $parking->penanggung_jawab) }}">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label" style="font-size:.85rem">Mulai Kontrak</label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $parking->tanggal_mulai->format('Y-m-d')) }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:.85rem">Akhir Kontrak</label>
                            <input type="date" name="tanggal_akhir" class="form-control" value="{{ old('tanggal_akhir', $parking->tanggal_akhir->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div>
                        <label class="form-label fw-semibold" style="font-size:.875rem">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif"         {{ old('status',$parking->status)=='aktif'?'selected':'' }}>✅ Aktif</option>
                            <option value="tidak_aktif"   {{ old('status',$parking->status)=='tidak_aktif'?'selected':'' }}>❌ Tidak Aktif</option>
                            <option value="habis_kontrak" {{ old('status',$parking->status)=='habis_kontrak'?'selected':'' }}>⚠️ Habis Kontrak</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color:#1e293b">
                        <i class="bi bi-image text-warning me-2"></i>Foto Lokasi
                    </h6>
                    @if($parking->foto)
                    <div class="mb-3">
                        <div style="font-size:.78rem;color:#64748b;margin-bottom:6px">Foto saat ini:</div>
                        <img src="{{ $parking->foto_url }}" class="img-fluid rounded" style="max-height:150px;width:100%;object-fit:cover">
                    </div>
                    @endif
                    <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewFoto(this)">
                    <div style="font-size:.75rem;color:#94a3b8;margin-top:4px">Biarkan kosong jika tidak ingin mengubah foto</div>
                    <div id="preview-wrap" style="display:none;margin-top:8px">
                        <img id="foto-preview" src="#" alt="Preview"
                             class="img-fluid rounded" style="max-height:150px;width:100%;object-fit:cover">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary px-5">
            <i class="bi bi-save2 me-2"></i>Perbarui Data
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
</script>
@endpush
