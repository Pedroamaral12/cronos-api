<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginFormRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $service
    ) {
        //
    }

    public function login(AuthLoginFormRequest $request): JsonResponse
    {
        $result = $this->service->login($request->validated());

        if (!$result) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials',
                'data' => null,
            ], 401);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'data' => $result,
        ]);
    }

    public function getAuthMe(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'User data retrieved successfully',
            'data' => $request->user(),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->service->logout($request->user());

        return response()->json([
            'status' => 200,
            'message' => 'Logout successful',
            'data' => null,
        ]);
    }
}
