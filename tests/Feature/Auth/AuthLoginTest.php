<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{

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
        $this->login($this->validLoginData)->assertStatus(200);
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
