<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('menu.menu');
})->middleware('guest');

Route::get('/list',[TaskController::class, 'index'])->middleware('auth')
  ->name('item.list');

Route::get('/get/{id}',[TaskController::class, 'show'])->middleware('auth')
  ->where('id', '[0-9]+')
  ->name('item.get');

Route::get('/list/add',[TaskController::class, 'create'])->middleware('auth')
  ->name('item.add.form');

Route::post('/list/add',[TaskController::class, 'store'])->middleware('auth')
  ->name('item.add.send');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
