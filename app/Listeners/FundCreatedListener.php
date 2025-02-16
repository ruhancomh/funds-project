<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarning;
use App\Events\FundCreated;
use App\Services\FundService;
use Illuminate\Support\Facades\Log;

class FundCreatedListener
{
    public function __construct(private readonly FundService $fundService){ }

    public function handle(FundCreated $event): void
    {
        $newFund = $event->fund;

        Log::info("New Fund Created", ['fund_id' => $newFund->id]);


        $existingFund = $this->fundService->getDuplicated($newFund);

        if ($existingFund) {
            event(new DuplicateFundWarning($newFund, $existingFund));
        }

    }
}
