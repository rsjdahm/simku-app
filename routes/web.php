<?php

use App\Http\Controllers\Admin\MigrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/jam', function () {
    return Carbon\Carbon::now()->isoFormat('HH:mm:ss');
})->name('jam');

require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/menu-modul/{modul?}', function ($modul = 'setup') {
        return view('menus.' . $modul);
    })->name('menu-modul');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/ringkasan', [DashboardController::class, 'show'])->name('dashboard.show');


    require __DIR__ . '/modules/admin.php';
    require __DIR__ . '/modules/setup.php';
    require __DIR__ . '/modules/anggaran.php';
    require __DIR__ . '/modules/penatausahaan.php';
});
