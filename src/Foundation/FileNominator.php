<?php

namespace Maestriam\Samurai\Foundation;

use Illuminate\Support\Str;

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
     * @param  string $name
     * @param  string $type
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
     * @param  string $name
     * @param  string $type
     * @return string
     */
    public function filename(string $name, string $type) : string
    {
        return $this->directive($name, $type) . $this->extension();
    }

    /**
     * Retorna o nome para o ser chamado dentro do
     * projeto Blade
     *
     * @param  string $theme
     * @param  string $path
     * @return string
     */
    public function blade(string $theme, string $path, string $DS = DS) : string
    {
        $ext = $this->extension();        
        
        $path = str_replace($DS, '.', $path);
        $path = str_replace($ext, '', $path);            

        $file = sprintf("%s::%s", $theme, $path);

        return $file;
    }

    /**
     * Retorna a extensão do arquivo blade dentro do projeto.  
     *
     * @return string
     */
    public function extension() : string
    {
        return '.blade.php';
    }

    /**
     * Retorna o nome para ser chamado dentro do arquivo Blade,
     * como kebab-case
     *
     * @param  string $name
     * @return string
     */
    public function kebabAlias(string $name) : string
    {
        return Str::kebab($name);
    }

    /**
     * Retorna o nome para ser chamado dentro do arquivo Blade,
     * como kebab-case
     *
     * @param  string $name
     * @return string
     */
    public function camelAlias(string $name) : string
    {
        return Str::camel($name);
    }
}
