<?php

namespace App\Services;

use App\Models\Fund;
use App\Repositories\FundRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FundService
{
    public function __construct(private readonly FundRepository $fundRepository) {}

    public function getFilteredFunds(?string $name = null, ?string $fundManager = null, ?int $year = null): Collection
    {
        return $this->fundRepository->getFunds($name, $fundManager, $year);
    }

    public function update(int $fundId, string $name, int $startYear, int $fundManagerId): Fund
    {
        $fund = $this->fundRepository->findById($fundId);

        if (!$fund) {
            throw new ModelNotFoundException("Fund with ID {$fundId} not found.");
        }

        return $this->fundRepository->update($fund, $name, $startYear, $fundManagerId);
    }
}
