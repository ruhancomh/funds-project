<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use Illuminate\Http\JsonResponse;

class FundController extends Controller
{
    public function index(): JsonResponse
    {
        $funds = Fund::with(['fundManager', 'aliases'])->get();
        return response()->json($funds);
    }
}
