<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),
    
    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */
    'roles' => [
        //All Module
        'company_info_read'                     => 1,
        'company_info_update'                   => 2,

        'department_read'                       => 3,
        'department_add'                        => 4,
        'department_update'                     => 5,
        'department_delete'                     => 6,

        'designation_read'                      => 7,
        'designation_add'                       => 8,
        'designation_update'                    => 9,
        'designation_delete'                    => 10,

        'project_read'                          => 11,
        'project_add'                           => 12,
        'project_update'                        => 13,
        'project_delete'                        => 14,

        'branch_read'                           => 15,
        'branch_add'                            => 16,
        'branch_update'                         => 17,
        'branch_delete'                         => 18,

        'currency_read'                         => 19,
        'currency_add'                          => 20,
        'currency_update'                       => 21,
        'currency_delete'                       => 22,

        'employee_read'                         => 23,
        'employee_add'                          => 24,
        'employee_update'                       => 25,
        'employee_delete'                       => 26,

        'role_read'                             => 27,
        'role_add'                              => 28,
        'role_update'                           => 29,
        'role_delete'                           => 30,

        'user_read'                             => 31,
        'user_add'                              => 32,
        'user_update'                           => 33,
        'user_delete'                           => 34,

        'leave_type_read'                       => 35,
        'leave_type_add'                        => 36,
        'leave_type_update'                     => 37,
        'leave_type_delete'                     => 38,

        'employee_list_report'                  => 39,
        'inactive_employee_list_report'         => 40,
        'employee_cv_report'                    => 41,

        'general_settings'                      => 42,

        'tax_rule_setup'                        => 43,

        'sms_settings_read'                     => 44,
        'sms_settings_add'                      => 45,
        'sms_settings_update'                   => 46,
        'sms_settings_delete'                   => 47,

        'sms_balance'                           => 48,

        'smtp_settings_read'                    => 49,
        'smtp_settings_update'                  => 50,
        'smtp_settings_sent'                    => 51,

        //All Module End

        //Attendance
        'shift_read'                            => 51,
        'shift_add'                             => 52,
        'shift_update'                          => 53,
        'shift_delete'                          => 54,

        'govt_holiday_read'                     => 55,
        'govt_holiday_add'                      => 56,
        'govt_holiday_update'                   => 57,
        'govt_holiday_delete'                   => 58,

        'attendance_policy_update'              => 59,

        'roster_read'                           => 60,
        'roster_add'                            => 61,
        'roster_update'                         => 62,
        'roster_delete'                         => 63,

        'manual_log_entry_read'                 => 64,
        'manual_log_entry_add'                  => 65,
        'manual_log_entry_update'               => 66,
        'manual_log_entry_delete'               => 67,

        'daily_attendance_report'               => 68,
        'attendance_summary_all_report'         => 69,
        'attendance_summary_single_report'      => 70,
        'daily_late_report'                     => 71,
        'late_individual_report'                => 72,
        'daily_absent_report'                   => 73,
        'absent_single_report'                  => 74,
        'ot_summary_report'                     => 75,
        'ot_individual_report'                  => 76,

        //Attendance End

        //Payroll
        'salary_component_read'                 => 81,
        'salary_component_add'                  => 82,
        'salary_component_update'               => 83,
        'salary_component_delete'               => 84,

        'salary_transfer_letter_format'         => 85,
        'ot_transfer_letter_format'             => 86,

        'payroll_bank_read'                     => 87,
        'payroll_bank_add'                      => 88,
        'payroll_bank_update'                   => 89,
        'payroll_bank_delete'                   => 90,

        'create_earning_adjustment_read'        => 91,
        'create_earning_adjustment_add'         => 92,
        'create_earning_adjustment_update'      => 93,
        'create_earning_adjustment_delete'      => 94,
        'create_earning_adjustment_print'       => 95,

        'create_deduction_adjustment_read'      => 96,
        'create_deduction_adjustment_add'       => 97,
        'create_deduction_adjustment_update'    => 98,
        'create_deduction_adjustment_delete'    => 99,
        'create_deduction_adjustment_print'     => 100,

        'absent_deduction_read'                 => 101,
        'absent_deduction_add'                  => 102,
        'absent_deduction_update'               => 103,
        'absent_deduction_delete'               => 104,

        'create_salary_sheet_read'              => 105,
        'create_salary_sheet_add'               => 106,
        'create_salary_sheet_update'            => 107,
        'create_salary_sheet_delete'            => 108,
        'create_salary_sheet_send'              => 109,
        'create_salary_sheet_print'             => 110,

        'create_salary_transfer_letter_read'    => 111,
        'create_salary_transfer_letter_add'     => 112,

        'create_ot_transfer_letter_read'        => 113,
        'create_ot_transfer_letter_add'         => 114,

        'create_company_pf_read'                => 115,
        'create_company_pf_add'                 => 116,
        'create_company_pf_update'              => 117,
        'create_company_pf_delete'              => 118,

        'deposit_salary_tax_read'               => 119,
        'deposit_salary_tax_add'                => 120,
        'deposit_salary_tax_update'             => 121,
        'deposit_salary_tax_delete'             => 122,
        'deposit_salary_tax_print'              => 123,

        'pay_pf_read'                           => 124,
        'pay_pf_add'                            => 125,
        'pay_pf_print'                          => 126,

        'sms_campaign_read'                     => 127,
        'sms_campaign_add'                      => 128,
        'sms_campaign_update'                   => 129,
        'sms_campaign_delete'                   => 130,
        'sms_campaign_send'                     => 131,

        'gratuity_read'                         => 132,
        'gratuity_add'                          => 133,
        'gratuity_update'                       => 134,
        'gratuity_delete'                       => 135,

        'post_jv_quickbooks'                    => 136,

        'earning_adjustment_report'             => 137,
        'deduction_adjustment_report'           => 138,
        '108_summary_report'                    => 139,
        'pf_summary_report'                     => 140,
        'pf_detail_report'                      => 141,
        'salary_sheet_report'                   => 142,
        'payslip_report'                        => 143,
        'email_payslip_report'                  => 144,
        'salary_transfer_letter_report'         => 145,
        'salary_certificate_report'             => 146,
        'audit_trail_report'                    => 147,

        //Payroll End

        //Leave
        'create_leave_request'                  => 132,
        'verify_leave_request'                  => 133,
        'approve_leave_request'                 => 134,
        'leave_balance_transfer'                => 135,

        'earning_adjustment_report'             => 137,
        'deduction_adjustment_report'           => 138,
        '108_summary_report'                    => 139,

        'subscription'                          => 200
    ],

    'env' => env('APP_ENV', 'production'),
    'qb_auth_redirect_url' => env('QB_AUTH_REDIRECT_URL'),
    'money_receipt_logo_url' => env('MONEY_RECEIPT_LOGO_URL'),
    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Dhaka',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        OwenIt\Auditing\AuditingServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
    ],

];
