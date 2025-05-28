<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_approved' => 'boolean',
    ];

    /**
     * Kullanıcının rezervasyonları
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Yöneticinin otelleri
     */
    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'manager_id');
    }

    /**
     * Kullanıcının müşteri olup olmadığını kontrol eder
     */
    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    /**
     * Kullanıcının otel yöneticisi olup olmadığını kontrol eder
     */
    public function isHotelManager()
    {
        return $this->role === 'hotel_manager';
    }

    /**
     * Kullanıcının admin olup olmadığını kontrol eder
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
