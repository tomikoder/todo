<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('menu.menu');
})->middleware('guest');

Route::get('/list',[TaskController::class, 'index'])->middleware('auth')
  ->name('item.list');

Route::get('/get/{id}',[TaskController::class, 'edit'])->middleware('auth')
  ->where('id', '[0-9]+')
  ->name('item.get');

Route::post('/get/{id}',[TaskController::class, 'update'])->middleware('auth')
  ->where('id', '[0-9]+')
  ->name('item.get.update');

Route::post('/delete/{id}', [TaskController::class, 'destroy'])->middleware('auth')
  ->where('id', '[0-9]+')
  ->name('item.delete');

Route::post('/publish/{id}',[TaskController::class, 'publish'])->middleware('auth')
  ->where('id', '[0-9]+')
  ->name('item.publish');

Route::get('/show/{uuid}',[TaskController::class, 'show'])->middleware('auth')
  ->whereUuid('uuid')
  ->name('item.show');

Route::get('/list/add',[TaskController::class, 'create'])->middleware('auth')
  ->name('item.add.form');

Route::post('/list/add',[TaskController::class, 'store'])->middleware('auth')
  ->name('item.add.send');

Route::get('/history/{id}',[TaskController::class, 'history'])->middleware('auth')
  ->where('id', '[0-9]+')
  ->name('item.history');


require __DIR__.'/auth.php';
