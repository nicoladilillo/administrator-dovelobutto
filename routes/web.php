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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/product', 'ProductController@index')->name('product');

Route::post('/product/{id}/bin', 'ProductController@bin')->name('bin.update');

Route::delete('/product/{id}/destroy', 'ProductController@destroy')->name('bin.destroy');

Route::get('/product/all', 'ProductController@all')->name('product.all');

Route::post('/product/create', 'ProductController@create')->name('product.create');

Route::get('/cities', 'CityController@index')->name('city');
Route::post('/cities/create', 'CityController@create')->name('city.create');
Route::delete('/cities/{id}/delete', 'CityController@delete')->name('city.delete');
