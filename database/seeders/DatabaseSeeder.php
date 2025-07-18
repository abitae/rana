<?php

namespace Database\Seeders;


use App\Models\Configuration\Sucursal;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Sucursal::factory(5)->create();
        $this->call([
            SqlFileSeeder::class,
            SucursalSeeder::class,
            TipoEntryCajaSeeder::class,
            TipoExitCajaSeeder::class,
            CompanySeeder::class,
            TransportistaSeeder::class,
            VehiculoSeeder::class,
            CustomerSeeder::class,
        ]);
        User::factory()->create([
            'name' => 'Abel Arana Cortez',
            'email' => 'abel.arana@hotmail.com',
            'sucursal_id' => Sucursal::first()->id,
            'isActive' => true,
            'password' => Hash::make('lobomalo123'),
        ]);
        $this->call([
            CajaSeeder::class,
        ]);
    }
}
