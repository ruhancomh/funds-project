<?php

namespace App\Events;

use App\Models\Fund;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FundCreated
{
    use Dispatchable, SerializesModels;

    public Fund $fund;

    public function __construct(Fund $fund)
    {
        $this->fund = $fund;
    }
}
