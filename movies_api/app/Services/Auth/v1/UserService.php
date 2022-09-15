<?php

namespace App\Services\Auth\v1;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @param User $user
     */
    public function __construct(private readonly User $user = new User())
    {
    }

    /**
     * @param array $data
     * @return $this
     */
    public function assignData(array $data): static
    {
        $this->user->first_name = $data['first_name'];
        $this->user->last_name = $data['last_name'];
        $this->user->email = $data['email'];
        $this->user->password = Hash::make($data['password']);
        $this->user->email_verified_at = now();
        $this->user->save();

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
