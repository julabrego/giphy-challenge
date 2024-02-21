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
        $user = User::factory()->create([
            'name' => 'A test user',
            'email' => $this->validLoginData['email'],
            'password' => bcrypt($this->validLoginData['password']),
        ]);

        $this->login($this->validLoginData)->assertJson([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
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
}
