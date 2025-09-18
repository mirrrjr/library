<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    public function __construct(
        private BookService $bookService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $books = $this->bookService->getAllBooksQuery($request->all());

        return response()->json([
            'data' => $books
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $book = $this->bookService->getBookById($id);

        return response()->json([
            'data' => $book
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        Gate::authorize('create', Book::class);

        $validated = $request->validated();

        $book = $this->bookService->createBook($validated);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        Gate::authorize('update', $book);

        $validated = $request->validated();

        $updatedBook = $this->bookService->updateBook($book, $validated);

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $updatedBook
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): JsonResponse
    {
        Gate::authorize('delete', $book);

        $this->bookService->deleteBook($book);

        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }
}
