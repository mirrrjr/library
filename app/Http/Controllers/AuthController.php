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
        protected AuthService $authService
    ) {}

    public function login(LoginAuthRequest $request): JsonResponse
    {
        $user = $this->authService->login($request->validated());

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'token' => $token,
        ]);
    }

    public function register(RegisterAuthRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'token' => $token,
        ], 201);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
