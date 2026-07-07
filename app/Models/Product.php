<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'short_description', 'description', 'price', 'sale_price', 'stock', 'sku', 'image', 'status', 'color', 'rating', 'specs', 'featured'];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock' => 'integer',
        'rating' => 'integer',
        'specs' => 'array',
        'featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function currentPrice(): float
    {
        return (float) ($this->sale_price ?? $this->price);
    }

    public function isPurchasable(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->relationLoaded('variants') && $this->variants->isNotEmpty()) {
            return $this->variants->contains(fn (ProductVariant $variant) => $variant->status === 'active' && $variant->stock > 0);
        }

        return $this->stock > 0;
    }
}
