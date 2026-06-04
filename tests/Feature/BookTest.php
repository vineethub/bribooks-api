<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_create_book()
    {
        $user = User::factory()->create();

        $token = auth('api')->login($user);

        $response = $this->withHeader(
            'Authorization',
            "Bearer {$token}"
        )->postJson('/api/books', [
            'title' => 'My First Book',
            'description' => 'Test Description'
        ]);

        $response->assertStatus(200);
    }
}