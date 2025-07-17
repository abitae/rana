<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caja\Caja;
use App\Models\Caja\EntryCaja;
use App\Models\Caja\ExitCaja;

class CajaSeeder extends Seeder
{
    public function run(): void
    {
            Caja::factory(5)
                ->has(EntryCaja::factory()->count(3), 'entries')
                ->has(ExitCaja::factory()->count(2), 'exits')
                ->create();
    }
}
