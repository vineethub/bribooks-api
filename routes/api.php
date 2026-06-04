<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UploadController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::prefix('books')->controller(BookController::class)->group(function () {
        Route::post('/', 'store');
        Route::get('/', 'index');
        Route::get('/{book}', 'show');
        Route::put('/{book}', 'update');
        Route::delete('/{book}', 'destroy');
        Route::post('/{book}/submit', 'submit');
        Route::post('/{book}/approve', 'approve');
        Route::post('/{book}/publish', 'publish');
        Route::post('/{book}/reject', 'reject');
        Route::get('/{book}/versions', 'versions');
        Route::get('/{book}/versions/{version}','showVersion');
        Route::post('{id}/chapters', [ChapterController::class, 'store']);
        Route::get('{id}/chapters', [ChapterController::class, 'index']);
    });

    
        Route::put('/chapters/{id}', [ChapterController::class, 'update']);
        Route::delete('/chapters/{id}', [ChapterController::class, 'destroy']);

        Route::post('/chapters/{id}/pages', [PageController::class, 'store']);
        Route::get('/chapters/{id}/pages', [PageController::class, 'index']);

        Route::put('/pages/{id}', [PageController::class, 'update']);
        Route::delete('/pages/{id}', [PageController::class, 'destroy']);

        // dashboard API
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // upload API
        Route::post('/books/{id}/upload',[UploadController::class, 'upload']
        );

});
