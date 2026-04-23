<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingSpot;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ParkingSpotController extends Controller
{
    public function index(Request $request)
    {
        $query = ParkingSpot::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $spots = $query->paginate(10)->withQueryString();

        $stats = [
            'aktif'         => ParkingSpot::where('status', 'aktif')->count(),
            'tidak_aktif'   => ParkingSpot::where('status', 'tidak_aktif')->count(),
            'habis_kontrak' => ParkingSpot::where('status', 'habis_kontrak')->count(),
        ];

        return view('admin.parking.index', compact('spots', 'stats'));
    }

    public function create()
    {
        return view('admin.parking.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        // Upload foto ke Cloudinary
        if ($request->hasFile('foto')) {
            $uploaded = Cloudinary::upload($request->file('foto')->getRealPath(), [
                'folder' => 'peta-parkir-salatiga',
            ]);
            // Simpan URL lengkap Cloudinary ke DB
            $validated['foto'] = $uploaded->getSecurePath();
        }

        ParkingSpot::create($validated);

        return redirect()->route('admin.parking.index')
            ->with('success', 'Data parkir berhasil ditambahkan!');
    }

    public function edit(ParkingSpot $parking)
    {
        return view('admin.parking.edit', compact('parking'));
    }

    public function update(Request $request, ParkingSpot $parking)
    {
        $validated = $this->validateData($request);

        // Upload foto baru ke Cloudinary jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama di Cloudinary jika ada
            if ($parking->foto && str_contains($parking->foto, 'cloudinary')) {
                // Ekstrak public_id dari URL Cloudinary untuk dihapus
                $publicId = $this->getCloudinaryPublicId($parking->foto);
                if ($publicId) {
                    Cloudinary::destroy($publicId);
                }
            }

            $uploaded = Cloudinary::upload($request->file('foto')->getRealPath(), [
                'folder' => 'peta-parkir-salatiga',
            ]);
            $validated['foto'] = $uploaded->getSecurePath();
        }

        $parking->update($validated);

        return redirect()->route('admin.parking.index')
            ->with('success', 'Data parkir berhasil diperbarui!');
    }

    public function destroy(ParkingSpot $parking)
    {
        // Hapus foto di Cloudinary jika ada
        if ($parking->foto && str_contains($parking->foto, 'cloudinary')) {
            $publicId = $this->getCloudinaryPublicId($parking->foto);
            if ($publicId) {
                Cloudinary::destroy($publicId);
            }
        }

        $parking->delete();

        return redirect()->route('admin.parking.index')
            ->with('success', 'Data parkir berhasil dihapus!');
    }

    /**
     * Ekstrak public_id dari URL Cloudinary.
     * Contoh URL: https://res.cloudinary.com/myapp/image/upload/v123/peta-parkir-salatiga/abc.jpg
     * Public ID  : peta-parkir-salatiga/abc
     */
    private function getCloudinaryPublicId(string $url): ?string
    {
        // Ambil bagian setelah /upload/
        if (preg_match('/\/upload\/(?:v\d+\/)?(.+)\.[a-z]+$/i', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'nama'             => 'required|string|max:255',
            'tipe'             => 'required|in:point,polyline,polygon',
            'lat'              => 'nullable|numeric|between:-90,90',
            'lng'              => 'nullable|numeric|between:-180,180',
            'koordinat'        => 'nullable|string',
            'alamat'           => 'required|string|max:500',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'penanggung_jawab' => 'required|string|max:255',
            'tanggal_mulai'    => 'required|date',
            'tanggal_akhir'    => 'required|date|after:tanggal_mulai',
            'status'           => 'required|in:aktif,tidak_aktif,habis_kontrak',
            'keterangan'       => 'nullable|string|max:1000',
        ]);

        // Untuk tipe point: auto-generate koordinat dari lat/lng
        if ($request->tipe === 'point' && $request->lat && $request->lng) {
            $validated['koordinat'] = json_encode([
                (float) $request->lat,
                (float) $request->lng,
            ]);
            $validated['lat'] = (float) $request->lat;
            $validated['lng'] = (float) $request->lng;
        }

        return $validated;
    }
}
