<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\CalculoComisiones;
use App\Http\Livewire\Usuario\Show;


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

Route::get('/usuarios',Show::class)->name('usuarios')->middleware('auth');

//RUTAS DE VENTAS
Route::get('/ventas_nueva',[VentasController::class,'show_nueva'])->middleware('auth')->name('ventas_nueva');
Route::post('/ventas_nueva',[VentasController::class,'save_nueva'])->middleware('auth')->name('ventas_nueva');
Route::get('/base_ventas',[VentasController::class,'base_ventas'])->middleware('auth')->name('base_ventas');

//RUTAS ARCHIVOS AT&T

Route::get('/carga_cis',function () {return view('carga_cis');})->middleware('auth')->name('carga_cis');
Route::post('/carga_cis',[ImportController::class,'carga_cis'])->middleware('auth')->name('carga_cis');

Route::get('/detalle_calculo',function () {return view('detalle_calculo');})->middleware('auth')->name('detalle_calculo');
Route::get('/seguimiento_att',function () {return view('seguimiento_att');})->middleware('auth')->name('seguimiento_att');

Route::get('/periodo_nuevo',function () {return view('periodo_nuevo');})->middleware('auth')->name('periodo_nuevo');

//RUTAS DE CALCULO COMISIONES

Route::get('/nuevo_calculo',[CalculoComisiones::class,'nuevo'])->middleware('auth')->name('nuevo_calculo');
Route::post('/nuevo_calculo',[CalculoComisiones::class,'save_nuevo'])->middleware('auth')->name('nuevo_calculo');

Route::get('/calculo_ejecutar/{id}',[CalculoComisiones::class,'calculo_comisiones']);