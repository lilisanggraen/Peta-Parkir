<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingSpot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        if ($request->hasFile('foto')) {
            $url = $this->uploadToCloudinary($request->file('foto'));
            if ($url) $validated['foto'] = $url;
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

        if ($request->hasFile('foto')) {
            $url = $this->uploadToCloudinary($request->file('foto'));
            if ($url) $validated['foto'] = $url;
        }

        $parking->update($validated);

        return redirect()->route('admin.parking.index')
            ->with('success', 'Data parkir berhasil diperbarui!');
    }

    public function destroy(ParkingSpot $parking)
    {
        $parking->delete();

        return redirect()->route('admin.parking.index')
            ->with('success', 'Data parkir berhasil dihapus!');
    }

    /**
     * Upload foto langsung ke Cloudinary API tanpa package.
     */
    private function uploadToCloudinary($file): ?string
    {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey    = env('CLOUDINARY_KEY');
        $apiSecret = env('CLOUDINARY_SECRET');

        $timestamp = time();
        $params    = "folder=peta-parkir-salatiga&timestamp={$timestamp}";
        $signature = hash('sha256', $params . $apiSecret);

        $response = Http::attach(
            'file',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
            'api_key'   => $apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'folder'    => 'peta-parkir-salatiga',
        ]);

        if ($response->successful()) {
            return $response->json('secure_url');
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
