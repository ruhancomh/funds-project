<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $companies = Company::all();
            return response()->json($companies);
        } catch (Throwable $e) {
            Log::error("Company list failed", ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while retrieving companies'], 500);
        }
    }
}
