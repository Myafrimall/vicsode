<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'status',
        'subtotal',
        'delivery_fee',
        'total',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_address',
        'delivery_city',
        'delivery_state',
        'delivery_zip',
        'delivery_country',
        'delivery_notes',
        'payment_method',
        'payment_status',
        'payment_reference',
        'review_token',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public static function generateOrderNumber()
    {
        return 'BLD-' . strtoupper(uniqid());
    }
}
