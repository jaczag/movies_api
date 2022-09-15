<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $adder
 * @property mixed $id
 * @property mixed $title
 * @property mixed $production_country
 * @property mixed $description
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class MoviesResource extends JsonResource
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
            'title' => $this->title,
            'added_by' => $this->whenLoaded('adder', UserResource::make($this->adder)),
            'categories' => $this->whenLoaded('categories', CategoriesResource::collection($this->categories)),
            'country_of_production' => $this->production_country,
            'description' => $this->description,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
