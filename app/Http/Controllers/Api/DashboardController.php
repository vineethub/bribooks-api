<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Enums\BookStatus;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $books = Book::where('author_id', $user->id);

        return response()->json([
            'total_books' => $books->count(),
            'draft_books' => (clone $books)
                ->where('status', BookStatus::DRAFT)
                ->count(),

            'published_books' => (clone $books)
                ->where('status', BookStatus::PUBLISHED)
                ->count(),

            'pending_reviews' => (clone $books)
                ->whereIn('status', [
                    BookStatus::SUBMITTED,
                    BookStatus::UNDER_REVIEW,
                ])
                ->count(),
        ]);
    }
}
