<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    public function __construct(
        private BookService $bookService
    ) {}

    // 1. Barcha kitoblarni ko‘rish (filtrlash bilan)
    public function index(Request $request): JsonResponse
    {
        try {
            $books = $this->bookService->getAllBooksQuery($request->all());

            return response()->json(['data' => $books], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 2. Bitta kitobni ko‘rish
    public function show(int $id): JsonResponse
    {
        try {
            $book = $this->bookService->getBookById($id);

            if (!$book) {
                return response()->json(['error' => 'Book not found'], 404);
            }

            return response()->json(['data' => $book], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 3. Yangi kitob qo‘shish
    public function store(StoreBookRequest $request): JsonResponse
    {
        Gate::authorize('create', Book::class);

        try {
            $book = $this->bookService->createBook($request->validated());

            return response()->json([
                'message' => 'Book created successfully',
                'data' => $book
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 4. Kitobni tahrirlash
    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        Gate::authorize('update', $book);

        try {
            $updatedBook = $this->bookService->updateBook($book, $request->validated());

            return response()->json([
                'message' => 'Book updated successfully',
                'data' => $updatedBook
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 5. Kitobni o‘chirish
    public function destroy(Book $book): JsonResponse
    {
        Gate::authorize('delete', $book);

        try {
            $this->bookService->deleteBook($book);

            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
