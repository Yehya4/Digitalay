<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDuration extends Model
{
    protected $fillable = [
        'product_id',
        'duration_name',
        'price',
        'original_price',
        'sort_order'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getDiscountPercentAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (int)((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }
}
