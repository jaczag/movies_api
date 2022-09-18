<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int|null $user_id
 * @property string $title
 * @property string|null $description
 * @property string $production_country
 * @property mixed $rates
 * @property mixed $id
 */
class Movie extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $table = 'movies';

    protected $fillable = [
        'title',
        'description',
        'production_country',
    ];

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
    }

    /**
     * @return string|null
     */
    public function avgRating(): null|string
    {
        return $this->rates()->avg('rate');
    }

    /**
     * @return HasMany
     */
    public function rates(): HasMany
    {
        return $this->hasMany(MovieRate::class);
    }

    /**
     * relation to the user who added the movie
     * @return BelongsTo
     */
    public function adder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
