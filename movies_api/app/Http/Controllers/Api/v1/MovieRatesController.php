<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\movieRates\StoreMovieRateRequest;
use App\Http\Requests\v1\movieRates\UpdateMovieRateRequest;
use App\Http\Resources\v1\MovieRateResource;
use App\Models\Movie;
use App\Models\MovieRate;
use App\Services\v1\MovieRatesSerivce;
use Exception;
use Illuminate\Http\JsonResponse;

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
        return $this->successResponse(MovieRateResource::collection($movie->rates));
    }

    /**
     * @param StoreMovieRateRequest $request
     * @param Movie $movie
     * @param MovieRatesSerivce $service
     * @return JsonResponse
     */
    public function store(
        StoreMovieRateRequest $request,
        Movie $movie,
        MovieRatesSerivce $service
    ): JsonResponse {
        $data = $request->validated();
        try {
            $rate = $service->setMovie($movie)->assignData($data)->getRate();
            return $this->successResponse(MovieRateResource::make($rate));
        } catch (Exception $e) {
            reportError($e);
        }
        return $this->errorResponse();
    }

    /**
     * @param UpdateMovieRateRequest $request
     * @param Movie $movie
     * @param MovieRate $rate
     * @return JsonResponse
     */
    public function update(
        UpdateMovieRateRequest $request,
        Movie $movie,
        MovieRate $rate,
    ): JsonResponse {
        try {
            $rate = (new MovieRatesSerivce($rate))
                ->updateData($request->validated())
                ->getRate();

            return $this->successResponse(MovieRateResource::make($rate));
        } catch (Exception $e) {
            reportError($e);
        }
        return $this->errorResponse();
    }

    /**
     * @param Movie $movie
     * @param MovieRate $rate
     * @return JsonResponse
     */
    public function destroy(Movie $movie, MovieRate $rate): JsonResponse
    {
        if ($rate->delete()) {
            return $this->successResponse();
        }
        return $this->errorResponse();
    }
}
