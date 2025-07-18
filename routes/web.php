<?php

use App\Livewire\Caja\CajaLive;
use App\Livewire\Configuration\CompanyLive;
use App\Livewire\Configuration\SucursalLive;
use App\Livewire\Configuration\TipoCajaLive;
use App\Livewire\Configuration\TransportistaLive;
use App\Livewire\Configuration\VehiculoLive;
use App\Livewire\Package\CustomerLive;
use App\Livewire\Package\EncomiendaCreateLive;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('caja', CajaLive::class)->name('caja');
    Route::get('configuration/tipo-caja', TipoCajaLive::class)->name('configuration.tipo-caja');
    Route::get('configuration/sucursal', SucursalLive::class)->name('configuration.sucursal');
    Route::get('configuration/company', CompanyLive::class)->name('configuration.company');
    Route::get('configuration/transportista', TransportistaLive::class)->name('configuration.transportista');
    Route::get('configuration/vehiculo', VehiculoLive::class)->name('configuration.vehiculo');
    Route::get('configuration/customer', CustomerLive::class)->name('configuration.customer');
    Route::get('package/encomienda', EncomiendaCreateLive::class)->name('package.encomienda');
});

require __DIR__.'/auth.php';
