<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FundManager;

class FundManagerSeeder extends Seeder
{
    public function run(): void
    {
        FundManager::insert([
            ['company_id' => 1],
            ['company_id' => 2],
            ['company_id' => 3],
            ['company_id' => 4],
            ['company_id' => 5],
        ]);
    }
}
