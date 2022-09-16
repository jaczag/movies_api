<?php

namespace App\Services\v1;

use App\Models\Movie;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class MoviesService
{
    /**
     * @param Movie $movie
     */
    public function __construct(private Movie $movie = new Movie())
    {
    }

    /**
     * @param array $data
     * @return $this
     */
    public function assignData(array $data): static
    {
        $this->movie->user_id = Auth::id() ?? null;
        $this->movie->title = $data['title'];
        $this->movie->production_country = $data['production_country'];
        $this->movie->description = Arr::get($data, 'description');
        $this->movie->save();
        $this->movie->categories()->attach($data['categories_ids']);

        return $this;
    }

    /**
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function updateMovie(array $data): static
    {
        if (Arr::get($data, 'categories_ids')) {
            $this->movie->categories()->attach($data['categories_ids']);
            Arr::forget($data, 'categories_ids');
        }
        $this->movie->update($data);
        return $this;
    }
}
