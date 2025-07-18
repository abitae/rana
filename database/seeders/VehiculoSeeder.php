<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration\Vehiculo;

class VehiculoSeeder extends Seeder
{
    public function run(): void
    {
        Vehiculo::factory()->count(5)->create();
    }
}
