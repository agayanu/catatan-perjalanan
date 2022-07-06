<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;

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
Route::middleware(['guest'])->group(function() {
    Route::get('/', [AuthController::class, 'formLogin'])->name('login');
    Route::post('/', [AuthController::class, 'login']);
});

Route::middleware(['member'])->group(function() {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::post('home', [HomeController::class, 'update']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('note', [NoteController::class, 'index'])->name('note');
    Route::get('note-data', [NoteController::class, 'data'])->name('note-data');
    Route::post('note', [NoteController::class, 'store']);
});
