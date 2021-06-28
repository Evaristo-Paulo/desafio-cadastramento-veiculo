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
Route::get('/dicas', 'MainController@index')->name('etips.index');
Route::get('/dicas/tipos/{slug}/filtro', 'MainController@filterByType')->name('etips.filter.type');
Route::get('/dicas/marcas/{slug}/filtro', 'MainController@filterByBrand')->name('etips.filter.brand');
Route::get('/dicas/modelos/{slug}/filtro', 'MainController@filterByModel')->name('etips.filter.model');
Route::get('/dicas/versoes/{name}/filtro', 'MainController@filterByVersion')->name('etips.filter.version');
Route::post('/usuarios/registo', 'MainController@registerUser')->name('etips.user.register');
Route::get('/dicas/registo', 'MainController@register')->name('etips.register');
Route::post('/registo', 'MainController@registerStore')->name('etips.register.store');
Route::get('/minhas-dicas/{id}/actualizacao', 'MainController@update')->name('etips.update');
Route::post('/minhas-dicas/{id}/actualizacao', 'MainController@updateStore')->name('etips.update.store');
Route::delete('/minhas-dicas/{id}/remocao', 'MainController@remove')->name('etips.remove');
Route::get('/minhas-dicas', 'MainController@myTips')->name('etips.mytips');
