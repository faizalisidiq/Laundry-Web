<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'harga',
        'durasi_hari',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'durasi_hari' => 'integer',
    ];

    public function od() {
        return $this->hasMany(Od::class);
    }
}
