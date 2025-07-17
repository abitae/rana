<?php

namespace Database\Seeders;

use App\Models\Configuration\TipoEntryCaja;
use Illuminate\Database\Seeder;

class TipoEntryCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoEntryCaja::create([
            'name' => 'Venta',
            'is_active' => true,
        ]);
        TipoEntryCaja::create([
            'name' => 'Abono',
            'is_active' => true,
        ]);
    }
}
    