<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Configurações de exceptions e mensagens de erros
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    '0101' => [
        'const' => 'INVALID_THEME_NAME_CODE',
        'msg'   => 'The name "%s" is an invalid. Its not possible to create an theme with special characters and start number.',
        'class' => Maestriam\Samurai\Exceptions\InvalidThemeNameException::class,
        'bash'  => 'theme.invalid',
    ],
    '0102' => [
        'const' => 'THEME_NOT_FOUND_CODE',
        'msg'   => 'Theme %s not found. Check the theme name and try again.',
        'class' => Maestriam\Samurai\Exceptions\ThemeNotFoundException::class,
        'bash'  => 'theme.not-found',
    ],
    '0103' => [
        'const' => 'THEME_EXISTS_CODE',
        'msg'   => 'The theme "%s" alredy exists on project.',
        'class' => Maestriam\Samurai\Exceptions\ThemeExistsException::class,
        'bash'  => 'theme.exists',
    ],
    '0104' => [
        'const' => 'INVALID_AUTHOR_CODE',
        'msg'   => 'The author name "%s" is an invalid author name.',
        'class' => Maestriam\Samurai\Exceptions\InvalidAuthorException::class,
        'bash'  => 'author.invalid',
    ],
    '0201' => [
        'const' => 'INVALID_DIRECTIVE_NAME_CODE',
        'msg'   => 'The :name is an invalid name. Its not possible to create an directive with special characters and start number.',
        'class' => Maestriam\Samurai\Exceptions\InvalidDirectiveNameException::class,
        'bash'  => 'directive.invalid',
    ],
    '0202' => [
        'const' => 'DIRECTIVE_EXISTS_CODE',
        'msg'   => 'The %s directive alredy exists in %s theme.',
        'class' => Maestriam\Samurai\Exceptions\DirectiveExistsException::class,
        'bash'  => 'directive.exists',
    ],
    '0203' => [
        'const' => 'INVALID_TYPE_DIRECTIVE_CODE',
        'msg'   => 'The :type is a invalid type.',
        'class' => Maestriam\Samurai\Exceptions\InvalidTypeDirectiveException::class,
        'bash'  => 'directive.type',
    ],
    '0301' => [
        'const' => 'ENV_NOT_FOUND_CODE',
        'msg'    => 'File .env not found.',
        'class' => Maestriam\Samurai\Exceptions\EnvNotFoundException::class,
        'bash'  => 'env.not-found',
    ],
    '0401' => [
        'const' => 'STUB_NOT_FOUND_CODE',
        'msg'    => 'The stub file required is not found.',
        'class' => Maestriam\Samurai\Exceptions\StubNotFoundException::class,
        'bash'  => 'stub.not-found',
    ],
];