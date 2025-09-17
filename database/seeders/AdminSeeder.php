<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ])->assignRole('admin');

        // User::create([
        //     'name' => 'author',
        //     'email' => 'author@mail.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('password'),
        // ])->assignRole('author');

        // User::create([
        //     'name' => 'user',
        //     'email' => 'user@mail.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('password'),
        // ])->assignRole('user');
    }
}
