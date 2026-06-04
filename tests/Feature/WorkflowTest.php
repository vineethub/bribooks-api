<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_submit_book()
    {
        $user = User::factory()->create();

        $book = Book::factory()->create([
            'author_id' => $user->id
        ]);

        $token = auth('api')->login($user);

        $response = $this->withHeader(
            'Authorization',
            "Bearer {$token}"
        )->postJson("/api/books/{$book->id}/submit");

        $response->assertStatus(200);
    }
}