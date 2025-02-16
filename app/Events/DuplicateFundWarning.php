<?php

namespace App\Events;

use App\Models\Fund;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DuplicateFundWarning
{
    use Dispatchable, SerializesModels;

    public Fund $newFund;
    public Fund $existingFund;

    public function __construct(Fund $newFund, Fund $existingFund)
    {
        $this->newFund = $newFund;
        $this->existingFund = $existingFund;
    }
}
