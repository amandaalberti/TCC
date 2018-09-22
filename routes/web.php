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

Route::get('/alfabeto', function(){
	return view('aluno.alfabeto');
})->middleware('auth:aluno');

Route::get('/opcoes/{letra}', function($letra){
	return view('aluno.opcoes')->with('letra', $letra);
})->name('opcoes')->middleware('auth:aluno');

Route::get('/video/{tipo}/{letra}', 'VideosController@index')->middleware('auth:aluno');

//Auth::routes();
// Authentication Routes...
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::post('/', 'Auth\LoginController@login')->middleware('guest');
Route::post('sair', 'Auth\LoginController@logout')->name('logout')->middleware('guest');
// Registration Routes...
Route::get('cadastro', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('guest');
Route::post('cadastro', 'Auth\RegisterController@register')->middleware('guest');
// Password Reset Routes...
Route::get('esqueceu-sua-senha', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request')->middleware('guest');
Route::post('esqueceu-sua-senha/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email')->middleware('guest');
Route::get('esqueceu-sua-senha/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset')->middleware('guest');
Route::post('esqueceu-sua-senha', 'Auth\ResetPasswordController@reset')->middleware('guest');

Route::group(['prefix' => '/alunos'], function(){
	Route::get('/', 'AlunosController@index')->name('alunos.index')->middleware('auth:professor');
	Route::get('/adicionar', 'AlunosController@create')->name('aluno.adicionar')->middleware('auth:professor');
	Route::get('/editar/{id}', 'AlunosController@edit')->name('aluno.editar')->middleware('auth:professor');
	Route::post('/store', 'AlunosController@store')->name('aluno.store')->middleware('auth:professor');
	Route::patch('/update/{id}', 'AlunosController@update')->name('aluno.update')->middleware('auth:professor');
	Route::post('/delete', 'AlunosController@delete')->name('aluno.delete')->middleware('auth:professor');
});

Route::group(['prefix' => '/palavras'], function(){
	Route::get('/', 'PalavrasController@index')->name('palavras.index')->middleware('auth:professor');
	Route::get('/adicionar', 'PalavrasController@create')->name('palavra.adicionar')->middleware('auth:professor');
	Route::get('/editar/{id}', 'PalavrasController@edit')->name('palavra.editar')->middleware('auth:professor');
	Route::post('/store', 'PalavrasController@store')->name('palavra.store')->middleware('auth:professor');
	Route::patch('/update/{id}', 'PalavrasController@update')->name('palavra.update')->middleware('auth:professor');
	Route::post('/delete', 'PalavrasController@delete')->name('palavra.delete')->middleware('auth:professor');
});