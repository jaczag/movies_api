<?php

namespace App\Http\Resources\v1;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property integer $rate
 * @mixin User
 * @mixin Movie
 */
class MovieRateResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'movie' => MovieResource::make($this->whenLoaded('movie')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'rate' => $this->rate
        ];
    }
}
