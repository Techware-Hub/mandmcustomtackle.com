<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    public const DEFAULT_COLORS = [
        'Glow Custom',
        'Red/White',
        'Oyster',
        'Lime a Rita',
        'Mardi Gras',
        'Kryptonite',
        'Blaze Orange',
        'Custom Flame Red',
        'Pearl',
        'Barnacle',
        'Amethyst Ring',
        'Batman',
        'Fluorescent Pink Custom',
        'Fluorescent Green Custom 2',
        'Bone',
        'Black Widow',
        'Bleeding Shiner',
        'Candy Pink',
        'Glitter Ball',
    ];

    public const DEFAULT_WEIGHTS = [
        '3/8 oz' => 2.50,
        '1/2 oz' => 2.50,
        '3/4 oz' => 2.75,
        '1 oz' => 3.10,
    ];

    protected $fillable = ['product_id', 'color_name', 'weight', 'price', 'sku', 'stock', 'status'];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isPurchasable(): bool
    {
        return $this->status === 'active' && $this->stock > 0 && $this->product?->status === 'active';
    }
}
