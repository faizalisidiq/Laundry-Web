<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'status',
        'resi',
        'total_harga',
        'tanggal_pemesanan',
        'tanggal_selesai'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function od() {
        return $this->hasMany(Od::class);
    }
}
