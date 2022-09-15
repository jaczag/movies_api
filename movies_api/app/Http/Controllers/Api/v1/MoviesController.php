<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\MoviesCollection;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $perPage = $request->get('perPage', 10);
        $sortBy = $request->get('sortBy', 'id');
        $orderBy = $request->get('orderBy', 'desc');

        $movies = Movie::query()
            ->when($search, function (Builder $query) use ($search) {
                $query->where('title', 'like', $search . '%');
            })
            ->orderBy($sortBy, $orderBy)
            ->paginate($perPage);

        return $this->successResponse(MoviesCollection::make($movies));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
