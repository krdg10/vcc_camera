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
        return view('home.home');
    });

    Auth::routes();

	Route::get('/home', 'HomeController@index')->name('home');
	Route::group(['middleware' => ['auth']], function () {  

        // MOTORISTA
        Route::get('/motorista/create','MotoristaController@create')->name('motorista.create'); // CREATE
        Route::get('/motorista/listar','MotoristaController@show')->name('motorista.show');
        Route::get('/motorista/listar/{id}','MotoristaController@edit')->name('motorista.edit');
        Route::put('/motorista/listar/{id}','MotoristaController@update')->name('motorista.update');
        Route::get('/motorista/listar/excluir/{id}','MotoristaController@delete')->name('motorista.delete');
        Route::delete('/motorista/listar/excluir/{id}','MotoristaController@destroy')->name('motorista.destroy');
        Route::post('/motorista/buscar', 'MotoristaController@busca')->name('motorista.busca');
        Route::get('/motorista/buscar', 'MotoristaController@busca');
        Route::post('/motorista','MotoristaController@store')->name('motorista.store');
        

        // CARRO
        Route::get('/carro','CarroController@index')->name('carro');
        Route::post('/carro','CarroController@store')->name('carro.store');
        Route::get('/carro/listar','CarroController@show')->name('carro.show');
        Route::get('/carro/listar/{id}','CarroController@edit')->name('carro.edit');
        Route::put('/carro/listar/{id}','CarroController@update')->name('carro.update');
        Route::get('/carro/listar/excluir/{id}','CarroController@delete')->name('carro.delete');
        Route::delete('/carro/listar/excluir/{id}','CarroController@destroy')->name('carro.destroy');
        Route::post('/carro/buscar', 'CarroController@busca')->name('carro.busca');
        Route::get('/carro/buscar', 'CarroController@busca');


        // ENTRADA
        Route::get('/entrada','EntradaController@index')->name('entrada');
        Route::get('/entrada/create','EntradaController@create')->name('entrada.create');
        Route::post('/entrada','EntradaController@store')->name('entrada.store');
        Route::post('/entrada/buscar', 'EntradaController@busca')->name('entrada.busca');
        Route::get('/entrada/buscar', 'EntradaController@busca');


        // VERIFICAÇÃO
        Route::get('/verificacao/{id}','VerificacaoController@show')->name('verificacao.show'); // SHOW
        Route::post('/verificacao/{id}','VerificacaoController@store')->name('verificacao.store'); // STORE
        Route::get('/verificacao/edit/{id}','VerificacaoController@edit')->name('verificacao.edit'); // edit
        Route::put('/verificacao/edit/{id}','VerificacaoController@update')->name('verificacao.update'); // edit
        Route::delete('/verificacao/edit/excluir/{id}','DescAvariasController@destroy')->name('descavarias.destroy');
        Route::post('/verificacao/edit/adicionar/{id}','DescAvariasController@store')->name('descavarias.store');
        Route::get('/verificacao/edit/adicionar/{id}','VerificacaoController@edit')->name('verificacao.edit');
        Route::get('/verificacao/exibir/{id}','VerificacaoController@exibir')->name('verificacao.exibir');
  

        // TIPO DE AVARIA
        Route::get('/tipoAvaria','TipoAvariaController@index')->name('tipoAvaria'); // INDEX
        Route::post('/tipoAvaria','TipoAvariaController@store')->name('tipoAvaria.store'); // STORE
        Route::put('/tipoAvaria/{id}','TipoAvariaController@update')->name('tipoAvaria.update'); // UPDATE
        Route::delete('/tipoAvaria/{id}','TipoAvariaController@destroy')->name('tipoAvaria.delete()'); // DELETE

        // LOCAL DE AVARIA
        Route::get('/localAvaria','LocalAVariasController@index')->name('localAvaria'); // INDEX
        Route::post('/localAvaria','LocalAVariasController@store')->name('localAvaria.store'); // STORE
        Route::put('/localAvaria/{id}','LocalAVariasController@update')->name('localAvaria.update'); // UPDATE
        Route::delete('/localAvaria/{id}','LocalAvariasController@destroy')->name('localAvaria.destroy'); // DELETE

        
        Route::get('image/upload','ImageUploadController@fileCreate');
        Route::post('image/upload/store','ImageUploadController@fileStore');
        Route::post('image/delete','ImageUploadController@fileDestroy');
});


