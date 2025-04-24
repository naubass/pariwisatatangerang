<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('super admin');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'user_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function getActiveSubscriptions()
    {
        return $this->transactions()
        ->where('is_paid', true)
        ->where('ended_at', '>=', now())
        ->first(); // ambil data get transactions
    }

    public function hasActiveSubscriptions()
    {
        return $this->transactions()
        ->where('is_paid', true)
        ->where('ended_at', '>=', now())
        ->exists(); // ambil data get transactions
    }

    // app/Models/User.php

public function getAvatarAttribute()
{
    if ($this->photo && file_exists(public_path('storage/' . $this->photo))) {
        return asset('storage/' . $this->photo);
    }

    // fallback default Chatify
    return asset('vendor/chatify/images/avatar.png');
}

    
}
