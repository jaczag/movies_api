<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected array $headers;

    /**
     * Test user registration was successful
     * @return void
     */
    public function test_success_user_registration(): void
    {
        $response = $this->postJson(route('auth.register'), [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'password_confirmation' => 'password'
        ], $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
                'code' => 200
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $this->user->email,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
        ]);
    }

    /**
     * Test user logged in successful
     * @return void
     */
    public function test_user_login_success(): void
    {
        $response = $this->postJson(route('auth.login'), [
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                    "status",
                    "data" => [
                        "user" => [
                            "id",
                            "first_name",
                            "last_name",
                            "email",
                            "verified_at",
                            "created_at",
                            "updated_at",
                        ],
                        "token"
                    ],
                    "message",
                    "code",
                ]
            );

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $this->user->id,
        ]);
    }

    /**
     * test existing user try to login with invalid password
     * @return void
     */
    public function test_user_login_with_invalid_credentials(): void
    {
        $response = $this->postJson(route('auth.login'), [
            'email' => $this->user->email,
            'password' => 'justtesting'
        ], $this->headers);

        $response->assertStatus(401);
    }

    /**
     * test login not registered user
     * @return void
     */
    public function test_not_registered_user_login(): void
    {
        $response = $this->postJson(route('auth.login'), [
            'email' => fake()->email,
            'password' => fake()->password
        ], $this->headers);

        $response->assertStatus(401);
    }

    /**
     * setup basic state
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
