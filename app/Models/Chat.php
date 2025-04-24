<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    //
    protected $fillable = [
        'user_id',
        'message',
        'message_at',
    ];

    protected $casts = [
        'message_at' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function postAdmin(): BelongsTo
    {
        return $this->belongsTo(PostAdmin::class, 'post_admin_id');
    }
}
