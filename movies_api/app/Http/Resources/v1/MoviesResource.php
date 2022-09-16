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
 * @method getFirstMedia()
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
            'avg_rating' => $this->avgRating(),
            'added_by' => UserResource::make($this->whenLoaded('adder')),
            'categories' => CategoriesResource::collection($this->whenLoaded('categories')),
            'country_of_production' => $this->production_country,
            'description' => $this->description,
            'cover_url' => $this->when($this->getFirstMedia(), fn() => $this->getFirstMedia()->getUrl('thumb'), null),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
