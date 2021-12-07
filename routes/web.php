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

Route::get('/', [App\Http\Controllers\Graficos::class, 'apiIndicador'])->name('ver');

Route::get('/grafico', [App\Http\Controllers\Graficos::class, 'guardarIndicador'])->name('grafico.guardar');

Route::get('/grafico/ver', [App\Http\Controllers\Graficos::class, 'listaIndicador'])->name('lista.rangos');

Route::get('/grafico/{id}/detalles', [App\Http\Controllers\Graficos::class, 'detallesIndicador'])->name('grafico.detalle');

Route::get('/editar/{id}', [App\Http\Controllers\Graficos::class, 'updateIndicador'])->name('grafico.editar');

Route::get('/volver', [App\Http\Controllers\Graficos::class, 'listaIndicador'])->name('volver');

Route::get('/volver2', [App\Http\Controllers\Graficos::class, 'apiIndicador'])->name('volver2');

Route::delete('/eliminar/{id}', [App\Http\Controllers\Graficos::class, 'eliminarIndicador'])->name('grafico.eliminar');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
