<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fund;

class FundSeeder extends Seeder
{
    public function run(): void
    {
        Fund::insert([
            ['name' => 'Tech Growth Fund', 'start_year' => 2020, 'fund_manager_id' => 1],
            ['name' => 'Healthcare Innovation Fund', 'start_year' => 2018, 'fund_manager_id' => 2],
            ['name' => 'Green Energy Fund', 'start_year' => 2021, 'fund_manager_id' => 3],
            ['name' => 'AI Revolution Fund', 'start_year' => 2019, 'fund_manager_id' => 4],
            ['name' => 'Real Estate Equity Fund', 'start_year' => 2017, 'fund_manager_id' => 5],
        ]);
    }
}
