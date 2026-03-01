<?php

namespace App\Docs;

/**
 * @OA\Info(
 *     title="Cronos API",
 *     version="1.0.0",
 *     description="API documentation for Cronos application with authentication and user management"
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local server"
 * )
 * 
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication endpoints"
 * )
 * 
 * @OA\Tag(
 *     name="Users",
 *     description="User management endpoints"
 * )
 * 
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     securityScheme="sanctum",
 *     name="Authorization",
 *     in="header",
 *     description="Enter token in format (Bearer <token>)"
 * )
 */
class OpenApi {}