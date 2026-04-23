<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ParkingSpot extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'tipe', 'koordinat', 'lat', 'lng',
        'alamat', 'foto', 'penanggung_jawab',
        'tanggal_mulai', 'tanggal_akhir', 'status', 'keterangan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
    ];

    /**
     * foto_url:
     * - Jika foto adalah URL Cloudinary (http...) → langsung pakai
     * - Jika foto adalah path lokal lama → pakai storage()
     * - Jika tidak ada foto → pakai placeholder
     */
    public function getFotoUrlAttribute(): string
    {
        if (!$this->foto) {
            return asset('images/no-image.png');
        }

        // Sudah berupa URL penuh (Cloudinary)
        if (str_starts_with($this->foto, 'http')) {
            return $this->foto;
        }

        // Path lokal lama (storage)
        return asset('storage/' . $this->foto);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->tanggal_akhir < Carbon::today();
    }
}
