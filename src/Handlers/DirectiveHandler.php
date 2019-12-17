<?php

namespace Maestriam\Katana\Handlers;

use Exception;
use Illuminate\Support\Facades\Blade;;
use Maestriam\Katana\Traits\BasicConfig;
use Maestriam\Katana\Traits\ThemeHandling;

class DirectiveHandler
{
    use BasicConfig, ThemeHandling;

    /**
     * Verifica todas as premissas para se criar uma nova diretiva
     * dentro de um tema específico
     *
     * @param string $type
     * @param string $theme
     * @param string $name
     * @return void
     */
    public function create($type, $theme, $name)
    {
        $path = $this->path($theme, $type, $name);
        $perm = $this->getPermissionLevel();

        mkdir($path, $perm, true);

        $this->materialize($type, $path, $name);
    }

    /**
     * Verifica se a já existe uma diretiva com determinado nome
     * em um tema específico
     *
     * @param string $type
     * @param string $theme
     * @param string $name
     * @return boolean
     */
    public function exists(string $type, string $theme, string $name) : bool
    {
        $dir = $this->path($theme, $type, $name);

        return (is_dir($dir)) ? true : false;
    }

    /**
     * Cria um arquivo de view do Blade para ser criado um novo
     * componente ou include
     *
     * @param string $path
     * @param string $name
     * @return void
     */
    public function materialize($type, $path, $name)
    {
        if (! $this->isValid($type)) {
            throw new Exception('Tipo de diretiva inválido');
        }

        $content = $this->stub($type, $name);

        $file = $path .  DS  . $name . '-' .$type . '.php';

        $handle  = fopen($file, 'w');

        fwrite($handle, $content);
        fclose($handle);
    }

    /**
     * Retorna a estrutura de pastas dentro do tema de acordo
     * com o tipo de diretiva selecionada (include/component)
     *
     * @param string $theme
     * @return string
     */
    public function folders(string $theme, string $type) : array
    {
        if (! $this->isValid($type)) {
            return [];
        }

        $path = $this->path($theme, $type);

        if (! is_dir($path)) {
            return [];
        }

        $folders = [];
        $scan    = scandir($path);
        $dirs    = array_splice($scan, 2);

        foreach ($dirs as $dir) {
            $folders[] = $path . $dir;
        }

        return $folders;
    }

    /**
     * Verifica se o tipo de diretiva informada faz parte
     * do ecossistema do Blade
     *
     * @param string $directive
     * @return boolean
     */
    public function isValid(string $directive) : bool
    {
        $species = $this->types();

        return in_array($directive, $species);
    }

    /**
     * Retorna o tipos de diretivas que podem ser criadas
     *
     * @return array
     */
    public function types() : array
    {
        $species = ['component', 'include'];

        return $species;
    }

    /**
     * Retorna o caminho completo da diretiva
     *
     * @param string $theme
     * @param string $name
     * @return string
     */
    public function path(string $theme, string $type, string $name = null) : string
    {
        $name   = strtolower($name);
        $type   = strtolower($type);
        $theme  = strtolower($theme);

        $key    = 'themes.structure.' . $type;
        $folder = $this->getThemeConfig('themes.folder');
        $dir    = $this->getThemeConfig($key);

        return $folder . DS . $theme . DS . $dir . $name;
    }

    /**
     * Retorna o conteúdo do arquivo de base para criação
     * de components e includes
     *
     * @param string $type
     * @param string $placeholder
     * @return string
     */
    public function stub($type, $placeholder) : string
    {
        $path = __DIR__ . DS .  "../Stubs/{$type}.stub";
        $stub = file_get_contents($path);

        return str_replace('{{name}}', $placeholder, $stub);
    }

    /**
     * Identifica que tipo de diretiva que se trata o arquivo
     * e retorna seu tipo
     *
     * @param $file
     * @return void
     */
    public function identify($file)
    {
        $name = explode('-', $file);

        if (empty($name)) return null;

        $type = explode('.', $name[1]);

        if (empty($type) || ! $this->isValid($type[0])) return null;

        $obj = ['type' => $type[0], 'name' => $name[0]];

        return (object) $obj;
    }


    /**
     * Verifica o tipo de diretiva se
     *
     * @param [type] $alias
     * @param [type] $file
     * @return void
     */
    public function import($alias, $file)
    {
        $directive = $this->identify($file);

        if (! $directive) {
            return null;
        }

        $path = $this->bladePath($alias, $directive->type, $directive->name);

        if ($directive->type == 'component') {
            return Blade::component($path, $directive->name);
        }

        Blade::include($path, $directive->name);
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
    protected function bladePath($aliasTheme, $type, $file) : string
    {
        $base = $this->getThemeConfig('themes.structure.'. $type);
        $base = str_replace('/', '.', $base);

        $filename = sprintf("%s.%s-%s", $file, $file, $type);

        $format = "%s::%s%s";

        return sprintf($format, $aliasTheme, $base, $filename);
    }
}
