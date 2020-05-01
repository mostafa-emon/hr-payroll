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


Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/dashboard', 'HomeController@index');

Route::get('/customer', 'CustomerController@index');
Route::get('/customer/add', 'CustomerController@add');
Route::post('/customer/add', 'CustomerController@add');
Route::get('/customer/delete/{customer_id}', 'CustomerController@delete');
Route::get('/customer/update/{customer_id}', 'CustomerController@update');
Route::post('/customer/update/{customer_id}', 'CustomerController@update');

Route::get('/supplier', 'SupplierController@index');
Route::get('/supplier/add', 'SupplierController@add');
Route::post('/supplier/add', 'SupplierController@add');
Route::get('/supplier/delete/{supplier_id}', 'SupplierController@delete');
Route::get('/supplier/update/{supplier_id}', 'SupplierController@update');
Route::post('/supplier/update/{supplier_id}', 'SupplierController@update');

Route::get('/logout', 'HomeController@logout');
