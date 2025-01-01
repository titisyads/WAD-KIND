<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LembagaController;

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
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');


Route::middleware('auth')->group(function() {
    Route::resource('basic', BasicController::class);

    Route::middleware(['role:Admin|Pengurus Lembaga'])->prefix('lembaga')->group(function () {  
        Route::get('/export', [LembagaController::class, 'export'])->name('lembagas.export');
        Route::get('/', [LembagaController::class, 'index'])->name('lembagas.index');  
        Route::get('/create', [LembagaController::class, 'create'])->name('lembagas.create');       
        Route::get('{id}', [LembagaController::class, 'show'])->name('lembagas.show');      
        Route::post('/', [LembagaController::class, 'store'])->name('lembagas.store');      
        Route::get('{id}/edit', [LembagaController::class, 'edit'])->name('lembagas.edit');  
        Route::put('{id}', [LembagaController::class, 'update'])->name('lembagas.update');   
        Route::delete('{id}', [LembagaController::class, 'destroy'])->name('lembagas.destroy');


    });
});
