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

Route::get('/login', [ 'as' => 'login', 'uses' => 'LoginController@setLoginView']);
Route::post('auth/login', 'LoginController@getLogin');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/dashboard', 'HomeController@index');

Route::get('/company', 'CompanyController@index');
Route::post('/company/update', 'CompanyController@update');

Route::get('/company-register', 'RegisterController@register');
Route::post('/company-register', 'RegisterController@register');

Route::get('/subscription', 'CompanyController@company_list');
Route::get('/subscription/update/{company_id}', 'CompanyController@subscriptionUpdate');
Route::post('/subscription/update/{company_id}', 'CompanyController@subscriptionUpdate');
Route::get('/subscription/delete/{company_id}', 'CompanyController@subscriptionDelete');

Route::post('/company-email-reset/{company_id}', 'CompanyController@emailReset');
Route::post('/company-password-reset/{company_id}', 'CompanyController@passwordReset');

Route::get('/company-active/{company_id}', 'CompanyController@active');
Route::get('/company-inactive/{company_id}', 'CompanyController@inactive');
Route::post('/company-renew/{company_id}', 'CompanyController@renew');

Route::get('/currency', 'ConfigurationController@index_currency');
Route::get('/currency/add', 'ConfigurationController@add_currency');
Route::post('/currency/add', 'ConfigurationController@add_currency');
Route::get('/currency/delete/{currency_id}', 'ConfigurationController@delete_currency');
Route::get('/currency/update/{currency_id}', 'ConfigurationController@update_currency');
Route::post('/currency/update/{currency_id}', 'ConfigurationController@update_currency');

Route::get('/settings', 'ConfigurationController@index');
Route::post('/settings/update', 'ConfigurationController@update');

Route::get('/mail-setup', 'ConfigurationController@mail_setup');
Route::post('/mail-setup/update', 'ConfigurationController@mail_setup_update');

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

Route::get('/404', 'HomeController@pageNotFound');
Route::get('/logout', 'HomeController@logout');

Route::get('leftmenu-color/{color}', 'HomeController@leftmenu_color');

//Master Setup
Route::get('/departments', 'MasterSetupController@department_index');
Route::post('/departments/add', 'MasterSetupController@department_add');
Route::get('/departments/get/{id}', 'MasterSetupController@department_get');
Route::post('/departments/update/{id}', 'MasterSetupController@department_update');
Route::get('/departments/delete/{id}', 'MasterSetupController@department_delete');

Route::get('/designations', 'MasterSetupController@designation_index');
Route::post('/designations/add', 'MasterSetupController@designation_add');
Route::get('/designations/get/{id}', 'MasterSetupController@designation_get');
Route::post('/designations/update/{id}', 'MasterSetupController@designation_update');
Route::get('/designations/delete/{id}', 'MasterSetupController@designation_delete');

Route::get('/projects', 'MasterSetupController@project_index');
Route::post('/projects/add', 'MasterSetupController@project_add');
Route::get('/projects/get/{id}', 'MasterSetupController@project_get');
Route::post('/projects/update/{id}', 'MasterSetupController@project_update');
Route::get('/projects/delete/{id}', 'MasterSetupController@project_delete');

Route::get('/branches', 'MasterSetupController@branch_index');
Route::post('/branches/add', 'MasterSetupController@branch_add');
Route::get('/branches/get/{id}', 'MasterSetupController@branch_get');
Route::post('/branches/update/{id}', 'MasterSetupController@branch_update');
Route::get('/branches/delete/{id}', 'MasterSetupController@branch_delete');

Route::get('/currencies', 'MasterSetupController@currency_index');
Route::post('/currencies/add', 'MasterSetupController@currency_add');
Route::get('/currencies/get/{id}', 'MasterSetupController@currency_get');
Route::post('/currencies/update/{id}', 'MasterSetupController@currency_update');
Route::get('/currencies/delete/{id}', 'MasterSetupController@currency_delete');

Route::get('/bank-accounts', 'MasterSetupController@bank_account_index');
Route::post('/bank-accounts/add', 'MasterSetupController@bank_account_add');
Route::get('/bank-accounts/get/{id}', 'MasterSetupController@bank_account_get');
Route::post('/bank-accounts/update/{id}', 'MasterSetupController@bank_account_update');
Route::get('/bank-accounts/delete/{id}', 'MasterSetupController@bank_account_delete');

Route::get('/device-setup', 'MasterSetupController@device_index');
Route::post('/device-setup/add', 'MasterSetupController@device_add');
Route::get('/device-setup/get/{id}', 'MasterSetupController@device_get');
Route::post('/device-setup/update/{id}', 'MasterSetupController@device_update');
Route::get('/device-setup/delete/{id}', 'MasterSetupController@device_delete');

// Employee
Route::get('employee', 'EmployeeController@index');
Route::get('employee/add', 'EmployeeController@add');
Route::post('employee/add', 'EmployeeController@add');

// Leave Setup
Route::get('/leave-type', 'LeaveController@leave_type_index');
Route::post('/leave-type/add', 'LeaveController@leave_type_add');
Route::get('/leave-type/get/{id}', 'LeaveController@leave_type_get');
Route::post('/leave-type/update/{id}', 'LeaveController@leave_type_update');
Route::get('/leave-type/delete/{id}', 'LeaveController@leave_type_delete');

// Attendance Setup
Route::get('/shift', 'ShiftController@index');
Route::post('/shift/add', 'ShiftController@add');
Route::get('/shift/get/{id}', 'ShiftController@get');
Route::post('/shift/update/{id}', 'ShiftController@update');
Route::get('/shift/delete/{id}', 'ShiftController@delete');

Route::get('/govt-holiday', 'HolidayController@index');
Route::get('/govt-holiday/add', 'HolidayController@add');
Route::post('/govt-holiday/add', 'HolidayController@add');
Route::get('/govt-holiday/update/{id}', 'HolidayController@update');
Route::post('/govt-holiday/update/{id}', 'HolidayController@update');
Route::get('/govt-holiday/delete/{id}', 'HolidayController@delete');

Route::get('/attendance-policy', 'AttendanceController@index');
Route::get('/attendance-policy/add', 'AttendanceController@add');
Route::post('/attendance-policy/add', 'AttendanceController@add');
Route::get('/attendance-policy/update/{id}', 'AttendanceController@update');
Route::post('/attendance-policy/update/{id}', 'AttendanceController@update');
Route::get('/attendance-policy/delete/{id}', 'AttendanceController@delete');


