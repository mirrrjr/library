<?php

namespace App\Http\Controllers;

use App\Services\RentalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function __construct(
        private RentalService $rentalService
    ) {}

    // 1. Kitobni ijaraga berish
    public function rentBook(Request $request, int $bookId): JsonResponse
    {
        $validated = $request->validate([
            'rented_at' => 'date|nullable',
            'due_at' => 'date|nullable',
        ]);

        try {
            $rental = $this->rentalService->rentBook($bookId, $validated);
            return response()->json(['data' => $rental], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 2. Kitobni qaytarish
    public function returnBook(int $rentalId): JsonResponse
    {
        try {
            $rental = $this->rentalService->returnBook($rentalId);
            return response()->json(['data' => $rental], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 3. Joriy ijaralar
    public function activeRentals(): JsonResponse
    {
        $rents = $this->rentalService->getActiveRentals();
        return response()->json(['data' => $rents], 200);
    }

    // 4. Muddati o‘tgan ijaralar
    public function overdueRentals(): JsonResponse
    {
        $expireds = $this->rentalService->getOverdueRentals();
        return response()->json(['data' => $expireds], 200);
    }
}
