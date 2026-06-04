<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Chapter;

class ChapterService
{
    public function create(Book $book, array $data)
    {
        return $book->chapters()->create([
            'title' => $data['title'],
            'position' => $data['position'] ?? 1,
        ]);
    }

    public function update(Chapter $chapter, array $data)
    {
        $chapter->update([
            'title' => $data['title'] ?? $chapter->title,
            'position' => $data['position'] ?? $chapter->position,
        ]);

        return $chapter->fresh();
    }
}