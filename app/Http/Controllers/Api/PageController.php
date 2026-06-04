<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PageService;
use App\Models\Chapter;
use App\Models\Page;
class PageController extends Controller
{

    protected PageService $pageService;
    public function __construct(PageService $pageService)
       {
              $this->pageService = $pageService;
       }
       
    public function store(Request $request, $chapterId)
        {
            $chapter = Chapter::findOrFail($chapterId);

            if ($chapter->book->author_id !== auth()->id()) {
                abort(403);
            }

            $request->validate([
                'page_number' => 'required|integer',
                'content' => 'required|string'
            ]);

            $page = $this->pageService->create(
                $chapter,
                $request->all()
            );

            return response()->json([
                'message' => 'Page created successfully',
                'data' => $page
            ], 201);
        }

        public function index($chapterId)
        {
            $chapter = Chapter::findOrFail($chapterId);

            if ($chapter->book->author_id !== auth()->id()) {
                abort(403);
            }

            return response()->json([
                'data' => $chapter->pages()
                    ->orderBy('page_number')
                    ->get()
            ]);
        }

        public function update(Request $request, $id)
        {
            $page = Page::findOrFail($id);

            if ($page->chapter->book->author_id !== auth()->id()) {
                abort(403);
            }

            $page = $this->pageService->update(
                $page,
                $request->all()
            );

            return response()->json([
                'message' => 'Page updated successfully',
                'data' => $page
            ]);
        }

        public function destroy($id)
        {
            $page = Page::findOrFail($id);

            if ($page->chapter->book->author_id !== auth()->id()) {
                abort(403);
            }

            $page->delete();

            return response()->json([
                'message' => 'Page deleted successfully'
            ]);
        }
}
