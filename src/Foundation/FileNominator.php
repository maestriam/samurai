<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

/**
 * Classe auxiliar para nomeação de diretivas/namespaces 
 * de acordo com as regras negócios do Blade
 */
class FileNominator
{
    /**
     * Retorna o nome da diretiva para ser usado
     * como nome de arquivo
     *
     * @param string $name
     * @param string $type
     * @return string
     */
    public function directive(string $name, string $type) : string
    {
        return $name . '-' .$type;
    }

    /**
     * Retorna como deve ser o nome do arquivo de uma diretiva
     * com os padrões impostos pelo Blade.  
     *
     * @param string $name
     * @param string $type
     * @return void
     */
    public function filename(string $name, string $type) : string
    {
        return $this->directive($name, $type) . '.blade.php';
    }

    /**
     * Retorna o nome para o ser chamado dentro do
     * projeto Blade
     *
     * @param string $theme
     * @param string $path
     * @return void
     */
    public function blade(string $theme, string $path)
    {
        $pattern = "%s::%s";
        $ext = '.blade.php';

        $file = sprintf($pattern, $theme, $path);
        $file = str_replace(DS, '.', $file);
        $file = str_replace($ext, '', $file);

        return $file;
    }

    /**
     * Retorna o nome para ser chamado dentro do arquivo Blade
     *
     * @param string $name
     * @return string
     */
    public function alias(string $name) : string
    {
        return Str::kebab($name);
    }
}
