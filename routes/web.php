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

Route::get('/alfabeto', function(){
	return view('aluno.alfabeto');
})->middleware('auth:aluno');

Route::get('/opcoes/{letra}', function($letra){
	return view('aluno.opcoes')->with('letra', $letra);
})->name('opcoes')->middleware('auth:aluno');

Route::get('/video/{tipo}/{letra}', 'VideosController@index')->middleware('auth:aluno');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => '/alunos'], function(){
	Route::get('/', 'AlunosController@index')->name('alunos.index')->middleware('auth:professor');
	Route::get('/adicionar', 'AlunosController@create')->name('aluno.adicionar')->middleware('auth:professor');
	Route::get('/editar/{id}', 'AlunosController@edit')->name('aluno.editar')->middleware('auth:professor');
	Route::post('/store', 'AlunosController@store')->name('aluno.store')->middleware('auth:professor');
	Route::patch('/update/{id}', 'AlunosController@update')->name('aluno.update')->middleware('auth:professor');
	Route::post('/delete', 'AlunosController@delete')->name('aluno.delete')->middleware('auth:professor');
});