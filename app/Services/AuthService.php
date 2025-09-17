<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $data): User
    {
        if (!Auth::attempt($data)) {
            throw new \Exception('Invalid credentials');
        }

        /** @var User $user */
        $user = Auth::user();

        return $user;
    }

    public function register(array $data): User
    {
        // dd($data);
        try {
            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

            // Assign role to user
            if (isset($data['role'])) {
                $user->assignRole($data['role']);
            } else {
                $user->assignRole('user');
            }

            // Assign permissions to user based on role
            // if (isset($data['permissions']) && is_array($data['permissions'])) {
            //     $user->syncPermissions($data['permissions']);
            // }

            return $user;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create user: ' . $e->getMessage());
        }
    }

    public function logout($request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
