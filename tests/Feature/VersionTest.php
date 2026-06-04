<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VersionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_version_snapshot()
    {
        $user = User::factory()->create();

        $book = Book::factory()->create([
            'author_id' => $user->id
        ]);

        $token = auth('api')->login($user);

        $response = $this->withHeader(
            'Authorization',
            "Bearer {$token}"
        )->postJson("/api/books/{$book->id}/versions");

        $response->assertStatus(200);
    }
}