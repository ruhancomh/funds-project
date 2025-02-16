<?php

namespace App\Repositories;

use App\Models\Fund;
use App\Models\FundAlias;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function createFund(string $name, int $startYear, int $fundManagerId, ?array $aliases = []): Fund
    {
        return DB::transaction(function () use ($name, $startYear, $fundManagerId, $aliases) {
            $fund = Fund::create([
                'name' => $name,
                'start_year' => $startYear,
                'fund_manager_id' => $fundManagerId,
            ]);

            if (!empty($aliases)) {
                $this->createAliases($fund, $aliases);
            }

            return $fund->fresh(['fundManager.company', 'aliases']);
        });
    }

    private function createAliases(Fund $fund, array $aliases): void
    {
        foreach ($aliases as $alias) {
            FundAlias::create([
                'fund_id' => $fund->id,
                'alias' => $alias,
            ]);
        }
    }

    public function getDuplicated (Fund $fund): ?Fund {
        return Fund::where('fund_manager_id', $fund->fund_manager_id)
            ->where(function ($query) use ($fund) {
                $query->where('name', $fund->name)
                    ->orWhereHas('aliases', function ($aliasQuery) use ($fund) {
                        $aliasQuery->where('alias', $fund->name);
                    });
            })
            ->where('id', '!=', $fund->id)
            ->first();
    }
}
