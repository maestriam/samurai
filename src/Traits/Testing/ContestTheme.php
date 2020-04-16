<?php

namespace Maestriam\Samurai\Traits\Testing;

use Config;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;

/**
 * 
 */
trait ContestTheme
{
    /**
     * Testa se o tema foi criado corretamente e todos os seus 
     * atributos estão retornando de forma correta
     *
     * @param mixed $name
     * @return void
     */
    private final function success($name = null, $author = null, $desc = null)
    {
        $exec  = $this->mount($name, $author, $desc);
        $theme = $exec->build();

        $this->contestTheme($theme);
    }
    
    private final function contestTheme($theme)
    {
        $this->contestObject($theme);
        $this->contestPath($theme->path);
        $this->contestName($theme->name);
        $this->contestNamespace($theme->namespace);
    }

    /**
     * Prepara o comando para criaçao de um tema
     *
     * @param string $name
     * @param string $author
     * @param string $desc
     * @return Theme
     */
    private final function mount($name = null, $author = null, $desc = null) : Theme
    {
        $exec = $this->theme($name);

        if ($author) {
            $exec->author($author);
        }

        if ($desc) {
            $exec->description($desc);
        }

        return $exec;
    }

    /**
     * Verifica se há erro de uma determinada exception
     *
     * @param mixed $name
     * @return void
     */
    private final function failure(string $error, $name = null, $author = null, $desc = null)
    {
        $class = $this->getErrorClass($error);

        $this->expectException($class);

        $exec = $this->mount($name, $author, $desc);

        $exec->build();
    }   

    /**
     * Testa se o objeto do tema tem todos os atributos definidos
     * corretamente
     *
     * @param mixed $theme
     * @return void
     */
    private final function contestObject($theme)
    {
        $this->assertInstanceOf(Theme::class, $theme);
        $this->assertObjectHasAttribute('path', $theme);
        $this->assertObjectHasAttribute('name', $theme);
        $this->assertObjectHasAttribute('namespace', $theme);
    }

    /**
     * Testa se o nome do tema foi definido corretamente
     *
     * @param mixed $name
     * @return void
     */
    private final function contestName($name)
    {
        $lower = strtolower($name);

        $this->assertStringContainsString($lower, $name, '', true);
    }

    /**
     * Testa se o caminho do tema foi criado corretamente e
     * se está acessível para leitra/escrita
     *
     * @param mixed $path
     * @return void
     */
    private final function contestPath($path)
    {
        $this->assertIsString($path);
        $this->assertDirectoryExists($path);
        $this->assertDirectoryIsReadable($path);
        $this->assertDirectoryIsWritable($path);
    }

    /**
     * Testa se o namespace do tema, para chamada no Laravel, 
     * está criado de maneira correta
     *
     * @param mixed $namespace
     * @return void
     */
    private final function contestNamespace($namespace)
    {
        $prefix  = Config::get('Samurai::prefix');
        $pattern = "/$prefix/";

        $this->assertRegExp($pattern, $namespace);
    }   
}
