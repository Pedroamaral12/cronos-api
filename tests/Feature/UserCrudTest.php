<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\Traits\AuthenticationTestTrait;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use AuthenticationTestTrait;

    private User $user;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->beginTestTransaction();
        $this->user = $this->createTestUser();
        $this->token = $this->createUserLoginAndGetToken();
    }

    protected function tearDown(): void
    {
        $this->rollbackTestTransaction();
        parent::tearDown();
    }

    public function test_user_index_unauthorized(): void
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(401);
    }

    public function test_user_index_success(): void
    {
        $response = $this->withAuthToken($this->token)->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'cpf',
                            'email',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                    'current_page',
                    'last_page',
                    'per_page',
                    'total'
                ]
            ]);
    }

    public function test_user_index_pagination(): void
    {
        $this->createTestUser();
        $this->createTestUser();
        $this->createTestUser();

        $response = $this->withAuthToken($this->token)->getJson('/api/users?per_page=2');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data',
                    'current_page',
                    'last_page',
                    'per_page',
                    'total'
                ]
            ])
            ->assertJsonPath('data.per_page', 2)
            ->assertJsonCount(2, 'data.data');
    }

    public function test_user_show_unauthorized(): void
    {
        $response = $this->getJson("/api/users/{$this->user->id}");

        $response->assertStatus(401);
    }

    public function test_user_show_success(): void
    {
        $response = $this->withAuthToken($this->token)->getJson("/api/users/{$this->user->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'cpf',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertEquals($this->user->id, $response->json('data.id'));
    }

    public function test_user_show_not_found(): void
    {
        $response = $this->withAuthToken($this->token)->getJson('/api/users/999');

        $response->assertStatus(404);
    }

    public function test_user_store_unauthorized(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(401);
    }

    public function test_user_store_success(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'cpf' => '12345678901',
            'password' => 'password123',
        ];

        $response = $this->withAuthToken($this->token)->postJson('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'cpf',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User'
        ]);
    }

    public function test_user_store_validation_error(): void
    {
        $userData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
        ];

        $response = $this->withAuthToken($this->token)->postJson('/api/users', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_user_update_unauthorized(): void
    {
        $updateData = [
            'name' => 'Updated Name',
        ];

        $response = $this->putJson("/api/users/{$this->user->id}", $updateData);

        $response->assertStatus(401);
    }

    public function test_user_update_success(): void
    {
        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->withAuthToken($this->token)->putJson("/api/users/{$this->user->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com'
        ]);
    }

    public function test_user_update_not_found(): void
    {
        $updateData = [
            'name' => 'Updated Name',
        ];

        $response = $this->withAuthToken($this->token)->putJson('/api/users/999', $updateData);

        $response->assertStatus(404);
    }

    public function test_user_destroy_unauthorized(): void
    {
        $response = $this->deleteJson("/api/users/{$this->user->id}");

        $response->assertStatus(401);
    }

    public function test_user_destroy_success(): void
    {
        $response = $this->withAuthToken($this->token)->deleteJson("/api/users/{$this->user->id}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('users', [
            'id' => $this->user->id
        ]);
    }

    public function test_user_destroy_not_found(): void
    {
        $response = $this->withAuthToken($this->token)->deleteJson('/api/users/999');

        $response->assertStatus(404);
    }

    public function test_user_select_unauthorized(): void
    {
        $response = $this->getJson('/api/users/select');

        $response->assertStatus(401);
    }

    public function test_user_select_success(): void
    {
        $response = $this->withAuthToken($this->token)->getJson('/api/users/select');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name'
                    ]
                ]
            ]);
    }

    public function test_user_restore_unauthorized(): void
    {
        $response = $this->postJson("/api/users/restore/{$this->user->id}");

        $response->assertStatus(401);
    }

    public function test_user_restore_success(): void
    {
        $this->user->delete();

        $this->assertSoftDeleted('users', [
            'id' => $this->user->id
        ]);

        $response = $this->withAuthToken($this->token)->postJson("/api/users/restore/{$this->user->id}");

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'deleted_at' => null
        ]);
    }

    public function test_user_restore_not_found(): void
    {
        $response = $this->withAuthToken($this->token)->postJson('/api/users/restore/999');

        $response->assertStatus(404);
    }
}
