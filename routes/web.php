<?php

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

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function (){
    Route::apiResource('transaction', \App\Http\Controllers\TransactionController::class);

    Route::get('user', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::put('user', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
});