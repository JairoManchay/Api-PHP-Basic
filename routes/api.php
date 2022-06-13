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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Autorizando, solicitando la autorizacion para que imprima datos
Route::get('/libros', 'LibroController@index');

// solicitando permiso para guardar 
Route::post('/libros', 'LibroController@guardar');

// solicitando permiso para buscar por id
Route::get('/libros/{id}','LibroController@ver');

// Solicitando para eliminar los datos
Route::delete('/libros/{id}','LibroController@eliminar');

// Solicitando actualizar datos
Route::post('/libros/{id}','LibroController@actualizar');