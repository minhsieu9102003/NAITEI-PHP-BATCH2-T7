<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'image',
        'qty_in_stock',
        'category_id',
        'price',
    ];

    protected $keyType = 'string';

    public static function booted(): void
    {
        static::creating(function (Product $product) {
            $product->id = Str::uuid();
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
