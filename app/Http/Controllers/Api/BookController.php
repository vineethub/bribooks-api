<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Models\Book;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $book = $this->bookService->create(
            $request->all(),
            auth()->user()
        );

        return response()->json([
            'message' => 'Book created successfully',
            'book' => $book
        ]);
    }
    
    public function index()
    {
        $books = Book::with('author')
            ->where('author_id', auth()->id())
            ->latest()
            ->get();

        return response()->json($books);
    }

    public function show($id)
    {
        $book = Book::with('author')
            ->where('author_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$book) {
            return response()->json([
                'message' => 'Book not found or access denied'
            ], 404);
        }

        return response()->json([
            'data' => $book
        ]);
    }

    public function update(Request $request, $id)
    {
        $book = Book::where('author_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$book) {
            return response()->json([
                'message' => 'Book not found or access denied'
            ], 404);
        }

        $book = $this->bookService->update($book, $request->all());

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book
        ]);
    }

    public function destroy($id)
    {
        $book = Book::where('author_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$book) {
            return response()->json([
                'message' => 'Book not found or access denied'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }
}
