<?php

namespace Maestriam\Samurai\Traits;

use Exception;
use Maestriam\Samurai\Models\Theme;
use Illuminate\Support\Facades\Config;
use Maestriam\Samurai\Models\Directive;

/**
 * Funções de domínio de todos os manipuladores
 */
trait HandlerFunctions
{
    /**
     * Retorna o tipos de diretivas que podem ser criadas
     *
     * @return array
     */
    public final function types() : array
    {
        $species = Config::get('Samurai.species');

        return $species;
    }

    /**
     * Retorna o nível de permissão para criação da diretiva
     *
     * @return int
     */
    public final function permission() : int
    {
        $permission = (int) Config::get('Samurai.permission');

        return (! $permission) ? 0755 : $permission;
    }

    /**
     * Retorna a localização de onde é armazenado determinado tipo
     * de diretiva dentro de um tema
     *
     * @param string $type
     * @return array
     */
    public final function structure(string $type = null)
    {
        if ($type == null) {
            return Config::get('Samurai.themes.structure');
        }

        return Config::get('Samurai.themes.structure.'. $type);
    }

    /**
     * Retorna o diretório base para o armazenamento de temas
     *
     * @return string
     */
    public final function baseFolder() : string
    {
        return Config::get('Samurai.themes.folder');
    }

    /**
     * Verifica se o tipo de diretiva informada faz parte
     * do ecossistema do Blade
     *
     * @param string $type
     * @return boolean
     */
    private function isValidDirectiveType(string $type)
    {
        $species = $this->types();

        return in_array($type, $species);
    }

    /**
     * Retorna o caminho de uma diretiva de acordo com os padrões
     * do Laravel Blade
     *
     * @param string $aliasTheme
     * @param string $type
     * @param string $file
     * @return string
     */
    private final function getBladePathDirective(Directive $obj) : string
    {
        $base = $this->structure($obj->type);
        $base = str_replace(DS, '.', $base);

        $filename = sprintf("%s.%s-%s", $obj->name, $obj->name, $obj->type);
        $format   = "%s::%s%s";

        return sprintf($format, $obj->theme->namespace, $base, $filename);
    }

    /**
     * Retorna o nome para o registro do tema na aplicação Laravel
     *
     * @return string
     */
    private final function getThemeNamespace($name) : string
    {
        $prefix = Config::get('Samurai.nomenclature.prefix.theme');

        return $prefix . $name;
    }

    /**
     * Retorna o caminho completo da diretiva
     *
     * @param string $theme
     * @param string $name
     * @return string
     */
    private final function directivePath($theme, $name, $type) : string
    {
        $name = strtolower($name);
        $base = $this->themePath($theme);
        $dir  = $this->structure($type);

        return $base  . DS . $dir . $name;
    }

    /**
     * Retorna o caminho completo com o nome
     *
     * @param string $path
     * @param string $name
     * @param string $type
     * @return string
     */
    private final function directiveFileName(string $path, string $name, string $type) : string
    {
        return $path .  DS  . $name . '-' .$type . '.blade.php';
    }

    /**
     * Verifica se um tema já existe com o nome específicado
     *
     * @param string $name
     * @return boolean
     */
    private final function themeExists(string $name) : bool
    {
        $dir  = $this->baseFolder();
        $path = $dir . DS . $name;

        return (is_dir($path));
    }

    /**
     * Retorna um objeto com todas as informações de uma diretiva
     *
     * @param string $name
     * @param string $theme
     * @param string $path
     * @param string $type
     * @return Directive
     */
    private final function objectDirective(string $name, string $themeName, string $type) : Directive
    {
        if (! $this->isValidDirectiveType($type)) {
            throw new Exception('Tipo inválido');
        }

        $theme = $this->objectTheme($themeName);
        $path  = $this->directivePath($themeName, $name, $type);
        $file  = $this->directiveFileName($path, $name, $type);

        $directive = new Directive();

        $directive->name  = $name;
        $directive->theme = $theme;
        $directive->path  = $file;
        $directive->type  = $type;

        return $directive;
    }

    /**
     * Retorna o caminho absoluto do tema
     *
     * @param string $name
     * @return string
     */
    private final function themePath(string $name) : string
    {
        $name = strtolower($name);
        $base = $this->baseFolder();

        return $base . DS . $name;
    }

    /**
     * Retorna um objeto com todas as propriedades do tema
     *
     * @param string $name
     * @param string $path
     * @return Theme
     */
    private final function objectTheme($name) : Theme
    {
        $theme = new Theme();

        $theme->name = $name;
        $theme->path = $this->themePath($name);
        $theme->namespace = $this->getThemeNamespace($name);

        return $theme;
    }
}
