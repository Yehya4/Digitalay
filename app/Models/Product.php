<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'original_price',
        'image', 'image_url', 'features', 'badge', 'badge_color',
        'whatsapp_message', 'is_active', 'is_featured', 'stock', 'duration_months'
    ];

    public function durations()
    {
        return $this->hasMany(ProductDuration::class)->orderBy('sort_order');
    }

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFeaturesListAttribute()
    {
        if ($this->features) {
            return array_filter(array_map('trim', explode("\n", $this->features)));
        }
        return [];
    }

    public function getDiscountPercentAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (int)((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
