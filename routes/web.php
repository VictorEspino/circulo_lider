<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantillaController;

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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/plantilla_nuevo',[PlantillaController::class,'show_nuevo'])->middleware('auth')->name('plantilla_nuevo');
Route::post('/plantilla_nuevo',[PlantillaController::class,'save_nuevo'])->middleware('auth')->name('plantilla_nuevo');
Route::get('/plantilla_update',[PlantillaController::class,'show_update'])->middleware('auth')->name('plantilla_update');
Route::post('/plantilla_update',[PlantillaController::class,'save_update'])->middleware('auth')->name('plantilla_update');
Route::get('/plantilla_consulta/{user}',[PlantillaController::class,'consulta'])->middleware('auth')->name('plantilla_consulta');

