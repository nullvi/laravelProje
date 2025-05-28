<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'guests_count',
        'total_price',
        'status',
        'special_requests',
        'payment_status',
        'payment_method',
        'transaction_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Rezervasyonu yapan kullanıcı
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Rezervasyon yapılan oda
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Rezervasyon yapılan odanın ait olduğu otel
     */
    public function hotel()
    {
        return $this->hasOneThrough(Hotel::class, Room::class, 'id', 'id', 'room_id', 'hotel_id');
    }

    /**
     * Konaklama gün sayısını hesaplar
     */
    public function getDaysAttribute()
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }
}
