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

/**
 * @OA\PathItem(
 *     path="/api/login",
 *     @OA\Post(
 *         summary="User login",
 *         tags={"Auth"},
 *         @OA\RequestBody(
 *             required=true,
 *             @OA\JsonContent(
 *                 required={"password"},
 *                 @OA\Property(property="email", type="string", format="email"),
 *                 @OA\Property(property="cpf", type="string"),
 *                 @OA\Property(property="password", type="string", minLength=6)
 *             )
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="Login successful",
 *             @OA\JsonContent(
 *                 @OA\Property(property="status", type="integer", example=200),
 *                 @OA\Property(property="message", type="string", example="Login successful"),
 *                 @OA\Property(property="data", type="object")
 *             )
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Invalid credentials",
 *             @OA\JsonContent(
 *                 @OA\Property(property="status", type="integer", example=401),
 *                 @OA\Property(property="message", type="string", example="Invalid credentials"),
 *                 @OA\Property(property="data", type="object", example=null)
 *             )
 *         )
 *     )
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/auth/me",
 *     @OA\Get(
 *         summary="Get authenticated user data",
 *         tags={"Auth"},
 *         security={{"sanctum":{}}},
 *         @OA\Response(
 *             response=200,
 *             description="User data retrieved",
 *             @OA\JsonContent(
 *                 @OA\Property(property="status", type="integer", example=200),
 *                 @OA\Property(property="message", type="string", example="User data retrieved successfully"),
 *                 @OA\Property(property="data", type="object")
 *             )
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Unauthenticated"
 *         )
 *     )
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/auth/logout",
 *     @OA\Post(
 *         summary="User logout",
 *         tags={"Auth"},
 *         security={{"sanctum":{}}},
 *         @OA\Response(
 *             response=200,
 *             description="Logout successful",
 *             @OA\JsonContent(
 *                 @OA\Property(property="status", type="integer", example=200),
 *                 @OA\Property(property="message", type="string", example="Logout successful"),
 *                 @OA\Property(property="data", type="object", example=null)
 *             )
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Unauthenticated"
 *         )
 *     )
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/users",
 *     @OA\Get(
 *         summary="Get list of users",
 *         tags={"Users"},
 *         security={{"sanctum":{}}},
 *         @OA\Parameter(
 *             name="page",
 *             in="query",
 *             description="Page number",
 *             required=false,
 *             @OA\Schema(type="integer", default=1)
 *         ),
 *         @OA\Parameter(
 *             name="per_page",
 *             in="query",
 *             description="Items per page",
 *             required=false,
 *             @OA\Schema(type="integer", default=15)
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="List of users retrieved successfully"
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Unauthenticated"
 *         )
 *     ),
 *     @OA\Post(
 *         summary="Create a new user",
 *         tags={"Users"},
 *         security={{"sanctum":{}}},
 *         @OA\RequestBody(
 *             required=true,
 *             @OA\JsonContent(
 *                 required={"name","email","password"},
 *                 @OA\Property(property="name", type="string", maxLength=255),
 *                 @OA\Property(property="email", type="string", format="email"),
 *                 @OA\Property(property="password", type="string", minLength=8),
 *                 @OA\Property(property="cpf", type="string", maxLength=11),
 *                 @OA\Property(property="phone", type="string", maxLength=20)
 *             )
 *         ),
 *         @OA\Response(
 *             response=201,
 *             description="User created successfully",
 *             @OA\JsonContent(
 *                 @OA\Property(property="success", type="boolean", example=true),
 *                 @OA\Property(property="message", type="string", example="User created successfully"),
 *                 @OA\Property(property="data", type="object")
 *             )
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Unauthenticated"
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Validation error"
 *         )
 *     )
 * )
 */

/**
 * @OA\PathItem(
 *     path="/api/users/{id}",
 *     @OA\Get(
 *         summary="Get specific user",
 *         tags={"Users"},
 *         security={{"sanctum":{}}},
 *         @OA\Parameter(
 *             name="id",
 *             in="path",
 *             description="User ID",
 *             required=true,
 *             @OA\Schema(type="integer")
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="User retrieved successfully"
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Unauthenticated"
 *         ),
 *         @OA\Response(
 *             response=404,
 *             description="User not found"
 *         )
 *     ),
 *     @OA\Put(
 *         summary="Update user",
 *         tags={"Users"},
 *         security={{"sanctum":{}}},
 *         @OA\Parameter(
 *             name="id",
 *             in="path",
 *             description="User ID",
 *             required=true,
 *             @OA\Schema(type="integer")
 *         ),
 *         @OA\RequestBody(
 *             required=true,
 *             @OA\JsonContent(
 *                 @OA\Property(property="name", type="string", maxLength=255),
 *                 @OA\Property(property="email", type="string", format="email"),
 *                 @OA\Property(property="password", type="string", minLength=8),
 *                 @OA\Property(property="cpf", type="string", maxLength=11),
 *                 @OA\Property(property="phone", type="string", maxLength=20)
 *             )
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="User updated successfully",
 *             @OA\JsonContent(
 *                 @OA\Property(property="success", type="boolean", example=true),
 *                 @OA\Property(property="message", type="string", example="User updated successfully"),
 *                 @OA\Property(property="data", type="object")
 *             )
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Unauthenticated"
 *         ),
 *         @OA\Response(
 *             response=404,
 *             description="User not found"
 *         ),
 *         @OA\Response(
 *             response=422,
 *             description="Validation error"
 *         )
 *     ),
 *     @OA\Delete(
 *         summary="Delete user",
 *         tags={"Users"},
 *         security={{"sanctum":{}}},
 *         @OA\Parameter(
 *             name="id",
 *             in="path",
 *             description="User ID",
 *             required=true,
 *             @OA\Schema(type="integer")
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="User deleted successfully"
 *         ),
 *         @OA\Response(
 *             response=401,
 *             description="Unauthenticated"
 *         ),
 *         @OA\Response(
 *             response=404,
 *             description="User not found"
 *         )
 *     )
 * )
 */
class Swagger {}
