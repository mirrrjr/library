<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class RentalService
{
    // 1. Kitobni ijaraga berish
    public function rentBook(int $bookId, array $data)
    {
        $user = Auth::user();
        $book = Book::find($bookId);

        if (!$book) {
            throw new \Exception('Book not found');
        }

        if ($book->status !== 'available') {
            throw new \Exception('Book is not available for rent');
        }

        $rental = Rental::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'rented_at' => now(),
            'due_at' => now()->addDays(14),  // 2 hafta
        ]);

        $book->update(['status' => 'rented']);

        return $rental->load('book');
    }

    // 2. Kitobni qaytarish
    public function returnBook(int $rentalId)
    {
        $rental = Rental::find($rentalId);

        if (!$rental) {
            throw new \Exception('Rental not found');
        }

        if ($rental->returned_at) {
            throw new \Exception('Book already returned');
        }

        $rental->update(['returned_at' => now()]);
        $rental->book->update(['status' => 'available']);

        return $rental->load('book');
    }

    // 3. Joriy ijaralar
    public function getActiveRentals()
    {
        $user = Auth::user();

        return Rental::query()
            ->where('user_id', $user->id)
            ->whereNull('returned_at')
            ->with('book')
            ->orderByDesc('rented_at')
            ->paginate(15);
    }

    // 4. Muddati o‘tgan ijaralar
    public function getOverdueRentals()
    {
        return Rental::query()
            ->where('due_at', '<', now())
            ->whereNull('returned_at')
            ->with('book', 'user')
            ->orderBy('due_at')
            ->paginate(15);
    }
}
