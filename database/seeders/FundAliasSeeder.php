<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FundAlias;

class FundAliasSeeder extends Seeder
{
    public function run(): void
    {
        FundAlias::insert([
            ['alias' => 'Tech Fund', 'fund_id' => 1],
            ['alias' => 'AI Investment Fund', 'fund_id' => 4],
            ['alias' => 'Green Future Fund', 'fund_id' => 3],
            ['alias' => 'Healthcare Investors', 'fund_id' => 2],
            ['alias' => 'Real Estate Trust', 'fund_id' => 5],
        ]);
    }
}
