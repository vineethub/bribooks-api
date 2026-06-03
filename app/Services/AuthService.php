<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'author'
        ]);
    }

    public function login(array $data)
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        if (!$token = auth('api')->attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ])) {
            return null;
        }
    
        return [
            'user' => auth('api')->user(),
            'token' => $token
        ];
    }
}