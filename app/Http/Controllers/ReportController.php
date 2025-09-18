<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    // 1. Eng ko‘p o‘qilgan kitoblar
    public function mostReadBooks(): JsonResponse
    {
        return response()->json([
            'data' => $this->reportService->mostReadBooks()
        ]);
    }

    // 2. Har bir muallifning kitoblari statistikasi
    public function authorStatistics(): JsonResponse
    {
        return response()->json([
            'data' => $this->reportService->authorStatistics()
        ]);
    }

    // 3. Joriy ijaradagi kitoblar soni
    public function currentRentedCount(): JsonResponse
    {
        return response()->json([
            'count' => $this->reportService->currentRentedCount()
        ]);
    }
}
