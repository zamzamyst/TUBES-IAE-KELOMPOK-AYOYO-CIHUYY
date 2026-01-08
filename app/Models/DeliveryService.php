<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryService extends Model
{
    use HasFactory;

    protected $connection = 'mysql_delivery';

    protected $table = 'delivery_services';

    protected $fillable = [
        'name',
        'price',
        'estimation_days',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'estimation_days' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get active delivery services only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
