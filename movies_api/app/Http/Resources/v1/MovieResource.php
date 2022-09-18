<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User $adder
 * @property integer $id
 * @property string $title
 * @property string $production_country
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method getFirstMedia()
 * @method avgRating()
 */
class MovieResource extends JsonResource
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
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'country_of_production' => $this->production_country,
            'description' => $this->description,
            'cover_url' => $this->when($this->getFirstMedia(), fn() => $this->getFirstMedia()->getUrl('thumb'), null),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
