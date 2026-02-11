<?php

namespace App\Services;

use App\Repositories\AuthRepository;

class AuthService
{
    public function __construct(
        private AuthRepository $repository
    ) {
        
    }
    
    public function login(array $data): array
    {
        return $this->repository->login($data);
    }
}
