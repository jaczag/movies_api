<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int|null $user_id
 * @property string $title
 * @property string|null $description
 * @property string $production_country
 */
class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'movies';

    public static array $editableAtrributes = [
        'title',
        'description',
        'production_country',
    ];

    /**
     * relation to the user who added the movie
     * @return BelongsTo
     */
    public function adder(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function rates(): HasMany
    {
        return $this->hasMany(MovieRate::class);
    }
}
