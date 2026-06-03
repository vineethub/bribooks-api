<?php

namespace App\Services;

use App\Models\Book;
use App\Enums\BookStatus;
use App\Services\BookVersionService;

use App\Events\BookCreated;
use App\Events\BookVersionCreated;
use App\Events\BookSubmitted;
use App\Events\BookApproved;
use App\Events\BookPublished;
class BookService
{

    protected $versionService;
    public function __construct(BookVersionService $versionService)
    {
        $this->versionService = $versionService;
    }
    public function create(array $data, $user)
    {
        $book = Book::create([
            'author_id' => $user->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => 'draft'
        ]);

        event(new BookCreated($book));

       return $book;
    }

    public function update(Book $book, array $data, $user)
    {
        app(BookVersionService::class)
            ->createSnapshot($book, $user);

        event(new BookVersionCreated($book));

        $book->update([
            'title' => $data['title'] ?? $book->title,
            'description' => $data['description'] ?? $book->description,
        ]);

        return $book;
    }

    public function submit(Book $book, $user)
    {
        if ($book->author_id !== $user->id) {
            abort(403);
        }

        if ($book->status !== BookStatus::DRAFT) {
            throw new \Exception("Only draft books can be submitted");
        }

        $book->update([
            'status' => BookStatus::SUBMITTED
        ]);

        event(new BookSubmitted($book));

        return $book;
    }

    public function approve(Book $book, $user)
    {
        if ($user->role !== 'admin' && $user->role !== 'reviewer') {
            abort(403);
        }

        if ($book->status !== BookStatus::UNDER_REVIEW) {
            throw new \Exception("Only under review books can be approved");
        }

        $book->update([
            'status' => BookStatus::APPROVED
        ]);

        event(new BookApproved($book));

        return $book;
    }

    public function publish(Book $book, $user)
    {
        if ($user->role !== 'admin') {
            abort(403);
        }

        if ($book->status !== BookStatus::APPROVED) {
            throw new \Exception("Only approved books can be published");
        }

        $book->update([
            'status' => BookStatus::PUBLISHED
        ]);

        event(new BookPublished($book));

        return $book;
    }

    public function reject(Book $book, $user, $reason = null)
    {
        if ($user->role !== 'admin' && $user->role !== 'reviewer') {
            abort(403);
        }

        $book->update([
            'status' => BookStatus::REJECTED
        ]);

        return $book;
    }
}