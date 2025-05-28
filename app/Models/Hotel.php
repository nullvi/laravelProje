<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'location',
        'address',
        'rating',
        'image',
        'manager_id',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'decimal:1',
        'is_active' => 'boolean',
    ];

    /**
     * Otelin yöneticisi
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Otelin yöneticisi (alias for manager)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Otelin odaları
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Oteldeki tüm rezervasyonlar
     */
    public function reservations()
    {
        return $this->hasManyThrough(Reservation::class, Room::class);
    }
}
