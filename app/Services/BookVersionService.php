<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookVersion;

class BookVersionService
{
    public function createSnapshot(Book $book, $user)
    {
        $lastVersion = BookVersion::where('book_id', $book->id)
            ->max('version_number');

        return BookVersion::create([
            'book_id' => $book->id,
            'version_number' => $lastVersion + 1,
            'snapshot_json' => json_encode([
                'book' => $book->toArray(),
                'created_at' => now()
            ]),
            'created_by' => $user->id
        ]);
    }
}