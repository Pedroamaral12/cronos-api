<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends CrudController
{
    public function __construct(UserService $userService)
    {
        parent::__construct($userService);
    }

    public function beforeStore(UserFormRequest $request): JsonResponse
    {
        $data = $this->service->create($request->all());
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'User created successfully'
        ], 201);
    }

    public function beforeUpdate(int $id, UserFormRequest $request): JsonResponse
    {
        $data = $this->service->update($id, $request->all());
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'User updated successfully'
        ]);
    }
}
