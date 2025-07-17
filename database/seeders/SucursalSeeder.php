<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration\Sucursal;

class SucursalSeeder extends Seeder
{
    public function run(): void
    {
        Sucursal::factory()->count(5)->create();
    }
}
