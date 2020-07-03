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
        'company_info_update'               => 1,

        'signatory_add'                     => 2,
        'signatory_update'                  => 3,
        'signatory_delete'                  => 4,

        'voucher_format_add'                => 5,
        'voucher_format_update'             => 6,
        'voucher_format_delete'             => 7,

        'currency_add'                      => 8,
        'currency_update'                   => 9,
        'currency_delete'                   => 10,

        'payment_method_add'                => 11,
        'payment_method_update'             => 12,
        'payment_method_delete'             => 13,

        'bank_add'                          => 14,
        'bank_update'                       => 15,
        'bank_delete'                       => 16,

        'bank_account_add'                  => 17,
        'bank_account_update'               => 18,
        'bank_account_delete'               => 19,

        'cheque_book_add'                   => 20,
        'cheque_book_update'                => 21,
        'cheque_book_delete'                => 22,

        'cheque_layout_add'                 => 23,
        'cheque_layout_update'              => 24,
        'cheque_layout_delete'              => 25,

        'user_add'                          => 26,
        'user_update'                       => 27,
        'user_delete'                       => 28,

        'roles_add'                         => 29,
        'roles_update'                      => 30,
        'roles_delete'                      => 31,
        //Master-Setup-End
        
        'create_cheque_add'                 => 32,
        'create_cheque_approve'             => 33,
        'create_cheque_reject'              => 34,
        'create_cheque_void'                => 35,
        'create_cheque_print'               => 36,

        'create_mr_add'                     => 37,
        'create_mr_approve'                 => 38,
        'create_mr_reject'                  => 39,
        'create_mr_void'                    => 40,
        'create_mr_print'                   => 41,

        'tr_cash_payment_voucher_add'       => 42,
        'tr_cash_payment_voucher_approve'   => 43,
        'tr_cash_payment_voucher_reject'    => 44,
        'tr_cash_payment_voucher_void'      => 45,
        'tr_cash_payment_voucher_print'     => 46,

        'tr_bank_payment_voucher_add'       => 47,
        'tr_bank_payment_voucher_approve'   => 48,
        'tr_bank_payment_voucher_reject'    => 49,
        'tr_bank_payment_voucher_void'      => 50,
        'tr_bank_payment_voucher_print'     => 51,

        'tr_cash_receipt_voucher_add'       => 52,
        'tr_cash_receipt_voucher_approve'   => 53,
        'tr_cash_receipt_voucher_reject'    => 54,
        'tr_cash_receipt_voucher_void'      => 55,
        'tr_cash_receipt_voucher_print'     => 56,

        'tr_bank_receipt_voucher_add'       => 57,
        'tr_bank_receipt_voucher_approve'   => 58,
        'tr_bank_receipt_voucher_reject'    => 59,
        'tr_bank_receipt_voucher_void'      => 60,
        'tr_bank_receipt_voucher_print'     => 61,

        'tr_void_voucher_add'               => 62,
        'tr_void_voucher_approve'           => 63,
        'tr_void_voucher_reject'            => 64,
        'tr_void_voucher_void'              => 65,
        'tr_void_voucher_print'             => 66,

        'tr_contra_voucher_add'             => 67,
        'tr_contra_voucher_approve'         => 68,
        'tr_contra_voucher_reject'          => 69,
        'tr_contra_voucher_void'            => 70,
        'tr_contra_voucher_print'           => 71,

        'tr_journal_voucher_add'            => 72,
        'tr_journal_voucher_approve'        => 73,
        'tr_journal_voucher_reject'         => 74,
        'tr_journal_voucher_void'           => 75,
        'tr_journal_voucher_print'          => 76,

        //Transection-End

        'issued_voucher'                    => 77,
        'void_voucher'                      => 78,
        'issued_mr'                         => 79,
        'void_mr'                           => 80,
        'issued_cheque'                     => 81,
        'void_cheque'                       => 82,
        'audit_trail'                       => 83,

        //Report-End

        'printer_add'                       => 84,
        'printer_update'                    => 85,
        'printer_delete'                    => 86,

        'email_add_sent'                    => 87,

        'settings_update'                   => 88,

        'subscription'                      => 100
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
