<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration\Transportista;

class TransportistaSeeder extends Seeder
{
    public function run(): void
    {
        Transportista::factory()->count(5)->create();
    }
}
