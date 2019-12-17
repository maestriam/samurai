<?php

return [
    'nomenclature' => [
        'prefix' => [
            'theme' => 'katana-theme-',
        ]
    ],
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
