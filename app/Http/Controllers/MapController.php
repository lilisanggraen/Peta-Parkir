<?php

namespace App\Http\Controllers;

use App\Models\ParkingSpot;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $totalAktif    = ParkingSpot::where('status', 'aktif')->count();
        $totalHabis    = ParkingSpot::where('status', 'habis_kontrak')->count();
        $totalTidak    = ParkingSpot::where('status', 'tidak_aktif')->count();
        return view('map.index', compact('totalAktif', 'totalHabis', 'totalTidak'));
    }

    public function getMapData()
    {
        $spots = ParkingSpot::where('status', 'aktif')->get()->map(function ($spot) {
            $koordinat = null;

            if ($spot->koordinat) {
                $decoded = json_decode($spot->koordinat, true);

                if ($spot->tipe === 'point') {
                    // Format: [lat, lng] — langsung pakai lat/lng dari kolom DB
                    $koordinat = null; // point pakai lat/lng langsung
                } elseif (in_array($spot->tipe, ['polyline', 'polygon'])) {
                    // Format array of arrays: [[lat,lng],[lat,lng],...]
                    // Pastikan sudah dalam format [lat, lng] (bukan [lng, lat])
                    $koordinat = $decoded;
                }
            }

            return [
                'id'               => $spot->id,
                'nama'             => $spot->nama,
                'tipe'             => $spot->tipe,
                'koordinat'        => $koordinat,
                'lat'              => $spot->lat ? (float) $spot->lat : null,
                'lng'              => $spot->lng ? (float) $spot->lng : null,
                'alamat'           => $spot->alamat,
                'foto_url'         => $spot->foto_url,
                'penanggung_jawab' => $spot->penanggung_jawab,
                'tanggal_mulai'    => $spot->tanggal_mulai?->format('d M Y'),
                'tanggal_akhir'    => $spot->tanggal_akhir?->format('d M Y'),
                'status'           => $spot->status,
                'keterangan'       => $spot->keterangan,
            ];
        });

        return response()->json($spots);
    }
}
