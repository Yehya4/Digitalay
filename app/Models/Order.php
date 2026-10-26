<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name', 'customer_phone', 'customer_email',
        'note', 'total_amount', 'status', 'payment_method'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
