<?php

namespace Tests\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

trait AuthenticationTestTrait
{
    protected function createTestUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'password' => Hash::make('password123'),
        ], $attributes));
    }

    protected function createTestUserWithCpf(array $attributes = []): User
    {
        return $this->createTestUser([
            'cpf' => '12345678901',
        ] + $attributes);
    }

    protected function generateApiToken(User $user, string $tokenName = 'test-token'): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }

    /**
     * Login with CPF and password and return token
     */
    protected function loginWithCpfAndGetToken(string $cpf, string $password = 'password123'): string
    {
        $response = $this->postJson('/api/login', [
            'cpf' => $cpf,
            'password' => $password,
        ]);

        $token = $response->json('data.token');
        
        if (!$token) {
            throw new \Exception('Login failed: no token returned');
        }
        
        return $token;
    }

    protected function createUserLoginAndGetToken(array $userAttributes = []): string
    {
        $user = $this->createTestUser($userAttributes);
        return $this->loginWithCpfAndGetToken($user->cpf);
    }

    protected function createUserWithCpfLoginAndGetToken(array $userAttributes = []): string
    {
        $user = $this->createTestUserWithCpf($userAttributes);
        return $this->loginWithCpfAndGetToken($user->cpf);
    }

    protected function withAuthToken(string $token): self
    {
        return $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ]);
    }

    protected function beginTestTransaction(): void
    {
        DB::beginTransaction();
    }

    protected function rollbackTestTransaction(): void
    {
        DB::rollBack();
    }
}
