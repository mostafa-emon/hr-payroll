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
        'company_info'                          => 1,

        'department_read'                       => 2,
        'department_add'                        => 3,
        'department_update'                     => 4,
        'department_delete'                     => 5,

        'designation_read'                      => 6,
        'designation_add'                       => 7,
        'designation_update'                    => 8,
        'designation_delete'                    => 9,

        'project_read'                          => 10,
        'project_add'                           => 11,
        'project_update'                        => 12,
        'project_delete'                        => 13,

        'branch_read'                           => 14,
        'branch_add'                            => 15,
        'branch_update'                         => 16,
        'branch_delete'                         => 17,

        'currency_read'                         => 18,
        'currency_add'                          => 19,
        'currency_update'                       => 20,
        'currency_delete'                       => 21,

        'employee_read'                         => 22,
        'employee_add'                          => 23,
        'employee_update'                       => 24,
        'employee_delete'                       => 25,

        'role_read'                             => 26,
        'role_add'                              => 27,
        'role_update'                           => 28,
        'role_delete'                           => 29,

        'user_read'                             => 30,
        'user_add'                              => 31,
        'user_update'                           => 32,
        'user_delete'                           => 33,

        'leave_type_read'                       => 34,
        'leave_type_add'                        => 35,
        'leave_type_update'                     => 36,
        'leave_type_delete'                     => 37,

        'employee_list_report'                  => 38,
        'inactive_employee_list_report'         => 39,

        'general_settings'                      => 40,

        'sms_settings_read'                     => 41,
        'sms_settings_add'                      => 42,
        'sms_settings_update'                   => 43,
        'sms_settings_delete'                   => 44,

        'sms_balance_read'                      => 45,
        'sms_balance_update'                    => 46,

        'smtp_settings_read'                    => 47,
        'smtp_settings_update'                  => 48,
        'smtp_settings_sent'                    => 49,

        'employee_cv_report'                    => 50,
        'tax_rule_setup'                        => 51,

        //All Module End

        //Attendance
        'shift_read'                            => 56,
        'shift_add'                             => 57,
        'shift_update'                          => 58,
        'shift_delete'                          => 59,

        'govt_holiday_read'                     => 60,
        'govt_holiday_add'                      => 61,
        'govt_holiday_update'                   => 62,
        'govt_holiday_delete'                   => 63,

        'attendance_policy_update'              => 64,

        'roster_read'                           => 65,
        'roster_add'                            => 66,
        'roster_update'                         => 67,
        'roster_delete'                         => 68,

        'manual_log_entry_read'                 => 69,
        'manual_log_entry_add'                  => 70,
        'manual_log_entry_update'               => 71,
        //'manual_log_entry_delete'               => 72, // No Need

        'daily_attendance_report'               => 73,
        'attendance_summary_all_report'         => 74,
        'attendance_summary_single_report'      => 75,
        'daily_late_report'                     => 76,
        'late_individual_report'                => 77,
        'daily_absent_report'                   => 78,
        'absent_single_report'                  => 79,
        'ot_summary_report'                     => 80,
        'ot_individual_report'                  => 81,

        //Attendance End

        //Payroll
        'salary_component_read'                 => 91,
        'salary_component_add'                  => 92,
        'salary_component_update'               => 93,
        'salary_component_delete'               => 94,

        'salary_transfer_letter_format'         => 95,
        'ot_transfer_letter_format'             => 96,

        'payroll_bank_read'                     => 97,
        'payroll_bank_add'                      => 98,
        'payroll_bank_update'                   => 99,
        'payroll_bank_delete'                   => 100,

        'create_earning_adjustment_read'        => 101,
        'create_earning_adjustment_add'         => 102,
        'create_earning_adjustment_update'      => 103,
        'create_earning_adjustment_delete'      => 104,
        'create_earning_adjustment_print'       => 105,

        'create_deduction_adjustment_read'      => 106,
        'create_deduction_adjustment_add'       => 107,
        'create_deduction_adjustment_update'    => 108,
        'create_deduction_adjustment_delete'    => 109,
        'create_deduction_adjustment_print'     => 110,

        'absent_deduction_read'                 => 111,
        'absent_deduction_add'                  => 112,
        'absent_deduction_update'               => 113,
        'absent_deduction_delete'               => 114,

        'create_salary_sheet_read'              => 115,
        'create_salary_sheet_add'               => 116,
        //'create_salary_sheet_update'            => 117,  //No Need
        //'create_salary_sheet_delete'            => 118,  //No Need
        'create_salary_sheet_send'              => 119,
        'create_salary_sheet_print'             => 120,

        'create_salary_transfer_letter_read'    => 121,
        'create_salary_transfer_letter_add'     => 122,
        'create_salary_transfer_letter_print'   => 159,

        'create_ot_transfer_letter_read'        => 123,
        'create_ot_transfer_letter_add'         => 124,
        'create_ot_transfer_letter_print'       => 160,

        'create_company_pf_read'                => 125,
        'create_company_pf_add'                 => 126,
        'create_company_pf_update'              => 127,
        'create_company_pf_delete'              => 128,

        'deposit_salary_tax_read'               => 129,
        'deposit_salary_tax_add'                => 130,
        'deposit_salary_tax_update'             => 131,
        //'deposit_salary_tax_delete'             => 132, //No Need
        'deposit_salary_tax_print'              => 133,

        'pay_pf_read'                           => 134,
        'pay_pf_add'                            => 135,
        'pay_pf_print'                          => 136,

        'sms_campaign_read'                     => 137,
        'sms_campaign_add'                      => 138,
        'sms_campaign_update'                   => 139,
        'sms_campaign_delete'                   => 140,
        'sms_campaign_send'                     => 141,

        'gratuity_read'                         => 142,
        'gratuity_add'                          => 143,
        'gratuity_update'                       => 144,
        'gratuity_delete'                       => 145,
        'gratuity_print'                        => 146,

        'earning_adjustment_report'             => 147,
        'deduction_adjustment_report'           => 148,
        'pf_summary_report'                     => 149,
        'pf_detail_report'                      => 150,
        'salary_sheet_report'                   => 151,
        'payslip_report'                        => 152,
        'email_payslip_report'                  => 153,
        'salary_transfer_letter_report'         => 154,
        'salary_certificate_report'             => 155,
        'audit_trail_report'                    => 156,

        '108_summary_report'                    => 157,
        'post_jv_quickbooks'                    => 158,
        //Payroll End

        //Leave
        'create_leave_request'                  => 161,
        'verify_leave_request'                  => 162,
        'approve_leave_request'                 => 163,
        'leave_balance_transfer'                => 164,

        'create_leave_request_for_others'       => 168,

        'leave_individual_report'               => 165,
        'rejected_leave_report'                 => 166,
        'leave_all_report'                      => 167,

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
