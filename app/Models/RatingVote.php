<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingVote extends Model
{
    protected $fillable = ['user_id', 'rating_id', 'vote_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

     public function votes()
    {
        return $this->hasMany(RatingVote::class);
    }

     public function userVote()
    {
        return $this->hasOne(RatingVote::class)->where('user_id', auth()->id());
    }
}