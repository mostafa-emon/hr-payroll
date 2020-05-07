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

Route::get('/bank-account', 'BankAccountController@index');
Route::get('/bank-account/add', 'BankAccountController@add');
Route::post('/bank-account/add', 'BankAccountController@add');
Route::get('/bank-account/delete/{bankaccount_id}', 'BankAccountController@delete');
Route::get('/bank-account/update/{bankaccount_id}', 'BankAccountController@update');
Route::post('/bank-account/update/{bankaccount_id}', 'BankAccountController@update');
Route::get('/get-account-by-bank/{bank_id}', 'BankAccountController@get_account_by_bank');

Route::get('/cheque-books', 'ChequeBookController@index');
Route::get('/cheque-books/add', 'ChequeBookController@add');
Route::post('/cheque-books/add', 'ChequeBookController@add');
Route::get('/cheque-books/delete/{cheque_book_id}', 'ChequeBookController@delete');
Route::get('/cheque-books/update/{cheque_book_id}', 'ChequeBookController@update');
Route::post('/cheque-books/update/{cheque_book_id}', 'ChequeBookController@update');

Route::get('/cheque-layouts', 'ChequeLayoutController@index');
Route::get('/cheque-layouts/add', 'ChequeLayoutController@add');
Route::post('/cheque-layouts/add', 'ChequeLayoutController@add');
Route::get('/cheque-layouts/delete/{cheque_layouts_id}', 'ChequeLayoutController@delete');
Route::get('/cheque-layouts/update/{cheque_layouts_id}', 'ChequeLayoutController@update');
Route::post('/cheque-layouts/update/{cheque_layouts_id}', 'ChequeLayoutController@update');
Route::get('/cheque-layouts/duplicate/{cheque_layouts_id}', 'ChequeLayoutController@duplicate');
Route::post('/cheque-layouts/duplicate/{cheque_layouts_id}', 'ChequeLayoutController@duplicate');

Route::get('/cheque-transactions', 'ChequeTransactionController@index');
Route::get('/cheque-transactions/add/{bank_id?}', 'ChequeTransactionController@add');
Route::get('/get-cheque-book-by-account/{account_id}', 'ChequeTransactionController@get_cheque_book_by_account');
Route::get('/get-cheques-by-book/{book_id}', 'ChequeTransactionController@get_cheques_by_book');

Route::get('/user', 'UserController@index');
Route::get('/user/add', 'UserController@add');
Route::post('/user/add', 'UserController@add');
Route::get('/user/delete/{user_id}', 'UserController@delete');
Route::get('/user/update/{user_id}', 'UserController@update');
Route::post('/user/update/{user_id}', 'UserController@update');
Route::get('/user/profile/{user_id}', 'UserController@profile');
Route::post('/user/profile/{user_id}', 'UserController@profile');

Route::get('/currency', 'ConfigurationController@index_currency');
Route::get('/currency/add', 'ConfigurationController@add_currency');
Route::post('/currency/add', 'ConfigurationController@add_currency');
Route::get('/currency/delete/{currency_id}', 'ConfigurationController@delete_currency');
Route::get('/currency/update/{currency_id}', 'ConfigurationController@update_currency');
Route::post('/currency/update/{currency_id}', 'ConfigurationController@update_currency');

Route::get('/payment-method', 'ConfigurationController@index_payment_method');
Route::get('/payment-method/add', 'ConfigurationController@add_payment_method');
Route::post('/payment-method/add', 'ConfigurationController@add_payment_method');
Route::get('/payment-method/delete/{paymentmethod_id}', 'ConfigurationController@delete_payment_method');
Route::get('/payment-method/update/{paymentmethod_id}', 'ConfigurationController@update_payment_method');
Route::post('/payment-method/update/{paymentmethod_id}', 'ConfigurationController@update_payment_method');

Route::get('/settings', 'ConfigurationController@index');
Route::post('/settings/update', 'ConfigurationController@update');

Route::get('/printer', 'ConfigurationController@index_printer');
Route::get('/printer/add', 'ConfigurationController@add_printer');
Route::post('/printer/add', 'ConfigurationController@add_printer');
Route::get('/printer/delete/{printer_id}', 'ConfigurationController@delete_printer');
Route::get('/printer/update/{printer_id}', 'ConfigurationController@update_printer');
Route::post('/printer/update/{printer_id}', 'ConfigurationController@update_printer');

Route::get('/logout', 'HomeController@logout');
