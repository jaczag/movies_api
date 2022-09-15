<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $first_name
 * @property mixed $email_verified_at
 * @property mixed $email
 * @property mixed $last_name
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class UserResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'verified_at' => $this->when(
                $this->email_verified_at, $this->email_verified_at->toDateTimeString(),null
            ),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
