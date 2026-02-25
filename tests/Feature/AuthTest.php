<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\Traits\AuthenticationTestTrait;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use AuthenticationTestTrait;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->beginTestTransaction();
        $this->user = $this->createTestUser();
    }

    protected function tearDown(): void
    {
        $this->rollbackTestTransaction();
        parent::tearDown();
    }

    public function test_login_with_email_success(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'token',
                    'user'
                ]
            ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $this->user->id
        ]);
    }

    public function test_login_with_cpf_success(): void
    {
        $userWithCpf = $this->createTestUserWithCpf();

        $response = $this->postJson('/api/login', [
            'cpf' => $userWithCpf->cpf,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'token',
                    'user'
                ]
            ]);
    }

    public function test_login_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'status' => 401,
                'message' => 'Invalid credentials',
                'data' => null,
            ]);
    }

    public function test_login_validation_required_fields(): void
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_login_validation_email_or_cpf_required(): void
    {
        $response = $this->postJson('/api/login', [
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_get_auth_me_success(): void
    {
        $token = $this->generateApiToken($this->user);

        $response = $this->withAuthToken($token)->getJson('/api/auth/me');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertEquals($this->user->id, $response->json('data.id'));
    }

    public function test_get_auth_me_unauthorized(): void
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401);
    }

    public function test_logout_success(): void
    {
        $token = $this->generateApiToken($this->user);

        $response = $this->withAuthToken($token)->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Logout successful',
                'data' => null,
            ]);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $this->user->id,
            'name' => 'test-token'
        ]);
    }

    public function test_logout_unauthorized(): void
    {
        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(401);
    }
}
