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

    public function getFotoUrlAttribute(): string
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : asset('images/no-image.png');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Cek apakah kontrak sudah expired
    public function getIsExpiredAttribute(): bool
    {
        return $this->tanggal_akhir < Carbon::today();
    }
}
