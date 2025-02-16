<?php

namespace App\Http\Controllers;

use App\Models\FundManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class FundManagerController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $fundManagers = FundManager::with('company')->get();
            return response()->json($fundManagers);
        } catch (Throwable $e) {
            Log::error("FundManagers list failed", ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while retrieving fund managers'], 500);
        }
    }
}
