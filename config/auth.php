<?php

return [

    'defaults' => [
        'guard' => env( 'AUTH_GUARD', 'web' ),
        'passwords' => 'parents',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'parents',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'sanctum' => [
            'driver' => 'sanctum',
            'provider' => 'parents',
        ],

        'admin-token' => [
            'driver' => 'sanctum',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'parents' => [
            'driver' => 'eloquent',
            'model' => App\Models\PlayerParent::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'parents' => [
            'provider' => 'parents',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
