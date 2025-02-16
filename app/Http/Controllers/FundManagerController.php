<?php

namespace App\Http\Controllers;

use App\Models\FundManager;
use Illuminate\Http\JsonResponse;

class FundManagerController extends Controller
{
    public function index(): JsonResponse
    {
        $fundManagers = FundManager::with('company')->get();
        return response()->json($fundManagers);
    }
}
