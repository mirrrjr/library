<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    // 1. Barcha foydalanuvchilar
    public function getAllUsers(): Collection
    {
        return User::with('roles')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name')->unique(),
            ];
        });
    }

    // 2. Bitta foydalanuvchi
    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }

    // 3. Foydalanuvchini yangilash
    public function updateUser(User $user, array $data): User
    {
        $user->update($data);

        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return $user;
    }

    // 4. Foydalanuvchi kitoblari
    public function getUserBooks(int $id): ?Collection
    {
        $user = $this->getUserById($id);

        if (!$user) {
            return null;
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
}
