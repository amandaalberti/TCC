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

// Authentication Routes...
Route::post('sair', 'Auth\LoginController@logout')->name('logout');
Route::group(['middleware' => ['guest:professor', 'guest:aluno']], function(){
	Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('/', 'Auth\LoginController@login');

	// Registration Routes...
	Route::get('cadastro', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('cadastro', 'Auth\RegisterController@register');

	// Password Reset Routes...
	Route::get('esqueceu-sua-senha', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('esqueceu-sua-senha/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('esqueceu-sua-senha/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('esqueceu-sua-senha', 'Auth\ResetPasswordController@reset');
});

Route::group(['middleware' => ['auth:aluno']], function(){
	Route::get('/alfabeto', function(){
		return view('aluno.alfabeto');
	});

	Route::get('/opcoes/{letra}', function($letra){
		return view('aluno.opcoes')->with('letra', $letra);
	})->name('opcoes');

	Route::get('/video/{tipo}/{letra}', 'VideosController@index');
});

Route::group(['middleware' => ['auth:professor']], function(){
	Route::group(['prefix' => '/alunos'], function(){
		Route::get('/', 'AlunosController@index')->name('alunos.index');
		Route::get('/adicionar', 'AlunosController@create')->name('aluno.adicionar');
		Route::get('/editar/{id}', 'AlunosController@edit')->name('aluno.editar');
		Route::post('/store', 'AlunosController@store')->name('aluno.store');
		Route::patch('/update/{id}', 'AlunosController@update')->name('aluno.update');
		Route::post('/delete', 'AlunosController@delete')->name('aluno.delete');
	});

	Route::group(['prefix' => '/palavras'], function(){
		Route::get('/', 'PalavrasController@index')->name('palavras.index');
		Route::get('/adicionar', 'PalavrasController@create')->name('palavra.adicionar');
		Route::get('/editar/{id}', 'PalavrasController@edit')->name('palavra.editar');
		Route::post('/store', 'PalavrasController@store')->name('palavra.store');
		Route::patch('/update/{id}', 'PalavrasController@update')->name('palavra.update');
		Route::post('/delete', 'PalavrasController@delete')->name('palavra.delete');
	});
});
