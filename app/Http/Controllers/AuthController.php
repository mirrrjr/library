<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginAuthRequest;
use App\Http\Requests\User\RegisterAuthRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    // 1. Login
    public function login(LoginAuthRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->login($request->validated());

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    // 2. Register
    public function register(RegisterAuthRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->register($request->validated());

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 3. Logout
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request);

            return response()->json([
                'message' => 'Successfully logged out'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
