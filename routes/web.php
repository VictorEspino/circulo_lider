<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\InteraccionController;
use App\Http\Controllers\ZonaInfluenciaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\CalculoComisiones;
use App\Http\Controllers\EstadosCuenta;
use App\Http\Controllers\FunnelController;
use App\Http\Controllers\ConciliacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstadoCuentaComercial;
use App\Http\Livewire\Usuario\Show;
use App\Http\Livewire\Cuotas\Gerentes;
use App\Http\Livewire\Plan100\Seguimiento;
use App\Http\Controllers\VistaBoletos;


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

Route::get('/',[DashboardController::class,'principal'])->middleware('auth')->name('dashboard');

Route::get('/usuarios',Show::class)->name('usuarios')->middleware('auth');

//RUTAS DE VENTAS
Route::get('/ventas_nueva',[VentasController::class,'show_nueva'])->middleware('auth')->name('ventas_nueva');
Route::get('/ventas_nueva/{origen}/{nombre}/{email}',[VentasController::class,'show_nueva'])->middleware('auth')->name('ventas_nueva');
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

//CUADRANTE DE GESTION

//Route::get('/interaccion_nuevo',function () {return(view('interaccion.nuevo'));})->name('interaccion_nuevo')->middleware('auth');
Route::get('/interaccion_nuevo',[InteraccionController::class,'show_form_nuevo'])->name('interaccion_nuevo')->middleware('auth');
Route::post('/interaccion_nuevo',[InteraccionController::class,'interaccion_nuevo'])->name('interaccion_nuevo')->middleware('auth');
Route::post('/interaccion_nuevo',[InteraccionController::class,'interaccion_nuevo'])->name('orden_nuevo')->middleware('auth');

Route::get('/zona_influencia_nuevo',[ZonaInfluenciaController::class,'show_form_nuevo'])->name('zona_influencia_nuevo')->middleware('auth');
Route::post('/zona_influencia_nuevo',[ZonaInfluenciaController::class,'zona_influencia_nuevo'])->name('zona_influencia_nuevo')->middleware('auth');


//FUNNEL

Route::get('/show_calendario',[FunnelController::class,'show_calendario'])->name('show_calendario')->middleware('auth');
Route::get('/seguimiento_funnel',[FunnelController::class,'seguimiento_funnel'])->name('seguimiento_funnel')->middleware('auth');
Route::get('/funnel_detalles/{id}',[FunnelController::class,'funnel_detalles'])->name('funnel_detalles')->middleware('auth');
Route::post('/funnel_update',[FunnelController::class,'funnel_update'])->name('funnel_update')->middleware('auth');
Route::get('/funnel_form/{origen}',[FunnelController::class,'funnel_form'])->name('funnel_form')->middleware('auth');
Route::post('/funnel_form',[FunnelController::class,'funnel_save'])->name('funnel_save')->middleware('auth');

//PLAN 100

Route::get('/plan100',Seguimiento::class)->name('plan100')->middleware('auth');

//CONCILIACION

Route::get('/conciliacion_nuevo',[ConciliacionController::class,'vista_nuevo'])->middleware('auth')->name('conciliacion_nuevo');
Route::post('/conciliacion_nuevo',[ConciliacionController::class,'conciliacion_nuevo'])->middleware('auth')->name('conciliacion_nuevo');
Route::get('/seguimiento_conciliacion',[ConciliacionController::class,'seguimiento_conciliacion'])->middleware('auth')->name('seguimiento_conciliacion');
Route::get('/detalle_conciliacion',[ConciliacionController::class,'detalle_conciliacion'])->middleware('auth')->name('detalle_conciliacion');
Route::post('/callidus_import', [ConciliacionController::class,'callidus_import'])->middleware('auth')->name('callidus_import')->middleware('auth');
Route::post('/callidus_residual_import', [ConciliacionController::class,'callidus_residual_import'])->middleware('auth')->name('callidus_residual_import')->middleware('auth');
Route::get('/reclamos_export/{id}',[ConciliacionController::class,'reclamos_export'])->name('reclamos_export')->middleware('auth');
Route::get('/reclamos_residual_export/{id}',[ConciliacionController::class,'reclamos_residual_export'])->name('reclamos_residual_export')->middleware('auth');

//RUTAS VENDEDOR PARA ESTADOS DE CUENTA DE COMISIONES

Route::get('/estado_cuenta_comercial',[EstadoCuentaComercial::class,'estado_cuenta_comercial'])->name('estado_cuenta_comercial')->middleware('auth');
Route::get('/calculos_disponibles_comercial',[EstadoCuentaComercial::class,'calculos_disponibles_comercial'])->name('calculos_disponibles_comercial')->middleware('auth');

//CONCURSO

Route::get('/boletos',[VistaBoletos::class,'vista_boletos'])->name('vista_boletos');