<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Rental;
use App\Models\User;

class ReportService
{
    // 1. Eng ko‘p o‘qilgan kitoblar (rental soni bo‘yicha TOP 5)
    public function mostReadBooks(int $limit = 5)
    {
        return Book::withCount('rentals')
            ->having('rentals_count', '>', 0)
            ->orderByDesc('rentals_count')
            ->take($limit)
            ->get();
    }

    // 2. Har bir muallifning kitoblari statistikasi
    public function authorStatistics()
    {
        return User::role(['author', 'admin'])
            ->withCount('books')
            ->get(['id', 'name']);
    }

    // 3. Joriy holatda nechta kitob ijarada
    public function currentRentedCount()
    {
        return Rental::whereNull('returned_at')->count();
    }
}
