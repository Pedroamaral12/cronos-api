<?php

namespace App\Repositories;

use App\Models\User;
use Hash;

class AuthRepository
{
    public function __construct(
        private User $entity
    ) {
    }

    public function login(array $data)
    {
         if (isset($data['email'])) {
            $user = $this->entity->where('email', $data['email'])->first();
        }
        
        if (!$user && isset($data['cpf'])) {
            $user = $this->entity->where('cpf', $data['cpf'])->first();
        }

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        return $user;
    }
}
