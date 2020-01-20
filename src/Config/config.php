<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Padrões de nomenta Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    'nomenclature' => [
        'prefix' => [
            'theme' => 'samurai-theme-',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    'species' => [
        'component', 'include'
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    'themes' => [
        'default' => '',
        'folder'  => base_path('themes'),
        'structure' => [
            'js'        => 'assets/js/',
            'css'       => 'assets/css/',
            'imgs'      => 'assets/imgs/',
            'component' => 'src/components/',
            'include'   => 'src/includes/',
            'page'      => 'src/pages/',
        ]
    ]
];
