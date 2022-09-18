<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\movies\StoreMovieRequest;
use App\Http\Requests\v1\movies\UpdateMovieRequest;
use App\Http\Resources\v1\MovieResource;
use App\Http\Resources\v1\MoviesCollection;
use App\Models\Movie;
use App\Services\v1\MoviesService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MoviesController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Movie::class, 'movie');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $search = Arr::get($request, 'search');
        $perPage = Arr::get($request, 'perPage', '10');
        $sortBy = Arr::get($request, 'sortBy', 'id');
        $orderBy = Arr::get($request, 'orderBy', 'desc');

        $movies = Movie::query()
            ->when($search, function (Builder $query) use ($search) {
                $query->where('title', 'like', $search . '%');
            })
            ->orderBy($sortBy, $orderBy)
            ->paginate($perPage);

        return $this->successResponse(MoviesCollection::make($movies));
    }

    /**
     * @param StoreMovieRequest $request
     * @param MoviesService $service
     * @return JsonResponse
     */
    public function store(StoreMovieRequest $request, MoviesService $service): JsonResponse
    {
        $data = $request->validated();

        try {
            $movie = $service->assignData($data)->getMovie();

            if ($request->has('cover')) {
                $movie->addMediaFromRequest('cover')->toMediaCollection('covers');
            }

            return $this->successResponse(MovieResource::make($movie));
        } catch (Exception $e) {
            DB::rollBack();
            reportError($e);
        }
        return $this->errorResponse();
    }

    /**
     * @param Movie $movie
     * @return JsonResponse
     */
    public function show(Movie $movie): JsonResponse
    {
        $movie->load(['adder', 'categories']);
        return $this->successResponse(MovieResource::make($movie));
    }

    /**
     * @param UpdateMovieRequest $request
     * @param Movie $movie
     * @return JsonResponse
     */
    public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
    {
        try {
            $_movie = (new MoviesService($movie))
                ->updateMovie($request->validated())
                ->getMovie();

            return $this->successResponse(MovieResource::make($_movie));
        } catch (Exception $e) {
            reportError($e);
        }
        return $this->errorResponse();
    }

    /**
     * @param Movie $movie
     * @return JsonResponse
     */
    public function destroy(Movie $movie): JsonResponse
    {
        if ($movie->delete()) {
            return $this->successResponse();
        }
        return $this->errorResponse();
    }
}
