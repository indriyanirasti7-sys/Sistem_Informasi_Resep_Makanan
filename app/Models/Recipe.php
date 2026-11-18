<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'user_id',
        'description',
        'servings',
        'duration_minutes',
        'difficulty',
        'calories',
        'image',
        'status',
        'views',
    ];

    protected $casts = [
        'servings'         => 'integer',
        'duration_minutes' => 'integer',
        'calories'         => 'integer',
        'views'            => 'integer',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($recipe) {
            if (empty($recipe->slug)) {
                $recipe->slug = Str::slug($recipe->title) . '-' . Str::random(4);
            }
        });
    }

    // ---------- Relasi ----------

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function steps()
    {
        return $this->hasMany(RecipeStep::class)->orderBy('step_number');
    }

    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients')
                    ->withPivot('amount', 'unit')
                    ->withTimestamps();
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // ---------- Scopes ----------

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    // ---------- Accessor ----------

    public function getAverageRatingAttribute()
    {
        return round($this->ratings()->avg('rating') ?? 0, 1);
    }

    public function getRatingCountAttribute()
    {
        return $this->ratings()->count();
    }

    public function getDifficultyColorAttribute(): string
    {
        return match ($this->difficulty) {
            'Mudah' => 'green',
            'Sedang' => 'orange',
            'Sulit' => 'red',
            default => 'gray',
        };
    }

    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration_minutes) return '-';
        $h = intdiv($this->duration_minutes, 60);
        $m = $this->duration_minutes % 60;
        return $h > 0 ? "{$h} jam {$m} menit" : "{$m} menit";
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}