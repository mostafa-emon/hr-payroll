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

Route::get('/login', [ 'as' => 'login', 'uses' => 'LoginController@setLoginView']);
Route::post('auth/login', 'LoginController@getLogin');

Route::get('/qb-auth','QuickBookController@firstCall');
Route::get('/qb-auth-success','QuickBookController@processCode');
Route::get('/qb-refresh-token','QuickBookController@refreshToken');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/dashboard', 'HomeController@index');

Route::get('/company', 'CompanyController@index');
Route::post('/company/update', 'CompanyController@update');

Route::get('/company-register', 'RegisterController@register');
Route::post('/company-register', 'RegisterController@register');
Route::get('/subscription', 'CompanyController@company_list');
Route::post('/company-email-reset/{company_id}', 'CompanyController@emailReset');
Route::post('/company-password-reset/{company_id}', 'CompanyController@passwordReset');


Route::get('/company-active/{company_id}', 'CompanyController@active');
Route::get('/company-inactive/{company_id}', 'CompanyController@inactive');
Route::post('/company-renew/{company_id}', 'CompanyController@renew');

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

Route::get('/voucher-formats', 'VourcherFormatController@index');
Route::get('/voucher-formats/add', 'VourcherFormatController@add');
Route::get('/voucher-formats/add/{type}', 'VourcherFormatController@add');
Route::post('/voucher-formats/add', 'VourcherFormatController@add');
Route::get('/voucher-formats/delete/{format_id}', 'VourcherFormatController@delete');
Route::get('/voucher-formats/update/{format_id}', 'VourcherFormatController@update');
Route::post('/voucher-formats/update/{format_id}', 'VourcherFormatController@update');


Route::get('/cheque-layouts', 'ChequeLayoutController@index');
Route::get('/cheque-layouts/add', 'ChequeLayoutController@add');
Route::post('/cheque-layouts/add', 'ChequeLayoutController@add');
Route::get('/cheque-layouts/delete/{cheque_layouts_id}', 'ChequeLayoutController@delete');
Route::get('/cheque-layouts/update/{cheque_layouts_id}', 'ChequeLayoutController@update');
Route::post('/cheque-layouts/update/{cheque_layouts_id}', 'ChequeLayoutController@update');
Route::get('/cheque-layouts/duplicate/{cheque_layouts_id}', 'ChequeLayoutController@duplicate');
Route::post('/cheque-layouts/duplicate/{cheque_layouts_id}', 'ChequeLayoutController@duplicate');

Route::get('/cheque-transactions', 'ChequeTransactionController@index');
Route::post('/cheque-transactions/add', 'ChequeTransactionController@add');
Route::get('/cheque-transactions/add/{bank_id?}', 'ChequeTransactionController@add');
Route::get('/get-cheque-book-by-account/{account_id}', 'ChequeTransactionController@get_cheque_book_by_account');
Route::get('/get-account-currency/{account_id}', 'ChequeTransactionController@get_currency_by_account');
Route::get('/get-cheques-by-book/{book_id}', 'ChequeTransactionController@get_cheques_by_book');

Route::get('/currency', 'ConfigurationController@index_currency');
Route::get('/currency/add', 'ConfigurationController@add_currency');
Route::post('/currency/add', 'ConfigurationController@add_currency');
Route::get('/currency/delete/{currency_id}', 'ConfigurationController@delete_currency');
Route::get('/currency/update/{currency_id}', 'ConfigurationController@update_currency');
Route::post('/currency/update/{currency_id}', 'ConfigurationController@update_currency');

Route::get('/mr', 'MRController@index');
Route::get('/mr/add', 'MRController@add');
Route::post('/mr/add', 'MRController@add');
Route::get('/mr/print/{id}', 'MRController@print');
Route::get('/approve-mr/{mr_id}', 'MRController@approve');
Route::get('/reject-mr/{mr_id}', 'MRController@reject');
Route::get('/void-mr/{mr_id}', 'MRController@void');
Route::get('/mr/print/{id}', 'MRController@print');
Route::get('/mr/draft/{id}', 'MRController@draft');

Route::get('/audits', 'ReportController@audits');
Route::post('/audits', 'ReportController@audits');

Route::get('/issued-mr', 'ReportController@issued_mr');
Route::post('/issued-mr', 'ReportController@issued_mr');
Route::get('/void-mr', 'ReportController@void_mr');
Route::post('/void-mr', 'ReportController@void_mr');

Route::get('/issued-cheque', 'ReportController@issued_cheque');
Route::post('/issued-cheque', 'ReportController@issued_cheque');
Route::get('/void-cheque', 'ReportController@void_cheque');
Route::post('/void-cheque', 'ReportController@void_cheque');

Route::get('/issued-voucher', 'ReportController@issued_voucher');
Route::post('/issued-voucher', 'ReportController@issued_voucher');
Route::get('/void-voucher', 'ReportController@void_voucher');
Route::post('/void-voucher', 'ReportController@void_voucher');

Route::get('/export-issued-voucher', 'ReportController@export_issued_voucher');
Route::get('/export-void-voucher', 'ReportController@export_void_voucher');
Route::get('/export-issued-mr', 'ReportController@export_issued_mr');
Route::get('/export-void-mr', 'ReportController@export_void_mr');
Route::get('/export-issued-cheque', 'ReportController@export_issued_cheque');
Route::get('/export-void-cheque', 'ReportController@export_void_cheque');

Route::get('/approve-cheque/{cheque_id}', 'ChequeTransactionController@approve');
Route::get('/reject-cheque/{cheque_id}', 'ChequeTransactionController@reject');
Route::get('/void-cheque/{cheque_id}', 'ChequeTransactionController@void');
Route::get('/cheque/print/{id}', 'ChequeTransactionController@print');
Route::get('/cheque/draft/{id}', 'ChequeTransactionController@draft');

Route::get('/user', 'UserController@index');
Route::get('/user/add', 'UserController@add');
Route::post('/user/add', 'UserController@add');
Route::get('/user/delete/{user_id}', 'UserController@delete');
Route::get('/user/update/{user_id}', 'UserController@update');
Route::post('/user/update/{user_id}', 'UserController@update');
Route::get('/user/profile/{user_id}', 'UserController@profile');
Route::post('/user/profile/{user_id}', 'UserController@profile');

Route::get('/roles', 'RolesController@index');
Route::get('/roles/add', 'RolesController@add');
Route::post('/roles/add', 'RolesController@add');
Route::get('/roles/delete/{role_id}', 'RolesController@delete');
Route::get('/roles/update/{role_id}', 'RolesController@update');
Route::post('/roles/update/{role_id}', 'RolesController@update');

Route::get('/settings', 'ConfigurationController@index');
Route::post('/settings/update', 'ConfigurationController@update');

Route::get('/printer', 'ConfigurationController@index_printer');
Route::get('/printer/add', 'ConfigurationController@add_printer');
Route::post('/printer/add', 'ConfigurationController@add_printer');
Route::get('/printer/delete/{printer_id}', 'ConfigurationController@delete_printer');
Route::get('/printer/update/{printer_id}', 'ConfigurationController@update_printer');
Route::post('/printer/update/{printer_id}', 'ConfigurationController@update_printer');

Route::get('/404', 'HomeController@pageNotFound');
Route::get('/logout', 'HomeController@logout');

Route::get('/signatory', 'SignatoryController@index');
Route::get('/signatory/add', 'SignatoryController@add');
Route::post('/signatory/add', 'SignatoryController@add');
Route::get('/signatory/delete/{signatory_id}', 'SignatoryController@delete');
Route::get('/signatory/update/{signatory_id}', 'SignatoryController@update');
Route::post('/signatory/update/{signatory_id}', 'SignatoryController@update');

Route::get('/tr-cash-payment-voucher', 'CashPaymentVoucherController@index');
Route::post('/tr-cash-payment-voucher', 'CashPaymentVoucherController@index');

Route::get('/tr-bank-payment-voucher', 'BankPaymentVoucherController@index');
Route::post('/tr-bank-payment-voucher', 'BankPaymentVoucherController@index');

Route::get('/tr-cash-receipt-voucher', 'VoucherController@cash_receipt');
Route::get('/tr-bank-receipt-voucher', 'VoucherController@bank_receipt');

Route::get('/tr-void-voucher', 'LocalVoucherController@void_voucher');
Route::get('/tr-void-voucher-add', 'LocalVoucherController@add_void_voucher');
Route::post('/tr-void-voucher-add', 'LocalVoucherController@add_void_voucher');
Route::get('/make-void/{voucher_id}', 'LocalVoucherController@make_void');

Route::get('/tr-contra-voucher', 'ContraVoucherController@index');
Route::post('/tr-contra-voucher', 'ContraVoucherController@index');

Route::get('/tr-journal-voucher', 'JournalVoucherController@index');
Route::post('/tr-journal-voucher', 'JournalVoucherController@index');

Route::get('/cpv-voucher-preview/{print_status}/{api_type}/{id}', 'CashPaymentVoucherController@preview');
Route::get('/bpv-voucher-preview/{print_status}/{api_type}/{id}', 'BankPaymentVoucherController@preview');
Route::get('/contra-voucher-preview/{print_status}/{api_type}/{id}', 'ContraVoucherController@preview');

Route::get('/voucher-print/{voucher_type}/{format_id}/{voucher_id}', 'LocalVoucherController@print');

Route::get('/create-mr', 'MRController@create_mr');
Route::get('/create-cheque', 'MRController@create_cheque');

Route::post('/voucher/add', 'LocalVoucherController@add_voucher');