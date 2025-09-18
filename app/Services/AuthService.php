<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    // 1. Login
    public function login(array $data): User
    {
        if (!Auth::attempt($data)) {
            throw new \Exception('Invalid credentials');
        }

        return Auth::user();
    }

    // 2. Register
    public function register(array $data): User
    {
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        // Role biriktirish
        $role = $data['role'] ?? 'user';
        $user->assignRole($role);

        return $user;
    }

    // 3. Logout
    public function logout($request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
