<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Padrões de nomenclatura de tema
    |--------------------------------------------------------------------------
    |
    */
    'prefix'        => 'samurai-theme',
    'env_key'       => 'THEME_CURRENT',
    'env_file'      => '.env.testing',
    'publishable'   => 'assets',
    'description'   => 'A new awsome theme is comming!',
    'template_path' => __DIR__ . '/../stubs/',

    /*
    |--------------------------------------------------------------------------
    | Tipos de diretivas permitidos
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

    'themes' => [
        'files'     => 'src',
        'assets'    => 'assets',
        'folder'    => __DIR__ . '/../sandbox',
    ],

    'author' => [
        'name'  => 'Giuliano Sampaio',
        'dist'  => 'maestriam',
        'email' => 'giuguitar@gmail.com',
    ],

    'structure' => [
        'composer'  => '.', 
        'include'   => 'src/',
        'component' => 'src/',
    ]










    
    // 'prefix' => 'samurai-theme',


    
    // 'species' => [
    //     'component', 'include'
    // ],

    // /*
    // |--------------------------------------------------------------------------
    // | Estrutura de criação de diretórios
    // |--------------------------------------------------------------------------
    // |
    // | This option controls the default authentication "guard" and password
    // | reset options for your application. You may change these defaults
    // | as required, but they're a perfect start for most applications.
    // |
    // */
    // 'themes' => [
    //     'files'     => 'src',
    //     'assets'    => 'assets',
    //     'folder'    => base_path('themes'),
    // ],

    // /*
    // |--------------------------------------------------------------------------
    // | Estrutura de criação de diretórios
    // |--------------------------------------------------------------------------
    // |
    // | This option controls the default authentication "guard" and password
    // | reset options for your application. You may change these defaults
    // | as required, but they're a perfect start for most applications.
    // |
    // */
    // 'author' => [
    //     'name'   => 'Giuliano Sampaio',
    //     'dist'   => 'maestriam',
    //     'email'  => 'giuguitar@gmail.com',
    // ],

    // /*
    // |--------------------------------------------------------------------------
    // | Diretório publicável
    // |--------------------------------------------------------------------------
    // |
    // | This option controls the default authentication "guard" and password
    // | reset options for your application. You may change these defaults
    // | as required, but they're a perfect start for most applications.
    // |
    // */
    // 'publishable' => 'assets',

    // /*
    // |--------------------------------------------------------------------------
    // | Configurações no arquivo .env
    // |--------------------------------------------------------------------------
    // |
    // | This option controls the default authentication "guard" and password
    // | reset options for your application. You may change these defaults
    // | as required, but they're a perfect start for most applications.
    // |
    // */
    // 'env_key'   => 'THEME_CURRENT',

    // /*
    // |--------------------------------------------------------------------------
    // | Configurações no arquivo .env
    // |--------------------------------------------------------------------------
    // |
    // | This option controls the default authentication "guard" and password
    // | reset options for your application. You may change these defaults
    // | as required, but they're a perfect start for most applications.
    // |
    // */
    // 'description'   => 'A new awsome theme is comming!',


    // 'template_path' => __DIR__ . '/../tests/',
];
