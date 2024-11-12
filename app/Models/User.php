<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash; // Hash sınıfını ekleyin

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Şifreyi bcrypt ile şifrelemek için Hash::make() kullanıyoruz
    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = Hash::make($password); // bcrypt ile şifreleme
        }
    }
}

