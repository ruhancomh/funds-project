<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFundRequest;
use App\Http\Requests\FundFilterRequest;
use App\Http\Requests\UpdateFundRequest;
use App\Services\FundService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

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
        } catch (Throwable $e) {
            Log::error("Fund list failed", ['exception' => $e->getMessage()]);
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
        } catch (Throwable $e) {
            Log::error("Fund update failed", ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while updating the fund'], 500);
        }
    }

    public function store(CreateFundRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $fund = $this->fundService->create(
                name: data_get($validatedData, 'name'),
                startYear: data_get($validatedData, 'start_year'),
                fundManagerId: data_get($validatedData, 'fund_manager_id'),
                aliases: data_get($validatedData, 'aliases'),
            );

            return response()->json(['message' => 'Fund created successfully', 'data' => $fund], 201);
        } catch (Throwable $e) {
            Log::error("Fund creation failed", ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while creating the fund'], 500);
        }
    }
}
