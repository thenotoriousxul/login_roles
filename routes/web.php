<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\DashBoardController;
use App\Http\Controllers\cliente\ClienteDashboardController;
use Illuminate\Support\Facades\Route;

// Ruta de bienvenida
Route::get('/', function () {
return view('welcome');
});

// Rutas para el rol de cliente
Route::middleware('role:cliente')->group(function () {
Route::get('/clientedashboard', [ClienteDashboardController::class, 'index'])->name('clientedashboard');
});

// Rutas para el rol de admin
Route::middleware('role:admin')->group(function () {
Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
