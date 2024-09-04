<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\MensajeWpController;

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

// Rutas de Recursos
Route::resource('categorias', CategoriaController::class);
Route::resource('productos', ProductoController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('eventos', EventoController::class);
Route::resource('entregas', EntregaController::class);
Route::resource('pedidos', PedidoController::class);
Route::resource('mensajes_wp', MensajeWpController::class);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*Route::get('/', function () {
    return view('welcome');
});*/
