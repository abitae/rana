<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::factory()->count(1)->create();
    }
}
