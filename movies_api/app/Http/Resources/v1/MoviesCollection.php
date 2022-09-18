<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MoviesCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => MoviesResource::collection($this->collection),
            'pagination' => new PaginationResource($this)
        ];
    }
}
