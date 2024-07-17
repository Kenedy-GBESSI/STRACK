<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application version
    |--------------------------------------------------------------------------
    |
    | This value is the version  of your application. This value is used when the
    | framework needs to place the application's version in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'version' => env('APP_CUSTOM_VERSION', '1.0'),

    /**
     * The number of models/records to return for pagination.
     *
     * @var int
     */
    'records_per_page' => 50,

    /**
     * The default date format to use across the app.
     *
     * @var string
     */
    'default_date_format' => 'd/m/Y',
];
