<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'capacity',
        'price_per_night',
        'image',
        'amenities',
        'has_wifi',
        'has_ac',
        'has_tv',
        'has_fridge',
        'is_available',
        'room_number',
        'type'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_per_night' => 'decimal:2',
        'is_available' => 'boolean',
        'has_wifi' => 'boolean',
        'has_ac' => 'boolean',
        'has_tv' => 'boolean',
        'has_fridge' => 'boolean',
        'amenities' => 'json'
    ];

    /**
     * Odanın ait olduğu otel
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Odanın rezervasyonları
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Odanın belirtilen tarihler arasında müsait olup olmadığını kontrol eder
     */
    public function isAvailableBetween($checkIn, $checkOut)
    {
        if (!$this->is_available) {
            return false;
        }

        return !$this->reservations()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in_date', '<=', $checkIn)
                            ->where('check_out_date', '>=', $checkOut);
                    });
            })
            ->exists();
    }
}
