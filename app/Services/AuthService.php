<?php

namespace App\Services;

use App\Repositories\AuthRepository;

class AuthService
{
    public function __construct(
        private AuthRepository $repository
    ) {
        
    }
    
    public function login(array $data)
    {
        $user = $this->repository->login($data);
        
        if (!$user) {
            return null;
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return [
            'user' => $user,
            'token' => $token,
        ];
    }
    
    public function logout($user)
    {
        $user->currentAccessToken()->delete();
        return true;
    }
}
