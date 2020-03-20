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


Route::middleware(['auth'])->group(function () {

    Route::get('/',         'IndexController@index')->name('index');
    Route::view('/viagens', 'viagem');

    Route::group(['prefix' => 'cadastros'], function () {
        Route::view('/motoristas'   , 'motorista');
        Route::view('/veiculos'     , 'veiculo');
        Route::view('/pacientes'    , 'paciente');
    });

    Route::prefix('api')->group(function () {
        Route::resource('motoristas'    , 'Api\MotoristaController');
        Route::resource('veiculos'      , 'Api\VeiculoController');
        Route::resource('pacientes'     , 'Api\PacienteController');
        Route::resource('viagens'       , 'Api\ViagemController');
    });

});

Auth::routes();
