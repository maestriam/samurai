<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Padrões de nomenclatura de tema
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    'prefix' => 'samurai-theme',


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

    /*
    |--------------------------------------------------------------------------
    | Estrutura de criação de diretórios
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    'themes' => [
        'files'     => 'src',
        'assets'    => 'assets',
        'folder'    => base_path('themes'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Estrutura de criação de diretórios
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    'author' => [
        'name'   => 'Giuliano Sampaio',
        'vendor' => 'maestriam',
        'email'  => 'giuguitar@gmail.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Diretório publicável
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    'publishable' => 'assets',

    /*
    |--------------------------------------------------------------------------
    | Configurações no arquivo .env
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    'env_key'   => 'THEME_CURRENT',

    /*
    |--------------------------------------------------------------------------
    | Configurações no arquivo .env
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    'description'   => 'A new awsome theme is comming!',


    'template_path' => __DIR__ . '/../tests/',
];
