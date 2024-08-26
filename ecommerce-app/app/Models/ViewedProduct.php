<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ViewedProduct extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';
    protected $fillable = ['user_id', 'product_id', 'viewed_at'];
    public static function booted(): void
    {
        static::creating(function (ViewedProduct $viewedProduct) {
            $viewedProduct->id = Str::uuid();
        });
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
