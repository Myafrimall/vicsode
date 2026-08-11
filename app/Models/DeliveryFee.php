<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'state',
        'fee',
        'is_active',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public static function getFeeForState($state)
    {
        $deliveryFee = self::where('state', $state)->where('is_active', true)->first();
        return $deliveryFee ? $deliveryFee->fee : 0;
    }
}
