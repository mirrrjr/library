<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $admin->givePermissionTo([
            'create.book',
            'edit.book',
            'delete.book',
            'view.book',
            'create.author',
            'edit.author',
            'delete.author',
            'view.author',
        ]);

        $author = Role::create(['name' => 'author', 'guard_name' => 'api']);
        $author->givePermissionTo([
            'create.book',
            'edit.book',
            'view.book',
            'view.author',
        ]);

        $user = Role::create(['name' => 'user', 'guard_name' => 'api']);
        $user->givePermissionTo([
            'view.book',
            'view.author',
        ]);
    }
}
