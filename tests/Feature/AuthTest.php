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

        $this->post(route('register'), [
            'name' => '',
            'email' => '',
            'password' => '',
        ])->assertStatus(302);

        $this->post(route('register'), [
            'name' => 'Test name',
            'email' => 'not.an.email',
            'password' => 'password1234',
        ])->assertStatus(302);

        $this->post(route('register'), [
            'name' => 'Test name',
            'email' => 'my@email.com',
            'password' => 'short',
        ])->assertStatus(302);
    }

    public function test_register_accepts_valid_data(): void
    {
        $this->post(route('register'), [
            'name' => 'Test name',
            'email' => 'my@email.com',
            'password' => 'password1234',
        ])->assertStatus(200);
    }

    public function test_register_should_create_and_return_a_user(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test name',
            'email' => 'my@email.com',
            'password' => 'password1234',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'name' => 'Test name',
                    'email' => 'my@email.com',
                ]
            ]);
    }

    public function test_register_should_reeturn_a_token(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test name',
            'email' => 'my@email.com',
            'password' => 'password1234',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'access_token' => true
            ]);
    }

    public function test_access_token_should_expire_in_30_minutes(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test name',
            'email' => 'my@email.com',
            'password' => 'password1234',
        ]);

        var_dump($response['access_token']);
        $response->assertStatus(200)
            ->assertJson(['expires_in' => 29]);
    }
}
