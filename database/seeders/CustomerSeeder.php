<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::factory()->count(300)->create();
    }
}
