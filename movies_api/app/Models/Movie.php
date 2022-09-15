<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'movies';

    /**
     * relation to the user who added the movie
     * @return BelongsTo
     */
    public function adder(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
