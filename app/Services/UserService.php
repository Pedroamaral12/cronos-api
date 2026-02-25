<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends CrudService
{
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct($userRepository);
    }
}
