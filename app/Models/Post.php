<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    //atur filable post
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'place',
        'category_id',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function postusers(): HasMany
    {
       return $this->hasMany(PostUser::class, 'post_id');
    }

    public function postadmins(): HasMany
    {
       return $this->hasMany(PostAdmin::class, 'post_id');
    }

    public function testimonials(): HasMany
    {
       return $this->hasMany(Testimonial::class, 'post_id');
    }

    public function comments(): HasMany
    {
       return $this->hasMany(Comment::class, 'post_id');
    }

    public function pricings(): HasMany
    {
        return $this->hasMany(Pricing::class, 'post_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
