<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $connection = 'mysql_delivery';

    protected $fillable = [
        'order_id',
        'delivery_service_id',
        'delivery_address',
        'delivery_status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function deliveryService()
    {
        return $this->belongsTo(DeliveryService::class);
    }

    public function tracking()
    {
        return $this->hasOne(Tracking::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-500',
            'in_transit' => 'bg-blue-500',
            'delivered' => 'bg-green-500',
            'cancelled' => 'bg-red-500',
        ];

        return $badges[$this->delivery_status] ?? 'bg-gray-500';
    }

    public function getFormattedStatusAttribute()
    {
        $statuses = [
            'pending' => 'Menunggu',
            'in_transit' => 'Dalam Pengiriman',
            'delivered' => 'Terkirim',
            'cancelled' => 'Dibatalkan',
        ];

        return $statuses[$this->delivery_status] ?? $this->delivery_status;
    }
}
