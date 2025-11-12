<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Ubah dari 'role' menjadi 'role_id'
        'phone',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi dengan Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relasi dengan Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Method untuk cek role
    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    public function isKaryawan()
    {
        return $this->role->name === 'karyawan';
    }

    // Optional: Method tambahan untuk cek role dengan lebih fleksibel
    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }
}
