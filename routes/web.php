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
        return view('home');
    });

    Auth::routes();

	Route::get('/home', 'HomeController@index')->name('home');
	Route::group(['middleware' => ['auth']], function () {  
        Route::resource('/entradas', 'EntradaController');

        // MOTORISTA
        Route::get('/motorista','MotoristaController@index')->name('motorista');
        Route::post('/motorista','MotoristaController@store')->name('motorista.store');
        Route::get('/motorista/listar','MotoristaController@show')->name('motorista.show');
        Route::get('/motorista/listar/{id}','MotoristaController@edit')->name('motorista.edit');
        Route::post('/motorista/listar/{id}','MotoristaController@update')->name('motorista.update');
        Route::get('/motorista/listar/excluir/{id}','MotoristaController@delete')->name('motorista.delete');
        Route::post('/motorista/listar/excluir/{id}','MotoristaController@destroy')->name('motorista.destroy');

        // CARRO
        Route::get('/carro','CarroController@index')->name('carro');
        Route::post('/carro','CarroController@store')->name('carro.store');
        Route::get('/carro/listar','CarroController@show')->name('carro.show');
        Route::get('/carro/listar/{id}','CarroController@edit')->name('carro.edit');
        Route::post('/carro/listar/{id}','CarroController@update')->name('carro.update');
        Route::get('/carro/listar/excluir/{id}','CarroController@delete')->name('carro.delete');
        Route::post('/carro/listar/excluir/{id}','CarroController@destroy')->name('carro.destroy');

        Route::get('/entrada','EntradaController@index')->name('entrada');
        Route::post('/entrada','EntradaController@store')->name('entrada.store');

        // VERIFICAÇÃO
        Route::get('/verificacao/{id}','VerificacaoController@show')->name('verificacao.show'); //SHOW
        Route::post('/verificacao','VerificacaoController@index')->name('verificacao.store'); //STORE

        // TIPO DE AVARIA
        Route::post('/tipoAvaria','TipoAvariaController@store')->name('tipoAvaria.store'); //STORE

        // LOCAL DE AVARIA
        Route::post('/localAvaria','LocalAVariasController@store')->name('localAvaria.store'); //STORE
});


