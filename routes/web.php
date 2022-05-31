<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\CalculoComisiones;
use App\Http\Controllers\EstadosCuenta;
use App\Http\Livewire\Usuario\Show;
use App\Http\Livewire\Cuotas\Gerentes;


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

Route::get('/carga_cis_pospago',function () {return view('carga_cis_pospago');})->middleware('auth')->name('carga_cis_pospago');
Route::post('/carga_cis_pospago',[ImportController::class,'carga_cis_pospago'])->middleware('auth')->name('carga_cis_pospago');
Route::get('/carga_cis_renovacion',function () {return view('carga_cis_renovacion');})->middleware('auth')->name('carga_cis_renovacion');
Route::post('/carga_cis_renovacion',[ImportController::class,'carga_cis_renovacion'])->middleware('auth')->name('carga_cis_renovacion');

Route::get('/detalle_calculo/{id}',[CalculoComisiones::class,'detalle_calculo'])->middleware('auth')->name('detalle_calculo');
Route::get('/seguimiento_att',function () {return view('seguimiento_att');})->middleware('auth')->name('seguimiento_att');

Route::get('/periodo_nuevo',function () {return view('periodo_nuevo');})->middleware('auth')->name('periodo_nuevo');

//RUTAS DE CALCULO COMISIONES

Route::get('/nuevo_calculo',[CalculoComisiones::class,'nuevo'])->middleware('auth')->name('nuevo_calculo');
Route::post('/nuevo_calculo',[CalculoComisiones::class,'save_nuevo'])->middleware('auth')->name('nuevo_calculo');

Route::post('/calculo_ejecutar',[CalculoComisiones::class,'calculo_comisiones'])->middleware('auth')->name('calculo_ejecutar');
Route::get('/seguimiento_calculo',[CalculoComisiones::class,'seguimiento_calculo'])->middleware('auth')->name('seguimiento_calculo');
Route::get('/export_pagos_vendedor/{id}',[CalculoComisiones::class,'export_pagos_vendedor'])->middleware('auth')->name('export_pagos_vendedor');
Route::get('/export_comisiones_vendedor/{id}',[CalculoComisiones::class,'export_comisiones_vendedor'])->middleware('auth')->name('export_comisiones_vendedor');
Route::get('/comision_vendedores/{id}',[EstadosCuenta::class,'vendedores'])->middleware('auth')->name('comision_vendedores');
Route::get('/estado_cuenta_vendedor/{id}/{user_id}',[EstadosCuenta::class,'estado_cuenta_vendedor'])->middleware('auth')->name('estado_cuenta_vendedor');
Route::get('/comision_gerentes/{id}',[EstadosCuenta::class,'gerentes'])->middleware('auth')->name('comision_gerentes');
Route::get('/estado_cuenta_gerente/{id}/{user_id}',[EstadosCuenta::class,'estado_cuenta_gerente'])->middleware('auth')->name('estado_cuenta_gerente');

//

Route::get('/cuotas_gerentes',Gerentes::class)->name('cuotas_gerentes')->middleware('auth');
