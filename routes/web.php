<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [GameController::class, 'index'])->name('game.index');
Route::post('/check', [GameController::class,'check'])->name('game.check');
Route::get('/high-scores', [GameController::class, 'highScores'])->name('game.highScores');

