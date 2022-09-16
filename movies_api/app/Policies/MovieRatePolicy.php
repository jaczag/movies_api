<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\MovieRate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovieRatePolicy
{
    use HandlesAuthorization;
    private ?Movie $movie;

    public function __construct() {
        $this->movie = request()->route('movie');
    }
    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->email_verified_at !== null && $user->id !== $this->movie->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param MovieRate $rate
     * @return bool
     */
    public function update(User $user, MovieRate $rate): bool
    {
        return $user->id === $rate->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param MovieRate $rate
     * @return bool
     */
    public function delete(User $user, MovieRate $rate): bool
    {
        return $user->id === $rate->user_id;
    }
}
