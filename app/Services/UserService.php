<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Collection;

class UserService
{
    public function getAllUsers(): Collection
    {
        $users = User::with('roles')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name')->unique(),
            ];
        });

        return $users;
    }

    public function updateUser(int $id, array $data)
    {
        Gate::authorize('update', $this->getUserById($id));

        $user = $this->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($data);

        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }
        return $user;
    }

    public function getUserBooks(int $id)
    {
        $user = $this->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return $user->books()->with('user')->get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->user->name,
                'published_at' => $book->published_at,
            ];
        });
    }

    public function getUserById(int $id): ?User
    {
        $user = User::find($id);

        return $user;
    }
}
