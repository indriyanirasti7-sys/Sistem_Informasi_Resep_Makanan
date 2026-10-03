<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function recipes()   { return $this->hasMany(Recipe::class); }
    public function bookmarks() { return $this->hasMany(Bookmark::class); }
    public function ratings()   { return $this->hasMany(Rating::class); }
    public function tips()      { return $this->hasMany(Tip::class); }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}