<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Models\Book;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\BookVersion;

class BookController extends Controller
{
    use AuthorizesRequests;
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
    
        return response()->json([
            'data' => $books
        ]);
    }

    public function show(Book $book)
    {
        $this->authorize('view', $book);

        return response()->json([
            'data' => $book->load('author')
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $book = $this->bookService->update($book, $request->all(),auth()->user());

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book
        ]);
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }

    public function submit(Book $book)
    {
        $book = $this->bookService->submit($book, auth()->user());

        return response()->json($book);
    }

    public function approve(Book $book)
    {
        $book = $this->bookService->approve($book, auth()->user());

        return response()->json($book);
    }

    public function publish(Book $book)
    {
        $book = $this->bookService->publish($book, auth()->user());

        return response()->json($book);
    }

    public function reject(Book $book)
    {
        $book = $this->bookService->reject($book, auth()->user());

        return response()->json($book);
    }

    public function versions(Book $book)
    {
        $this->authorize('view', $book);

        $versions = BookVersion::with('creator')
            ->where('book_id', $book->id)
            ->orderBy('version_number', 'desc')
            ->get();

        return response()->json([
            'book_id' => $book->id,
            'total_versions' => $versions->count(),
            'data' => $versions
        ]);
    }

    public function showVersion(Book $book, $versionId)
    {
        $this->authorize('view', $book);

        $version = BookVersion::where('book_id', $book->id)
            ->where('id', $versionId)
            ->firstOrFail();

        return response()->json([
            'data' => $version
        ]);
    }
}
