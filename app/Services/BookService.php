<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookService
{
    // 1. Barcha kitoblarni olish (filtrlash bilan)
    public function getAllBooksQuery(array $data): LengthAwarePaginator
    {
        return Book::query()
            ->when(!empty($data['title']), fn($q) =>
                $q->where('books.title', 'like', '%' . $data['title'] . '%'))
            ->when(!empty($data['author']), fn($q) =>
                $q->whereHas('user', fn($query) =>
                    $query->where('name', 'like', '%' . $data['author'] . '%')))
            ->where('status', 'available')
            ->with('user')
            ->paginate(20);
    }

    // 2. Bitta kitobni olish
    public function getBookById(int $id): ?Book
    {
        return Book::with('user')->find($id);
    }

    // 3. Kitob qo‘shish
    public function createBook(array $data): Book
    {
        return Book::create($data);
    }

    // 4. Kitobni yangilash
    public function updateBook(Book $book, array $data): Book
    {
        $book->update($data);
        return $book;
    }

    // 5. Kitobni o‘chirish
    public function deleteBook(Book $book): void
    {
        $book->delete();
    }
}
