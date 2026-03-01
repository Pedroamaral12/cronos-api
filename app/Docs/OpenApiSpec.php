<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Cronos API',
    version: '1.0.0',
    description: 'API documentation for Cronos application'
)]
#[OA\Server(
    url: 'http://localhost:8000',
    description: 'Local server'
)]
#[OA\Tag(
    name: 'Auth',
    description: 'Authentication endpoints'
)]
#[OA\Tag(
    name: 'Users',
    description: 'User management endpoints'
)]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'apiKey',
    name: 'Authorization',
    in: 'header',
    description: 'Enter token in format (Bearer <token>)'
)]
class OpenApiSpec
{
    #[OA\Post(
        path: '/api/login',
        summary: 'User login',
        tags: ['Auth']
    )]
    #[OA\Response(response: 200, description: 'Login successful')]
    #[OA\Response(response: 401, description: 'Invalid credentials')]
    public function login(): void
    {
    }

    #[OA\Get(
        path: '/api/auth/me',
        summary: 'Get authenticated user data',
        tags: ['Auth'],
        security: [['sanctum' => []]]
    )]
    #[OA\Response(response: 200, description: 'User data retrieved')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    public function authMe(): void
    {
    }

    #[OA\Post(
        path: '/api/auth/logout',
        summary: 'User logout',
        tags: ['Auth'],
        security: [['sanctum' => []]]
    )]
    #[OA\Response(response: 200, description: 'Logout successful')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    public function logout(): void
    {
    }

    #[OA\Get(
        path: '/api/users',
        summary: 'Get list of users',
        tags: ['Users'],
        security: [['sanctum' => []]]
    )]
    #[OA\Response(response: 200, description: 'List of users retrieved successfully')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    public function usersIndex(): void
    {
    }

    #[OA\Post(
        path: '/api/users',
        summary: 'Create a new user',
        tags: ['Users'],
        security: [['sanctum' => []]]
    )]
    #[OA\Response(response: 201, description: 'User created successfully')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    #[OA\Response(response: 422, description: 'Validation error')]
    public function usersStore(): void
    {
    }

    #[OA\Get(
        path: '/api/users/{id}',
        summary: 'Get specific user',
        tags: ['Users'],
        security: [['sanctum' => []]]
    )]
    #[OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: 200, description: 'User retrieved successfully')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    #[OA\Response(response: 404, description: 'User not found')]
    public function usersShow(): void
    {
    }

    #[OA\Put(
        path: '/api/users/{id}',
        summary: 'Update user',
        tags: ['Users'],
        security: [['sanctum' => []]]
    )]
    #[OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: 200, description: 'User updated successfully')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    #[OA\Response(response: 404, description: 'User not found')]
    #[OA\Response(response: 422, description: 'Validation error')]
    public function usersUpdate(): void
    {
    }

    #[OA\Delete(
        path: '/api/users/{id}',
        summary: 'Delete user',
        tags: ['Users'],
        security: [['sanctum' => []]]
    )]
    #[OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: 200, description: 'User deleted successfully')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    #[OA\Response(response: 404, description: 'User not found')]
    public function usersDestroy(): void
    {
    }
}
