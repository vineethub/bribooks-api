<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ChapterService;
use App\Models\Book;
use App\Models\Chapter;

class ChapterController extends Controller
{
    protected ChapterService $chapterService;
  public function __construct(ChapterService $chapterService)
     {
            $this->chapterService = $chapterService;
     }

     public function store(Request $request, $bookId)
     {
         $book = Book::findOrFail($bookId);
     
         if ($book->author_id !== auth()->id()) {
             abort(403);
         }
     
         $request->validate([
             'title' => 'required|string|max:255',
             'position' => 'nullable|integer'
         ]);
     
         $chapter = $this->chapterService->create(
             $book,
             $request->all()
         );
     
         return response()->json([
             'message' => 'Chapter created successfully',
             'data' => $chapter
         ], 201);
     }

     public function index($bookId)
        {
            $book = Book::where('author_id', auth()->id())
                ->findOrFail($bookId);

            return response()->json([
                'data' => $book->chapters()->orderBy('position')->get()
            ]);
        }

        
     public function update(Request $request, $id)
        {
            $chapter = Chapter::findOrFail($id);

            if ($chapter->book->author_id !== auth()->id()) {
                abort(403);
            }

            $chapter = $this->chapterService->update(
                $chapter,
                $request->all()
            );

            return response()->json([
                'message' => 'Chapter updated successfully',
                'data' => $chapter
            ]);
        }

    public function destroy($id)
        {
            $chapter = Chapter::findOrFail($id);

            if ($chapter->book->author_id !== auth()->id()) {
                abort(403);
            }

            $chapter->delete();

            return response()->json([
                'message' => 'Chapter deleted successfully'
            ]);
        }
}
