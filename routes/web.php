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

Route::get('/', function () {
    return redirect(route('home'));
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix'=>'/kategori'],function(){
    Route::get('/','KategoriController@index')->name('kategori.index');
    Route::post('/store','KategoriController@store')->name('kategori.store');
    Route::get('/delete/{id}','KategoriController@delete')->name('kategori.delete');
});
Route::group(['prefix'=>'/barang'],function(){
    Route::get('/','BarangController@index')->name('barang.index');
    Route::post('/store','BarangController@store')->name('barang.store');
    Route::get('/delete/{id}','BarangController@delete')->name('barang.delete');
});
