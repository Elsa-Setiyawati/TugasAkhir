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
Route::group(['prefix'=>'/pemasok'],function(){
    Route::get('/','PemasokController@index')->name('pemasok.index');
    Route::post('/store','PemasokController@store')->name('pemasok.store');
    Route::get('/delete/{id}','PemasokController@delete')->name('pemasok.delete');
});
Route::group(['prefix'=>'/pelanggan'],function(){
    Route::get('/','PelangganController@index')->name('pelanggan.index');
    Route::post('/store','PelangganController@store')->name('pelanggan.store');
    Route::get('/delete/{id}','PelangganController@delete')->name('pelanggan.delete');
});
Route::group(['prefix'=>'/users'],function(){
    Route::get('/','UsersController@index')->name('users.index');
    Route::post('/store','UsersController@store')->name('users.store');
    Route::get('/delete/{id}','UsersController@delete')->name('users.delete');
});
Route::group(['prefix'=>'/pembelian'],function(){
    Route::get('/','pembelianController@index')->name('pembelian.index');
    Route::get('/transaksi/{id?}/{action?}','pembelianController@transaksi')->name('pembelian.transaksi');
    Route::post('/store','pembelianController@store')->name('pembelian.store');
    Route::post('/save_transaksi','pembelianController@save_transaksi')->name('pembelian.save_transaksi');
    Route::post('/return_store','pembelianController@return_store')->name('pembelian.return_store');
    Route::get('/delete/{id}','pembelianController@delete')->name('pembelian.delete');
});


