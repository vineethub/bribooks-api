<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function create(array $data, $user)
    {
        return Book::create([
            'author_id' => $user->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => 'draft'
        ]);
    }
}