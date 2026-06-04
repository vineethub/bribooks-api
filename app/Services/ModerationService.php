<?php

namespace App\Services;

use App\Models\Book;

class ModerationService
{
    public function check(Book $book): array
    {
        $content = strtolower(
            $book->title . ' ' . ($book->description ?? '')
        );

        $restrictedWords = config('restricted_words');

        $foundWords = [];

        foreach ($restrictedWords as $word) {
            if (str_contains($content, strtolower($word))) {
                $foundWords[] = $word;
            }
        }

        return [
            'passed' => empty($foundWords),
            'words' => $foundWords,
        ];
    }
}