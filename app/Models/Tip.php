<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'user_id',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($tip) {
            if (empty($tip->slug)) {
                $tip->slug = Str::slug($tip->title) . '-' . Str::random(4);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel simpanan tips
    public function bookmarks()
    {
        return $this->hasMany(TipBookmark::class);
    }

    public function getRouteKeyName():string
    {
        return 'slug';
    }
}