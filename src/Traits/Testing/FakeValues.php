<?php

namespace Maestriam\Samurai\Traits\Testing;

use Str;
use Config;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;

/**
 * Funcionalidades básicas para ser usado 
 */
trait FakeValues
{    
    /**
     * Retorna um nome de um vendor/tema aleatório válido
     *
     * @return string
     */
    private final function fakeTheme() : string
    {
        $lenght = rand(0, 50);

        $vendor = 'vendor-' . Str::random($lenght);
        $theme  = 'theme-'  . Str::random($lenght);

        $name = strtolower($vendor . '/' . $theme);

        return $name;
    }

    /**
     * Retorna um nome de autor e e-mail aleatório válido
     *
     * @return string
     */
    private final function fakeAuthor() : string
    {
        $name  = Str::random(6);
        $email = $this->faker->email;
        
        $author = sprintf("%s <%s>", $name, $email);
        
        return $author;
    }
    
    /**
     * Retorna um nome de include aleatório válido
     *
     * @return string
     */
    private final function fakeInclude() : string
    {
        $prefix = 'include-';
        $name   = $this->faker->word();
        $suffix = Str::random(3);

        $include = $prefix . $name . $suffix;
        
        return $include;
    }
    
    /**
     * Retorna um nome de component aleatório válido
     *
     * @return string
     */
    private final function fakeComponent() : string
    {
        $prefix = 'component-';
        $name   = $this->faker->word();
        $suffix = Str::random(3);
        
        $component = $prefix . $name . $suffix;

        return $component;
    }
    
    /**
     * Retorna uma descrição aleatório válido
     *
     * @return string
     */
    private final function fakeDescription() : string
    {
        return $this->faker->text(60);
    }

    /**
     * Retorna a classe de erro de acordo com o indíce enviado
     *
     * @param integer $index
     * @return string
     */
    private final function getErrorClass(string $index) : string
    {
        $errors = Config::get('Samurai.errors');

        $class = $errors[$index]['class'];

        return $class;
    } 
}