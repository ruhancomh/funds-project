<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::insert([
            ['name' => 'Wealth Management Ltd'],
            ['name' => 'Capital Growth Partners'],
            ['name' => 'Future Investments'],
            ['name' => 'Secure Wealth Advisors'],
            ['name' => 'Pioneer Capital'],
        ]);
    }
}
