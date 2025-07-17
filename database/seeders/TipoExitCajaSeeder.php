<?php

namespace Database\Seeders;

use App\Models\Configuration\TipoExitCaja;
use Illuminate\Database\Seeder;

class TipoExitCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoExitCaja::create([
            'name' => 'Gasto',
            'is_active' => true,
        ]);
        TipoExitCaja::create([
            'name' => 'Retiro',
            'is_active' => true,
        ]);
    }
}
