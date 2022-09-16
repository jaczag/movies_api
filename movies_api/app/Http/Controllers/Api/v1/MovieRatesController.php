<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\MovieRatesResource;
use App\Http\Resources\v1\MoviesResource;
use App\Models\Movie;
use App\Models\MovieRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieRatesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MovieRate::class, 'rate');
    }

    /**
     * @param Movie $movie
     * @return JsonResponse
     */
    public function index(Movie $movie): JsonResponse
    {
        return $this->successResponse(MovieRatesResource::collection($movie->rates()->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param Request $request
     * @param Movie $movie
     * @return JsonResponse
     */
    public function store(Request $request, Movie $movie): JsonResponse
    {
        $data = $request->validate([
            'rate' => ['required', 'integer', 'between:1,10']
        ]);

        if (MovieRate::create([
            'movie_id' => $movie->id,
            'user_id' => Auth::id(),
            'rate' => $data['rate']
        ])) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Movie $movie
     * @param MovieRate $rate
     * @return JsonResponse
     */
    public function update(Request $request,Movie $movie,MovieRate $rate): JsonResponse
    {
        $data = $request->validate([
            'rate' => ['required', 'integer', 'between:1,10']
        ]);

        if($movie->rates()->where('id', $rate->id)->update($data)) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie
     * @param MovieRate $rate
     * @return JsonResponse
     */
    public function destroy(Movie $movie, MovieRate $rate): JsonResponse
    {
        if($movie->rates()->where('id', $rate->id)->delete()) {
            return $this->successResponse();
        }
        return $this->errorResponse();
    }
}
