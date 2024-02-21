<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_register_route_exists(): void
    {
        $this->assertNotNull(route('register'));
    }

    public function test_register_rejects_invalid_data(): void
    {
        $this->post(route('register'))->assertStatus(302);

        foreach ($this->notValidRegisterData as $notValidData) {
            $this->post(route('register'), $notValidData)->assertStatus(302);
        }
    }

    public function test_register_accepts_valid_data(): void
    {
        $this->post(route('register'), $this->validRegisterData)->assertStatus(200);
    }

    public function test_register_should_create_and_return_a_user(): void
    {
        $response = $this->registerAValidUser();

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'name' => $this->validRegisterData['name'],
                    'email' => $this->validRegisterData['email'],
                ]
            ]);
    }

    public function test_register_should_reeturn_a_token(): void
    {
        $response = $this->registerAValidUser();

        $response->assertStatus(200)
            ->assertJson([
                'access_token' => true
            ]);
    }

    public function test_access_token_should_expire_in_30_minutes(): void
    {
        $response = $this->registerAValidUser();

        $response->assertStatus(200)
            ->assertJson(['expires_in' => 29]);
    }

    private $notValidRegisterData = [
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

    private function registerAValidUser()
    {
        return $this->post(route('register'), $this->validRegisterData);
    }
}
