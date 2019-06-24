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
    Route::resource('/verificacoa', 'DescAvariasController');


    Route::get('/motorista','MotoristaController@index')->name('motorista');
    Route::post('/motorista','MotoristaController@store')->name('motorista.store');

    Route::get('/carro','CarroController@index')->name('carro');
    Route::post('/carro','CarroController@store')->name('carro.store');

    Route::get('/entrada','EntradaController@index')->name('entrada');
    Route::post('/entrada','EntradaController@store')->name('entrada.store');
});


