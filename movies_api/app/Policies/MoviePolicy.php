<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoviePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * @param User $user
     * @param Movie $movie
     * @return bool
     */
    public function view(User $user,Movie $movie): bool
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
        return $user->email_verified_at !== null;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Movie $movie
     * @return bool
     */
    public function update(User $user, Movie $movie): bool
    {
        return $user->email_verified_at !== null && $user->id === $movie->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Movie $movie
     * @return bool
     */
    public function delete(User $user, Movie $movie): bool
    {
        return $user->email_verified_at !== null && $user->id === $movie->user_id;
    }
}
