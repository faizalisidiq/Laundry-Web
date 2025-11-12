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
        'tanggal_selesai',
        'wa_sent',
        'wa_sent_at',
        'payment_status',
        'paid_amount',
    ];

    protected $casts = [
        'tanggal_pemesanan' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'wa_sent_at' => 'datetime',
        'wa_sent' => 'boolean',
        'total_harga' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function od() 
    {
        return $this->hasMany(Od::class, 'order_id');
    }

       /**
     * Accessor untuk mendapatkan sisa tagihan
     */
    public function getSisaTagihanAttribute()
    {
        return $this->total_harga - $this->paid_amount;
    }
    

    // Scope untuk filter status
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'Menunggu');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'Diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'Selesai');
    }

    public function scopeDiambil($query)
    {
        return $query->where('status', 'Diambil');
    }
}