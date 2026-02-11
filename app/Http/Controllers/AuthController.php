<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginFormRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $service
    ) {
        //
    }

    public function login(AuthLoginFormRequest $request)
    {
        return $this->service->login($request->validated());
    }

    public function getAuthMe(Request $request)
    {
        //
    }

    public function logout(Request $request)
    {
        //
    }
}
