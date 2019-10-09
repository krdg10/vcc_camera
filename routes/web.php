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
    Route::get('/home', function () {
        return view('home.home');
    });

    Auth::routes();

	Route::group(['middleware' => ['auth']], function () {  

        // MOTORISTA
        Route::get('/motorista/create', function () {
            return view('motorista.create');})
            ->name('motorista.create');
        Route::get('/motorista','MotoristaController@listaMotoristas')->name('motorista.lista');
        Route::get('/motorista/{id}','MotoristaController@editMotorista')->name('motorista.edit');
        Route::put('/motorista/{id}','MotoristaController@updateMotorista')->name('motorista.update');
        Route::get('/motorista/excluir/{id}','MotoristaController@deleteMotorista')->name('motorista.delete');
        Route::delete('/motorista/excluir/{id}','MotoristaController@destroyMotorista')->name('motorista.destroy');
        Route::post('/motorista/buscar', 'MotoristaController@buscaMotorista')->name('motorista.busca');
        Route::get('/motorista/buscar', 'MotoristaController@buscaMotorista');
        Route::post('/motorista/create','MotoristaController@storeMotorista')->name('motorista.store');

        // CARRO
        Route::get('/carro/create', function () {
            return view('carro.create');})
            ->name('carro.create');
        Route::post('/carro/create','CarroController@storeCarro')->name('carro.store');
        Route::get('/carro','CarroController@listaCarros')->name('carro.lista');
        Route::get('/carro/{id}','CarroController@editCarro')->name('carro.edit');
        Route::put('/carro/{id}','CarroController@updateCarro')->name('carro.update');
        Route::get('/carro/excluir/{id}','CarroController@deleteCarro')->name('carro.delete');
        Route::delete('/carro/excluir/{id}','CarroController@destroyCarro')->name('carro.destroy');
        Route::post('/carro/buscar', 'CarroController@buscaCarros')->name('carro.busca');
        Route::get('/carro/buscar', 'CarroController@buscaCarros');

        // ENTRADA
        Route::get('/entrada','EntradaController@listaEntradas')->name('entrada.lista');
        Route::get('/entrada/create','EntradaController@createEntrada')->name('entrada.create');
        Route::post('/entrada','EntradaController@storeEntradas')->name('entrada.store');
        Route::post('/entrada/buscar', 'EntradaController@buscaEntradas')->name('entrada.busca');
        Route::get('/entrada/buscar', 'EntradaController@buscaEntradas');
        Route::get('/entrada/rbt/{rfid}','EntradaController@storeEntradasByRFID')->name('entrada.storeRbt'); // STORE ROBOT
        Route::put('/entrada/addMotorista/{id}','EntradaController@adicionaMotoristaEntrada')->name('entrada.adicionaMotorista'); // edit
        Route::get('/entrada/addMotorista/{id}','EntradaController@exibeEntrada')->name('entrada.addMotorista');

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


