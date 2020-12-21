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
Route::get('employee/add/{page}/{employee_id?}', 'EmployeeController@add');
Route::post('employee/add-personal-info', 'EmployeeController@add_personal_info');
Route::post('employee/add-employment-info', 'EmployeeController@add_employment_info');
Route::post('employee/add-payroll-info', 'EmployeeController@add_payroll_info');
Route::post('employee/add-leave-info', 'EmployeeController@add_leave_info');
Route::get('/employee/delete/{id}', 'EmployeeController@delete');

Route::get('employee/update/{page}/{employee_id}', 'EmployeeController@update');
Route::post('employee/update-personal-info/{employee_id}', 'EmployeeController@update_personal_info');
Route::post('employee/update-employment-info/{info_id?}', 'EmployeeController@update_employment_info');
Route::post('employee/update-payroll-info/{employee_id?}', 'EmployeeController@update_payroll_info');
Route::post('employee/update-leave-info/{employee_id?}', 'EmployeeController@update_leave_info');

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

// Payroll Setup
Route::get('/salary-components', 'SalaryController@component_index');
Route::get('/salary-components/add', 'SalaryController@component_add');
Route::post('/salary-components/add', 'SalaryController@component_add');
Route::get('/salary-components/update/{id}', 'SalaryController@component_update');
Route::post('/salary-components/update/{id}', 'SalaryController@component_update');
Route::get('/salary-components/delete/{id}', 'SalaryController@component_delete');

Route::get('/payroll-banks', 'PayrollController@bank_index');
Route::post('/payroll-banks/add', 'PayrollController@bank_add');
Route::get('/payroll-banks/get/{id}', 'PayrollController@bank_get');
Route::post('/payroll-banks/update/{id}', 'PayrollController@bank_update');
Route::get('/payroll-banks/delete/{id}', 'PayrollController@bank_delete');
Route::get('/payroll-banks/branch/{type_id}', 'PayrollController@branch_index');
Route::post('/payroll-banks/branch/add', 'PayrollController@branch_add');
Route::get('/payroll-banks/branch/get/{id}', 'PayrollController@branch_get');
Route::post('/payroll-banks/branch/update/{id}', 'PayrollController@branch_update');
Route::get('/payroll-banks/branch/delete/{id}', 'PayrollController@branch_delete');
Route::get('/get-payroll-branch/{id}', 'PayrollController@get_branch');

Route::get('/salary-transfer-letter-format', 'SalaryTransferLetter@format');
Route::post('/salary-transfer-letter-format', 'SalaryTransferLetter@format');

//Leave
Route::get('/leave-request', 'LeaveController@leave_request_index');
Route::get('/leave-request/add', 'LeaveController@leave_request_add');
Route::post('/leave-request/add', 'LeaveController@leave_request_add');
Route::get('/leave-request/update/{request_type}/{id}', 'LeaveController@leave_request_update');
Route::post('/leave-request/update/{request_type}/{id}', 'LeaveController@leave_request_update');
Route::get('/leave-request/delete/{id}', 'LeaveController@leave_request_delete');

Route::get('/verify-leave-request', 'LeaveController@verify_leave_request');
Route::get('/leave-request/verify/{id}', 'LeaveController@leave_request_verify');
Route::get('/leave-request/reject/{id}', 'LeaveController@leave_request_reject');
Route::get('/leave-request/approve/{id}', 'LeaveController@leave_request_approve');

Route::get('/approve-leave-request', 'LeaveController@approve_leave_request');

Route::get('/leave-balance-transfer', 'LeaveController@leave_balance_transfer');
Route::post('/leave-balance-transfer', 'LeaveController@leave_balance_transfer');
Route::post('/transfer-leave-balance/{id}', 'LeaveController@transfer_leave_balance');

// Attendance
Route::get('/roster', 'AttendanceController@roster_index');
Route::get('/create-roster', 'AttendanceController@roster_create');
Route::post('/create-roster', 'AttendanceController@roster_create');
Route::post('/store-roster', 'AttendanceController@roster_store');
Route::get('/roster-duplicate/{id}', 'AttendanceController@roster_duplicate');
Route::get('/roster/delete/{id}', 'AttendanceController@roster_delete');
Route::get('/roster/employee-list/{id}', 'AttendanceController@roster_employee_list');
Route::get('/roster-search', 'AttendanceController@roster_search');
Route::post('/roster-search', 'AttendanceController@roster_search');
Route::get('/roster-employee/delete/{id}', 'AttendanceController@roster_employee_delete');
Route::get('/roster-employee/update/{id}', 'AttendanceController@roster_employee_update');
Route::post('/roster-employee/update/{id}', 'AttendanceController@roster_employee_update');

//Payroll
Route::get('/earnings-adjustment', 'AttendanceController@earnings_adjustment_index');
Route::get('/earnings-adjustment/create', 'AttendanceController@earnings_adjustment_create');
Route::post('/earnings-adjustment/create-post', 'AttendanceController@earnings_adjustment_create_post');
Route::get('/earnings-adjustment/{status}/{id}', 'AttendanceController@earnings_adjustment_status');
Route::get('/earning-adjustment/delete/{id}', 'AttendanceController@earnings_adjustment_delete');
Route::get('/earnings-adjustment-update/{id}', 'AttendanceController@earnings_adjustment_update');
Route::get('/earnings-adjustment-view/{id}', 'AttendanceController@earnings_adjustment_view');
Route::get('/earnings-adjustment-print/{id}', 'AttendanceController@earnings_adjustment_print');

Route::get('/deductions-adjustment', 'AttendanceController@deductions_adjustment_index');
Route::get('/deductions-adjustment/create', 'AttendanceController@deductions_adjustment_create');
Route::post('/deductions-adjustment/create-post', 'AttendanceController@deductions_adjustment_create_post');
Route::get('/deductions-adjustment/{status}/{id}', 'AttendanceController@deductions_adjustment_status');
Route::get('/deduction-adjustment/delete/{id}', 'AttendanceController@deductions_adjustment_delete');
Route::get('/deduction-adjustment/update/{id}', 'AttendanceController@deductions_adjustment_update');
Route::get('/deductions-adjustment-view/{id}', 'AttendanceController@deductions_adjustment_view');
Route::get('/deductions-adjustment-print/{id}', 'AttendanceController@deductions_adjustment_print');

Route::get('/search-employee/{department_id}/{project_id?}/{branch_id?}', 'EmployeeController@search_employee');
Route::get('/search-increment-employee_id/{department_id}/{project_id?}/{branch_id?}/{component_id?}', 'EmployeeController@search_employee_increment_id');