<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pricing extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'post_id',
        'price',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function isSubscribedByUser($userId)
    {
        return $this->transactions()
        ->where('user_id', $userId)
        ->where('is_paid', true) //hanya yg sudah membeli yg bisa akses
        ->where('ended_at', '>=', now())
        ->exists();
    }
}
