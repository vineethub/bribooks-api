<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Upload;
use App\Enums\BookStatus;

use PhpOffice\PhpWord\IOFactory;
use App\Models\Chapter;
use App\Models\Page;

class UploadController extends Controller
{
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:doc,docx',
        ]);

        $book = Book::findOrFail($id);

        // Author can upload only to their own books
        if ($book->author_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized access to this book'
            ], 403);
        }

        // Published books are read-only
        if ($book->status === BookStatus::PUBLISHED) {
            return response()->json([
                'message' => 'Published books are read-only'
            ], 422);
        }

        // Store uploaded file
        $file = $request->file('file');
        $path = $file->store('uploads');

        // Save upload record
        $upload = Upload::create([
            'book_id'   => $book->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'status'    => 'uploaded',
        ]);

        try {

            $phpWord = IOFactory::load(
                storage_path('app/private/' . $path)
            );

            $content = '';

            foreach ($phpWord->getSections() as $section) {

                foreach ($section->getElements() as $element) {

                    // Plain text element
                    if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                        $content .= $element->getText() . "\n";
                    }

                    // TextRun element
                    if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {

                        foreach ($element->getElements() as $textElement) {

                            if (method_exists($textElement, 'getText')) {
                                $content .= $textElement->getText() . ' ';
                            }
                        }

                        $content .= "\n";
                    }
                }
            }

            $content = trim($content);

            if (empty($content)) {

                return response()->json([
                    'message' => 'No readable content found in document'
                ], 422);
            }

            // Create chapter
            $chapter = Chapter::create([
                'book_id'  => $book->id,
                'title'    => 'Imported Manuscript',
                'position' => 1,
            ]);

            // Split into pages
            $chunks = str_split($content, 1000);

            foreach ($chunks as $index => $chunk) {

                Page::create([
                    'chapter_id' => $chapter->id,
                    'page_number' => $index + 1,
                    'content' => '<p>' . nl2br(e($chunk)) . '</p>',
                ]);
            }

            // Mark upload as processed
            $upload->update([
                'status' => 'processed'
            ]);

            return response()->json([
                'message' => 'Document uploaded and converted successfully',
                'chapter_id' => $chapter->id,
                'pages_created' => count($chunks),
            ]);

        } catch (\Exception $e) {

            $upload->update([
                'status' => 'failed'
            ]);

            return response()->json([
                'message' => 'Failed to process document',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
