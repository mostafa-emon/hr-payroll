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
Route::get('/home', 'HomeController@index');
Route::get('/dashboard', 'HomeController@index');

Route::get('/company', 'CompanyController@index');
Route::post('/company/update', 'CompanyController@update');

Route::get('/site-office', 'SiteOfficeController@index');
Route::get('/site-office/add', 'SiteOfficeController@add');
Route::post('/site-office/add', 'SiteOfficeController@add');
Route::get('/site-office/delete/{siteoffice_id}', 'SiteOfficeController@delete');
Route::get('/site-office/update/{siteoffice_id}', 'SiteOfficeController@update');
Route::post('/site-office/update/{siteoffice_id}', 'SiteOfficeController@update');

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

Route::get('/bank', 'BankController@index');
Route::get('/bank/add', 'BankController@add');
Route::post('/bank/add', 'BankController@add');
Route::get('/bank/delete/{bank_id}', 'BankController@delete');
Route::get('/bank/update/{bank_id}', 'BankController@update');
Route::post('/bank/update/{bank_id}', 'BankController@update');

Route::get('/currency', 'ConfigurationController@index_currency');
Route::get('/currency/add', 'ConfigurationController@add_currency');
Route::post('/currency/add', 'ConfigurationController@add_currency');
Route::get('/currency/delete/{currency_id}', 'ConfigurationController@delete_currency');
Route::get('/currency/update/{currency_id}', 'ConfigurationController@update_currency');
Route::post('/currency/update/{currency_id}', 'ConfigurationController@update_currency');

Route::get('/payment-method', 'ConfigurationController@index_paymentmethod');
Route::get('/payment-method/add', 'ConfigurationController@add_paymentmethod');
Route::post('/payment-method/add', 'ConfigurationController@add_paymentmethod');
Route::get('/payment-method/delete/{paymentmethod_id}', 'ConfigurationController@delete_paymentmethod');
Route::get('/payment-method/update/{paymentmethod_id}', 'ConfigurationController@update_paymentmethod');
Route::post('/payment-method/update/{paymentmethod_id}', 'ConfigurationController@update_paymentmethod');

Route::get('/logout', 'HomeController@logout');
