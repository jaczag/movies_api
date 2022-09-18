<?php

namespace App\Services\v1;

use App\Models\Movie;
use App\Models\MovieRate;
use Illuminate\Support\Facades\Auth;

class MovieRatesSerivce
{
    private Movie $movie;

    public function __construct(private MovieRate $rate = new MovieRate())
    {
    }

    /**
     * @param Movie $movie
     * @return $this
     */
    public function setMovie(Movie $movie): static
    {
        $this->movie = $movie;
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function assignData(array $data): static
    {
        $this->rate->movie_id = $this->movie->id;
        $this->rate->user_id = Auth::id();
        $this->rate->rate = $data['rate'];
        $this->rate->save();

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function updateData(array $data): static
    {
        $this->rate->rate = $data['rate'];
        $this->rate->save();
        return $this;
    }


    /**
     * @return MovieRate
     */
    public function getRate(): MovieRate
    {
        return $this->rate;
    }
}
