<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CompanySeeder::class,
            FundManagerSeeder::class,
            FundSeeder::class,
            FundAliasSeeder::class,
        ]);
    }
}
