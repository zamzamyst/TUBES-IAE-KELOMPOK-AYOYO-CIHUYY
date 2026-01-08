<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $connection = 'mysql_tracking';

    protected $fillable = [
        'delivery_id',
        'latitude',
        'longitude',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * Generate random coordinates within Indonesia bounds
     * Latitude: -11 to 6
     * Longitude: 95 to 141
     */
    public static function generateRandomCoordinates()
    {
        return [
            'latitude' => rand(-11000000, 6000000) / 1000000,
            'longitude' => rand(95000000, 141000000) / 1000000,
        ];
    }

    public function getFormattedCoordinatesAttribute()
    {
        return $this->latitude . ', ' . $this->longitude;
    }
}