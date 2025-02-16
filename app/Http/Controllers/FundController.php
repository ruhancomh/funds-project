<?php

namespace App\Http\Controllers;

use App\Http\Requests\FundFilterRequest;
use App\Http\Requests\UpdateFundRequest;
use App\Services\FundService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FundController extends Controller
{
    public function __construct(private readonly FundService $fundService){ }
    public function index(FundFilterRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $funds = $this->fundService->getFilteredFunds(
                name: data_get($validatedData, 'name'),
                fundManager: data_get($validatedData, 'fund_manager'),
                year: data_get($validatedData, 'year')
            );

            return response()->json(['data' => $funds], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving funds'], 500);
        }
    }

    public function update(UpdateFundRequest $request, int $id): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $updatedFund = $this->fundService->update(
                fundId: $id,
                name: data_get($validatedData, 'name'),
                startYear: data_get($validatedData, 'start_year'),
                fundManagerId: data_get($validatedData, 'fund_manager_id')
            );

            return response()->json(['message' => 'Fund updated successfully', 'data' => $updatedFund], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the fund'], 500);
        }
    }
}
