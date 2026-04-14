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
        $spots = ParkingSpot::all()->map(function ($spot) {
            return [
                'id'               => $spot->id,
                'nama'             => $spot->nama,
                'tipe'             => $spot->tipe,
                'koordinat'        => json_decode($spot->koordinat),
                'lat'              => $spot->lat,
                'lng'              => $spot->lng,
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
