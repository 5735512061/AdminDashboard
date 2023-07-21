<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'api-admin' => [
            'driver' => 'token',
            'provider' => 'admins',
        ],

        'staff' => [
            'driver' => 'session',
            'provider' => 'staffs',
        ],

        'api-staff' => [
            'driver' => 'token',
            'provider' => 'staffs',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Admin::class,
        ],

        'staffs' => [
            'driver' => 'eloquent',
            'model' => App\Employee::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 15,
        ],

        'staffs' => [
            'provider' => 'staffs',
            'table' => 'password_resets',
            'expire' => 15,
        ],
    ],

];
