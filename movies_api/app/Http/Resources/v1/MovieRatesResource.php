<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $user
 * @property mixed $id
 * @property mixed $movie
 */
class MovieRatesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'movie' => $this->whenLoaded('movie', MoviesResource::make($this->movie)),
            'user' => $this->whenLoaded('user', UserResource::make($this->user)),
            'rate' => $this->rate
        ];
    }
}
