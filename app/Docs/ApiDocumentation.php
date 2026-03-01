<?php

namespace App\Docs;

/**
 * @OA\OpenApi(
 *     info=@OA\Info(
 *         title="Cronos API",
 *         version="1.0.0",
 *         description="API documentation for Cronos application with authentication and user management"
 *     ),
 *     servers={
 *         @OA\Server(
 *             url="http://localhost:8000",
 *             description="Local server"
 *         )
 *     },
 *     tags={
 *         @OA\Tag(
 *             name="Auth",
 *             description="Authentication endpoints"
 *         ),
 *         @OA\Tag(
 *             name="Users",
 *             description="User management endpoints"
 *         )
 *     },
 *     components=@OA\Components(
 *         securitySchemes=@OA\SecurityScheme(
 *             securityScheme="sanctum",
 *             type="apiKey",
 *             name="Authorization",
 *             in="header",
 *             description="Enter token in format (Bearer <token>)"
 *         )
 *     ),
 *     paths=@OA\PathItem(
 *         path="/api/login",
 *         post=@OA\Post(
 *             summary="User login",
 *             tags={"Auth"},
 *             requestBody=@OA\RequestBody(
 *                 required=true,
 *                 @OA\JsonContent(
 *                     required={"password"},
 *                     @OA\Property(property="email", type="string", format="email"),
 *                     @OA\Property(property="cpf", type="string"),
 *                     @OA\Property(property="password", type="string", minLength=6)
 *                 )
 *             ),
 *             responses={
 *                 @OA\Response(
 *                     response=200,
 *                     description="Login successful",
 *                     @OA\JsonContent(
 *                         @OA\Property(property="status", type="integer", example=200),
 *                         @OA\Property(property="message", type="string", example="Login successful"),
 *                         @OA\Property(property="data", type="object")
 *                     )
 *                 ),
 *                 @OA\Response(
 *                     response=401,
 *                     description="Invalid credentials",
 *                     @OA\JsonContent(
 *                         @OA\Property(property="status", type="integer", example=401),
 *                         @OA\Property(property="message", type="string", example="Invalid credentials"),
 *                         @OA\Property(property="data", type="object", example=null)
 *                     )
 *                 )
 *             }
 *         )
 *     )
 * )
 */
class ApiDocumentation {}
