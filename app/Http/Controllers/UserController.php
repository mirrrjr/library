<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    // 1. Barcha foydalanuvchilar
    public function index(): JsonResponse
    {
        try {
            $users = $this->userService->getAllUsers();
            return response()->json(['data' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 2. Bitta foydalanuvchi
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUserById($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            return response()->json([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'roles' => $user->getRoleNames(),
                    'permissions' => $user->getAllPermissions()->pluck('name')->unique(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 3. Foydalanuvchini yangilash
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'role' => 'sometimes|string|exists:roles,name',
        ]);

        try {
            $user = $this->userService->getUserById($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            Gate::authorize('update', $user);

            $updatedUser = $this->userService->updateUser($user, $validated);

            return response()->json([
                'message' => 'User updated successfully',
                'data' => $updatedUser,
                'roles' => $updatedUser->getRoleNames(),
                'permissions' => $updatedUser->getAllPermissions()->pluck('name')->unique(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 4. Foydalanuvchining kitoblari
    public function books(int $id): JsonResponse
    {
        try {
            $books = $this->userService->getUserBooks($id);

            if ($books === null) {
                return response()->json(['message' => 'User not found'], 404);
            }

            return response()->json(['data' => $books], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
