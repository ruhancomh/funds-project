<?php

namespace App\Repositories;

use App\Models\Fund;
use Illuminate\Database\Eloquent\Collection;

class FundRepository
{
    public function getFunds(?string $name = null, ?string $fundManager = null, ?int $year = null): Collection
    {
        $query = Fund::query()->with(['fundManager.company', 'aliases']);

        if (!empty($name)) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        if (!empty($fundManager)) {
            $query->whereHas('fundManager.company', function ($q) use ($fundManager) {
                $q->where('name', 'LIKE', "%{$fundManager}%");
            });
        }

        if (!empty($year)) {
            $query->where('start_year', $year);
        }

        return $query->get();
    }

    public function findById(int $id): ?Fund
    {
        return Fund::with(['fundManager.company', 'aliases'])->find($id);
    }

    public function update(Fund $fund, string $name, int $startYear, int $fundManagerId): Fund
    {
        $fund->update([
            'name' => $name,
            'start_year' => $startYear,
            'fund_manager_id' => $fundManagerId,
        ]);

        return $fund->fresh();
    }
}
