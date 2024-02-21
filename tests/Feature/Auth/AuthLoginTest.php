<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_route_exists(): void
    {
        $this->assertNotNull(route('login'));
    }

    public function test_login_rejects_invalid_data(): void
    {
        foreach ($this->notValidLoginData as $notValidData) {
            $this->login($notValidData)->assertStatus(302);
        }
    }

    public function test_login_accepts_valid_data(): void
    {
        $statusCode = $this->login($this->validLoginData)->getStatusCode();
        $this->assertNotEquals(302, $statusCode);
    }

    public function test_login_should_return_status_401_when_user_is_not_found(): void
    {
        $this->login($this->validLoginData)->assertStatus(401);
    }

    public function test_login_should_return_a_user_when_it_logs_in(): void
    {
        $user = $this->createTestUser();

        $this->login($this->validLoginData)->assertJson([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function test_user_login_should_return_an_access_token(): void
    {
        $this->createTestUser();

        $this->login($this->validLoginData)->assertJson([
            'access_token' => ['token' => true]
        ]);
    }

    public function test_access_token_should_expire_in_30_minutes(): void
    {
        $this->createTestUser();

        $this->login($this->validLoginData)->assertStatus(200)
            ->assertJson(['access_token' => ['expires_in' => 29]]);
    }

    private $notValidLoginData = [
        [],
        [
            'email' => '',
            'password' => '',
        ],
        [
            'email' => 'not.an.email',
            'password' => '12345678',
        ],
        [
            'email' => 'valid@email.com',
            'password' => '',
        ],
    ];

    private $validLoginData = [
        'email' => 'valid@email.com',
        'password' => '12345678',
    ];

    private function login($userData)
    {
        return $this->post(route('login'), $userData);
    }

    private function createTestUser()
    {
        return User::factory()->create([
            'name' => 'A test user',
            'email' => $this->validLoginData['email'],
            'password' => bcrypt($this->validLoginData['password']),
        ]);
    }
}
