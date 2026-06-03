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

    public function update(Book $book, array $data)
    {
        $book->update([
            'title' => $data['title'] ?? $book->title,
            'description' => $data['description'] ?? $book->description,
        ]);

        return $book;
    }
}