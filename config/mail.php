<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    */

    'mailers' => [

        /*
        |---------------------------------
        | Default SMTP (CRM / System)
        |---------------------------------
        */
        'smtp' => [
            'transport'  => 'smtp',
            'host'       => env('MAIL_HOST'),
            'port'       => env('MAIL_PORT'),
            'encryption' => env('MAIL_ENCRYPTION'),
            'username'   => env('MAIL_USERNAME'),
            'password'   => env('MAIL_PASSWORD'),
            'timeout'    => null,
        ],

        /*
        |---------------------------------
        | HR SMTP (Interview / HR mails)
        |---------------------------------
        */
        'hr_smtp' => [
            'transport'  => 'smtp',
            'host'       => env('HR_MAIL_HOST'),
            'port'       => env('HR_MAIL_PORT'),
            'encryption' => env('HR_MAIL_ENCRYPTION'),
            'username'   => env('HR_MAIL_USERNAME'),
            'password'   => env('HR_MAIL_PASSWORD'),
            'timeout'    => null,
        ],

        /*
        |---------------------------------
        | Admin SMTP (Admin alerts)
        |---------------------------------
        */
        'admin_smtp' => [
            'transport'  => 'smtp',
            'host'       => env('ADMIN_MAIL_HOST'),
            'port'       => env('ADMIN_MAIL_PORT'),
            'encryption' => env('ADMIN_MAIL_ENCRYPTION'),
            'username'   => env('ADMIN_MAIL_USERNAME'),
            'password'   => env('ADMIN_MAIL_PASSWORD'),
            'timeout'    => null,
        ],

        /*
        |---------------------------------
        | Log (Local testing)
        |---------------------------------
        */
        'log' => [
            'transport' => 'log',
            'channel'   => env('MAIL_LOG_CHANNEL'),
        ],

        /*
        |---------------------------------
        | Array (Testing)
        |---------------------------------
        */
        'array' => [
            'transport' => 'array',
        ],

        /*
        |---------------------------------
        | Failover
        |---------------------------------
        */
        'failover' => [
            'transport' => 'failover',
            'mailers'   => [
                'smtp',
                'log',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address (Default)
    |--------------------------------------------------------------------------
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'crm@bitmaxgroup.com'),
        'name'    => env('MAIL_FROM_NAME', 'Bitmax Group'),
    ],

    /*
    |--------------------------------------------------------------------------
    | HR "From" Address
    |--------------------------------------------------------------------------
    */

    'hr_from' => [
        'address' => env('HR_MAIL_FROM_ADDRESS', 'hr@bitmaxgroup.com'),
        'name'    => env('HR_MAIL_FROM_NAME', 'Bitmax Group'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin "From" Address
    |--------------------------------------------------------------------------
    */

    'admin_from' => [
        'address' => env('ADMIN_MAIL_FROM_ADDRESS', 'admin@bitmaxgroup.com'),
        'name'    => env('ADMIN_MAIL_FROM_NAME', 'Bitmax Group'),
    ],

];
