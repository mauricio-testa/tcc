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
    Route::get('/viagens',  'ViagemController@index');

    Route::group(['prefix' => 'cadastros'], function () {

        Route::group(['prefix' => 'motoristas'], function () {
            Route::get('/',             'MotoristaController@index')->name('motorista.index');
            Route::get('/edit/{id?}',   'MotoristaController@edit')->name('motorista.edit');
            Route::get('/delete/{id}',  'MotoristaController@delete')->name('motorista.delete');
        });
        
        Route::get('/veiculos',     'VeiculoController@index');
        Route::get('/pacientes',    'PacienteController@index');
    });

});

Auth::routes();