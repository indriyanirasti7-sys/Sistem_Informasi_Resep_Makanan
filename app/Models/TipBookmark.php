<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipBookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tip_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Tip
    public function tip()
    {
        return $this->belongsTo(Tip::class);
    }
}