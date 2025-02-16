<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FundManager;
use App\Models\Company;

class FundManagerFactory extends Factory
{
    protected $model = FundManager::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
        ];
    }
}
