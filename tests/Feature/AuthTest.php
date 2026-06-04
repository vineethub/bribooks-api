<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Vineet',
            'email' => 'vineet@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(201);
    }

    public function test_user_can_login()
    {
        $this->postJson('/api/register', [
            'name' => 'Vineet',
            'email' => 'vineet@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'vineet@test.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }
}