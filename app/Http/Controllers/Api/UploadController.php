<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Upload;

class UploadController extends Controller
{
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:doc,docx'
        ]);
    
        $book = Book::findOrFail($id);
    
        if ($book->author_id !== auth()->id()) {
            abort(403);
        }
    
        $file = $request->file('file');
    
        $path = $file->store('uploads');
    
        $upload = Upload::create([
            'book_id' => $book->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'status' => 'uploaded',
        ]);
    
        return response()->json([
            'message' => 'File uploaded successfully',
            'data' => $upload
        ]);
    }
}
