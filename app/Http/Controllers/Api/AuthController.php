<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $user = $this->authService->register($request->all());

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ]);
    }
    
    public function login(Request $request)
    {
        $data = $request->only('email', 'password');

        $result = $this->authService->login($data);

        if (!$result) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'user' => $result['user'],
            'token' => $result['token']
        ]);
    }

    public function profile()
    {
        return response()->json([
            'user' => auth()->user()
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
