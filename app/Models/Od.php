<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Od extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'layanan_id',
        'berat',
        'harga',
        'subtotal'
    ];

    public function layanan() {
        return $this->belongsTo(Layanan::class);
    }
}
