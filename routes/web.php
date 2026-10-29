<?php

use App\Http\Controllers\AllergeenController;
use App\Http\Controllers\LeverancierController;
use App\Http\Controllers\LeveringController;
use App\Http\Controllers\MagazijnController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $rol = Auth::user()->role;

    return view('dashboard', [
        'rol' => $rol,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Overzicht Magazijn Jamin (Wireframe 1)
    Route::get('/magazijn', [MagazijnController::class, 'index'])->name('magazijn.index');

    // User Story 1: Detailscherm Leveringsinformatie (Wireframe 2)
    Route::get('/levering/{productId}', [LeveringController::class, 'show'])->name('levering.show');

    // User Story 2: Detailscherm Allergeneninformatie (Wireframe 3)
    Route::get('/allergeen/{productId}', [AllergeenController::class, 'show'])->name('allergeen.show');

    // Opdracht 2 - User Story 1: Overzicht leveranciers (Wireframe 01)
    Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leveranciers.index');

    // Opdracht 2 - User Story 1: Geleverde producten van een leverancier (Wireframe 02 en 03)
    Route::get('/leveranciers/{id}/producten', [LeverancierController::class, 'producten'])
        ->whereNumber('id')
        ->name('leveranciers.producten');
});

require __DIR__.'/auth.php';