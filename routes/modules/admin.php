<?php

use App\Http\Controllers\Admin\MigrationController;
use Illuminate\Support\Facades\Route;

// ADMIN
Route::prefix('/admin')->group(function () {
    Route::get('/migration', [MigrationController::class, 'index'])->name('migration.index');
    Route::post('/migration/{migration}', [MigrationController::class, 'store'])->name('migration.store');
    Route::get('/migration/{migration}/edit', [MigrationController::class, 'edit'])->name('migration.edit');
    Route::put('/migration/{migration}', [MigrationController::class, 'update'])->name('migration.update');
    Route::delete('/migration/{migration}', [MigrationController::class, 'destroy'])->name('migration.destroy');
});
