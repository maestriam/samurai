<?php

namespace Maestriam\Samurai\Traits\Theme;

use Exception;
use Illuminate\Support\Facades\File;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Exceptions\ThemeExistsException;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;

/**
 * Funcionalidades de acessórios(getters/setters)
 * para definição de vendor, classe Models/Theme
 */
trait Construction
{
    /**
     * Cria um novo diretório para construção de um tema
     * Retorna true em caso de sucesso na criação do tema
     *
     * @return Theme|null
     */
    public function build()
    {
        if ($this->exists()) {
            throw new ThemeExistsException($this->name);
        }

        $this->mkStructure();
        $this->mkComposer();

        return $this;
    }

    /**
     * Retorna a preview de como ficará o arquivo composer.json
     * do tema que será criado
     *
     * @param array $answers
     * @return string
     */
    public function preview() : string
    {
        if ($this->exists()) {
            throw new ThemeExistsException($this->name);
        }

        return $this->getComposer();
    }

    /**
     * Envia os assets para o diretório público do projeto
     *
     * @return boolean
     */
    public function publish() : bool
    {
        if (! $this->exists()) {
            throw new ThemeNotFoundException($this->name);
        }

        $from = $this->assetPath();
        $to   = $this->publicPath();

        File::copyDirectory($from, $to);

        return (is_dir($to)) ? true : false;
    }

    /**
     * Define o tema como padrão para ser usado no projeto
     *
     * @return boolean
     */
    public function use() : bool
    {
        if (! $this->exists()) {
            throw new ThemeNotFoundException($this->name);
        }

        $steps[] = $this->file()->clearCache();
        $steps[] = $this->publish();
        $steps[] = $this->setCurrent();

        $this->load();

        return (in_array(false, $steps)) ? false : true;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private final function mkStructure() : bool
    {
        $paths[] = $this->path;
        $paths[] = $this->assetPath();
        $paths[] = $this->filePath();

        foreach ($paths as $path) {
            $this->file()->mkFolder($path);
        }

        return true;
    }

    /**
     * Registra o tema no arquivo de ambiente do projeto
     *
     * @return boolean
     */
    private function setCurrent() : bool
    {
        $key = $this->config()->env();

        $this->env()->set($key, $this->vendor);

        $current = $this->env()->get($key);

        return ($current == $this->vendor) ? true : false;
    }
}
