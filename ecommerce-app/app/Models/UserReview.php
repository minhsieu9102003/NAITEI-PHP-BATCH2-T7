<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'user_id',
        'order_item_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public $incrementing = false;

    protected $keyType = 'string';

    public static function booted(): void
    {
        static::creating(function (UserReview $userReview) {
            $userReview->id = Str::uuid();
        });
    }

}
