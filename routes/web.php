<?php

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

Route::group(['prefix' => 'cadastros'], function () {
    
    Route::get('/motoristas',   'MotoristaController@index');
    Route::get('/veiculos',     'VeiculoController@index');
    Route::get('/pacientes',    'PacienteController@index');

});

Route::get('/viagens',    'ViagemController@index');