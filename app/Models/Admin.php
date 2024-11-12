<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Burada Authenticatable'ı doğru şekilde kullanıyoruz
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;

    // Admin tablosunun adı
    protected $table = 'admins';

    // Admin tablosunda yer alan verilerin hangi sütunlarına izin verileceği
    protected $fillable = [
        'name', 'email', 'password', // ve diğer gerekli sütunlar
    ];

    // Parolayı otomatik olarak hash'lemek istiyorsanız
    protected $hidden = [
        'password', // Parola gizlenecek
    ];

    // Admin'e ait herhangi bir özelleştirilmiş metod, örneğin:
    public function getAuthIdentifierName()
    {
        return 'id'; // Eğer 'id' ile kimlik doğrulaması yapıyorsanız, burada 'id' kullanmalısınız
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }
}
