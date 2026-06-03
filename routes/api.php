<?php

use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);