<?php

use Illuminate\Support\Facades\Route;

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

Route::post('/login', 'MainController@login')->name('etips.login');
Route::get('/logout', 'MainController@logout')->name('etips.logout');
Route::get('/', 'MainController@index')->name('etips.index');
Route::post('/usuarios/registo', 'MainController@registerUser')->name('etips.user.register');
Route::post('/usuarios/teste', 'MainController@registerUser')->name('etips.user.teste');
Route::get('/registo', 'MainController@register')->name('etips.register');
Route::post('/registo', 'MainController@registerStore')->name('etips.register.store');
Route::get('/minhas-dicas/{id}/actualizacao', 'MainController@update')->name('etips.update');
Route::post('/minhas-dicas/{id}/actualizacao', 'MainController@updateStore')->name('etips.update.store');
Route::delete('/minhas-dicas/{id}/remocao', 'MainController@remove')->name('etips.remove');
Route::get('/minhas-dicas', 'MainController@myTips')->name('etips.mytips');
