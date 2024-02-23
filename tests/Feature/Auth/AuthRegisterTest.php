<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Middleware\LogUserInteraction;

class AuthRegisterTest extends TestCase
{
    use DatabaseTransactions;

    public function test_register_route_exists(): void
    {
        $this->assertNotNull(route('register'));
    }

    public function test_register_rejects_invalid_data(): void
    {
        foreach ($this->notValidRegisterData as $notValidData) {
            $this->registerUser($notValidData)->assertStatus(302);
        }
    }

    public function test_register_accepts_valid_data(): void
    {
        $this->registerUser($this->validRegisterData)->assertStatus(200);
    }

    public function test_register_should_create_and_return_a_user(): void
    {
        $response = $this->registerUser($this->validRegisterData);

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'name' => $this->validRegisterData['name'],
                    'email' => $this->validRegisterData['email'],
                ]
            ]);
    }

    public function test_register_should_return_a_token(): void
    {
        $response = $this->registerUser($this->validRegisterData);

        $response->assertStatus(200)
            ->assertJson([
                'access_token' => ['token' => true]
            ]);
    }

    public function test_access_token_should_expire_in_30_minutes(): void
    {
        $response = $this->registerUser($this->validRegisterData);

        $response->assertStatus(200)
            ->assertJson(['access_token' => ['expires_in' => 29]]);
    }

    private $notValidRegisterData = [
        [],
        [
            'name' => '',
            'email' => '',
            'password' => '',
        ],
        [
            'name' => 'Test name',
            'email' => 'not.an.email',
            'password' => 'password1234',
        ],
        [
            'name' => 'Test name',
            'email' => 'my@email.com',
            'password' => 'short',
        ]
    ];

    private $validRegisterData = [
        'name' => 'Test name',
        'email' => 'my@email.com',
        'password' => 'password1234',
    ];

    private function registerUser($userData)
    {
        return $this->withoutMiddleware(LogUserInteraction::class)
            ->post(route('register'), $userData);
    }
}
