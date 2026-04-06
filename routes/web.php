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

Route::get('/tax-rule-setup', 'ConfigurationController@tax_rule_setup');
Route::get('/tax-rule-setup/add', 'ConfigurationController@tax_rule_setup_add');
Route::post('/tax-rule-setup/add', 'ConfigurationController@tax_rule_setup_add');
Route::get('/tax-rule-setup/update/{id}', 'ConfigurationController@tax_rule_setup_update');
Route::post('/tax-rule-setup/update/{id}', 'ConfigurationController@tax_rule_setup_update');
Route::get('/tax-rule-setup/delete/{id}', 'ConfigurationController@tax_rule_setup_delete');

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

Route::get('/verticals', 'MasterSetupController@vertical_index');
Route::post('/verticals/add', 'MasterSetupController@vertical_add');
Route::get('/verticals/get/{id}', 'MasterSetupController@vertical_get');
Route::post('/verticals/update/{id}', 'MasterSetupController@vertical_update');
Route::get('/verticals/delete/{id}', 'MasterSetupController@vertical_delete');

Route::get('/sections', 'MasterSetupController@section_index');
Route::post('/sections/add', 'MasterSetupController@section_add');
Route::get('/sections/get/{id}', 'MasterSetupController@section_get');
Route::post('/sections/update/{id}', 'MasterSetupController@section_update');
Route::get('/sections/delete/{id}', 'MasterSetupController@section_delete');

Route::get('/job-levels', 'MasterSetupController@job_level_index');
Route::post('/job-levels/add', 'MasterSetupController@job_level_add');
Route::get('/job-levels/get/{id}', 'MasterSetupController@job_level_get');
Route::post('/job-levels/update/{id}', 'MasterSetupController@job_level_update');
Route::get('/job-levels/delete/{id}', 'MasterSetupController@job_level_delete');

Route::get('/designations', 'MasterSetupController@designation_index');
Route::post('/designations/add', 'MasterSetupController@designation_add');
Route::get('/designations/get/{id}', 'MasterSetupController@designation_get');
Route::post('/designations/update/{id}', 'MasterSetupController@designation_update');
Route::get('/designations/delete/{id}', 'MasterSetupController@designation_delete');

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

Route::get('/employee/cv-delete/{employee_id}/{cv_name}', 'EmployeeController@cv_delete');

Route::get('employee/update/{page}/{employee_id}', 'EmployeeController@update');
Route::post('employee/update-personal-info/{employee_id}', 'EmployeeController@update_personal_info');
Route::post('employee/update-employment-info/{info_id?}', 'EmployeeController@update_employment_info');
Route::post('employee/update-payroll-info/{employee_id?}', 'EmployeeController@update_payroll_info');
Route::post('employee/update-leave-info/{employee_id?}', 'EmployeeController@update_leave_info');


// Payroll Setup
Route::get('/salary-components', 'SalaryController@component_index');
Route::get('/salary-components/add', 'SalaryController@component_add');
Route::post('/salary-components/add', 'SalaryController@component_add');
Route::get('/salary-components/update/{id}', 'SalaryController@component_update');
Route::post('/salary-components/update/{id}', 'SalaryController@component_update');
Route::get('/salary-components/delete/{id}', 'SalaryController@component_delete');
Route::get('/component-reference/{component_id}', 'SalaryController@component_reference');

Route::get('/payroll-banks', 'PayrollController@bank_index');
Route::post('/payroll-banks/add', 'PayrollController@bank_add');
Route::get('/payroll-banks/get/{id}', 'PayrollController@bank_get');
Route::post('/payroll-banks/update/{id}', 'PayrollController@bank_update');
Route::get('/payroll-banks/delete/{id}', 'PayrollController@bank_delete');


Route::get('/salary-transfer-letter-format', 'SalaryTransferLetterController@format');
Route::post('/salary-transfer-letter-format', 'SalaryTransferLetterController@format');

Route::get('/ot-transfer-letter-format', 'PayrollController@ot_transfer_letter_format');
Route::post('/ot-transfer-letter-format', 'PayrollController@ot_transfer_letter_format');





Route::get('/absent-deduction', 'PayrollController@absent_deduction_index');
Route::get('/absent-deduction/create', 'PayrollController@absent_deduction_create');
Route::post('/absent-deduction/create', 'PayrollController@absent_deduction_create');
Route::post('/store-absent-deduction', 'PayrollController@absent_deduction_store');
Route::get('/absent-deduction/delete/{id}', 'PayrollController@absent_deduction_delete');
Route::get('/absent-deduction/update/{id}', 'PayrollController@absent_deduction_update');
Route::post('/absent-deduction/update/{id}', 'PayrollController@absent_deduction_update');

Route::get('/company-pf', 'PayrollController@company_pf_index');
Route::get('/company-pf-create', 'PayrollController@company_pf_create');
Route::post('/company-pf-create', 'PayrollController@company_pf_create');
Route::post('/store-company-pf', 'PayrollController@company_pf_store');
Route::get('/company-pf/delete/{id}', 'PayrollController@company_pf_delete');
Route::get('/company-pf/update/{id}', 'PayrollController@company_pf_update');
Route::post('/company-pf/update/{id}', 'PayrollController@company_pf_update');

Route::get('/pf-pay', 'PayrollController@pf_pay_index');
Route::post('/pf-pay', 'PayrollController@pf_pay_index');
Route::get('/pf-pay-store/{id}', 'PayrollController@pf_pay_store');

Route::get('/gratuity', 'PayrollController@gratuity_index');
Route::get('/gratuity-create', 'PayrollController@gratuity_create');
Route::post('/gratuity-create', 'PayrollController@gratuity_create');
Route::post('/store-gratuity', 'PayrollController@gratuity_store');
Route::get('/gratuity-pay', 'PayrollController@gratuity_pay_index');
Route::post('/gratuity-pay', 'PayrollController@gratuity_pay_index');
Route::get('/gratuity-pay-store/{id}', 'PayrollController@gratuity_pay_store');
Route::get('/gratuity/delete/{id}', 'PayrollController@gratuity_delete');
Route::get('/gratuity/update/{id}', 'PayrollController@gratuity_update');
Route::post('/gratuity/update/{id}', 'PayrollController@gratuity_update');

//Configuration
Route::get('/general-settings', 'ConfigurationController@general_setting');
Route::post('/general-settings/update', 'ConfigurationController@general_setting_update');

Route::get('/sms-settings', 'ConfigurationController@sms_index');
Route::get('/sms-settings/add', 'ConfigurationController@sms_settings_add');
Route::get('/sms-settings/delete/{id}', 'ConfigurationController@sms_settings_delete');
Route::get('/sms-settings/update/{id}', 'ConfigurationController@sms_settings_update');
Route::post('/sms-settings-submit', 'ConfigurationController@sms_settings_submit');

Route::get('/sms-balance', 'ConfigurationController@sms_balance');
Route::get('/sms-balance/update/{setup_id}', 'ConfigurationController@sms_balance_update');
Route::post('/sms-balance/update/{setup_id}', 'ConfigurationController@sms_balance_update');

//SMS Campaign
Route::get('/create-campaign', 'PayrollController@create_campaign');
Route::post('/create-campaign-post', 'PayrollController@create_campaign_post');
Route::get('campaign-receivers/{campaign_id}', 'PayrollController@campaign_receivers');
Route::post('campaign-update', 'PayrollController@campaign_update');
Route::get('campaign-duplicate/{campaign_id}', 'PayrollController@campaign_duplicate');
Route::get('campaign/delete/{id}', 'PayrollController@delete_campaign');
Route::get('send-sms/{campaign_id}/{api_id}', 'PayrollController@send_sms');
Route::get('ajax-send-sms/{sl}/{send_per_sms}/{campaign_id}/{api_id}', 'PayrollController@ajax_send_sms');
Route::get('ajax-send-pay-slip/{sl}/{month}/{year}', 'SalarySheetController@ajax_send_pay_slip');

Route::get('/smtp-settings', 'ConfigurationController@mail_setup');
Route::post('/mail-setup/update', 'ConfigurationController@mail_setup_update');

//Common Route
Route::get('/search-employee/{department_id}', 'EmployeeController@search_employee');
Route::get('/search-increment-employee_id/{department_id}/{component_id?}', 'EmployeeController@search_employee_increment_id');

Route::get('/search-employee-with-designation/{department_id}/{designation_id?}', 'EmployeeController@search_employee_with_designation');
Route::get('/search-increment-employee_id-with-designation/{department_id}/{component_id?}/{designation_id?}', 'EmployeeController@search_employee_increment_id_with_designation');



//Salary Sheet
Route::get('/salary-sheet','SalarySheetController@index');
Route::get('/salary-sheet-print','SalarySheetController@print_salary_sheet');
Route::get('/salary-sheet/create','SalarySheetController@add');
Route::post('/salary-sheet/create','SalarySheetController@add');
Route::get('/salary-sheet-details/{month}/{year}','SalarySheetController@details');
Route::post('/salary-sheet-details/{month}/{year}','SalarySheetController@details');
Route::get('/salary-sheet/details/{employee_id}/{month}/{year}','SalarySheetController@single_employee_details');
Route::get('/salary-sheet-details-print/{employee_id}/{month}/{year}','SalarySheetController@single_employee_details_print');
Route::get('/mail-pay-slip-single-employee/{employee_id}/{month}/{year}','SalarySheetController@single_employee_details_mail');

Route::get('/mail-pay-slip/{month}/{year}','SalarySheetController@mail_pay_slip');

//Salary Transfer Letter
Route::get('/salary-transfer-letter','SalaryTransferLetterController@transfer_letter');
Route::get('/salary-transfer-letter/create','SalaryTransferLetterController@transfer_letter_create');
Route::post('/salary-transfer-letter/create','SalaryTransferLetterController@transfer_letter_create');
Route::post('/store-salary-transfer-letter','SalaryTransferLetterController@transfer_letter_store');
Route::get('/salary-transfer-letter-details/{letter_id}','SalaryTransferLetterController@transfer_letter_details');
Route::get('/salary-transfer-letter-reprint/{letter_id}','SalaryTransferLetterController@transfer_letter_reprint');



//Deposit Salary Tax
Route::get('/deposit-salary-tax','PayrollController@deposit_salary_tax');
Route::get('/deposit-salary-tax/add','PayrollController@deposit_salary_tax_add');
Route::post('/deposit-salary-tax/add','PayrollController@deposit_salary_tax_add');
Route::get('/deposit-salary-tax-update/{id}','PayrollController@deposit_salary_tax_update');
Route::post('/deposit-salary-tax-update-post/{id}','PayrollController@deposit_salary_tax_update_post');
Route::get('/deposit-salary-tax/{status}/{id}','PayrollController@deposit_salary_tax_status');
Route::get('/deposit-salary-tax-upload_file/{id}','PayrollController@deposit_salary_tax_upload_file');
Route::post('/deposit-salary-tax-upload_file/{id}','PayrollController@deposit_salary_tax_upload_file');
Route::get('/deposit-salary-tax-print-frontside/{tax_id}','PayrollController@deposit_salary_tax_print_frontside');
Route::get('/deposit-salary-tax-print-backside/{tax_id}','PayrollController@deposit_salary_tax_print_backside');

//Report


//Payroll
Route::get('export/earning-adjustment-report', 'ReportController@export_earning_adjustment_report');
Route::get('export/deduction-adjustment-report', 'ReportController@export_deduction_adjustment_report');
Route::get('export/pf-detail-report', 'ReportController@export_pf_detail_report');
Route::get('export/pf-summary-report', 'ReportController@export_pf_summary_report');
Route::get('export/salary-sheet-report', 'ReportController@export_salary_sheet_report');
Route::get('export/salary-certificate', 'ReportController@export_salary_certificate');

Route::get('/download-file/{location}/{name}','HomeController@download_file');

Route::get('/tax-calculation','EmployeeController@tax_calculation');

Route::get('/tax-calculation-without-festival','EmployeeController@tax_calculation_without_festival');
