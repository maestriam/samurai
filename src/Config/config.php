<?php

return [
    'prefix'        => 'samurai-theme',
    'env_key'       => 'THEME_CURRENT',
    'env_file'      => '.env',
    'publishable'   => 'themes',
    'description'   => 'A new awesome theme is comming!',
    'template_path' => __DIR__ . '/../../stubs/',

    'species' => [
        'component', 'include'
    ],

    'themes' => [
        'files'     => 'src',
        'assets'    => 'assets',
        'folder'    => base_path('themes'),
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
];
