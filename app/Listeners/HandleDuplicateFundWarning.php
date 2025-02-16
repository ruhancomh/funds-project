<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarning;
use Illuminate\Support\Facades\Log;

class HandleDuplicateFundWarning
{
    public function handle(DuplicateFundWarning $event): void
    {
        Log::warning("Duplicate Fund Detected", [
            'new_fund_id' => $event->newFund->id,
            'existing_fund_id' => $event->existingFund->id
        ]);
    }
}
