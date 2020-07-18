<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/products', 'ProductController@index');
Route::post('/productos/guardar', 'ProductController@store');
Route::post('/productos/buscar', 'ProductController@search');
Route::post('/productos/eliminar', 'ProductController@destroy');

Route::get('/clientes', 'CustomerController@index');
Route::post('/clientes/guardar', 'CustomerController@store');
Route::post('/clientes/eliminar', 'CustomerController@destroy');

Route::get('/empleados', 'EmployeeController@index');
Route::post('/empleados/guardar', 'EmployeeController@store');
Route::post('/empleados/eliminar', 'EmployeeController@destroy');

Route::get('/entregas', 'DeliveryController@index');
Route::post('/entregas/guardar', 'DeliveryController@store');
Route::post('/entregas/eliminar', 'DeliveryController@destroy');

Route::get('/proyectos', 'ProyectController@index');
Route::post('/proyectos/guardar', 'ProyectController@store');
Route::post('/proyectos/eliminar', 'ProyectController@destroy');
