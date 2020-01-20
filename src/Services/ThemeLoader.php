<?php

namespace Maestriam\Samurai\Services;

use Exception;
use Maestriam\Samurai\Traits\BasicConfig;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\DirectiveHandling;

class ThemeLoader
{
    use BasicConfig, ThemeHandling, DirectiveHandling;

    protected $theme = 'kabuto';

    /**
     * Processa toda o carregamento de diretivas de um tema
     * para ser usado nas views do Blade
     *
     * @return void
     */
    public function load()
    {
        if (! strlen($this->theme)) {
            return false;
        }

        if (! $this->theme()->baseExists()) {
            //throw new Exception('O tema definido não foi encontrado');
        }

        $this->scanTheme();

        return true;
    }

    /**
     * Define qual tema será utilizado para carregamento
     *
     * @param string $theme
     * @return ThemeLoader
     */
    public function setTheme(string $theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Retorna o nome do tema selecionado
     *
     * @return string
     */
    public function getTheme() : string
    {
        return $this->theme;
    }

    /**
     * Vasculha a pasta do tema selecionado e tenta encontrar
     * todas as diretivas para carregamento, de acordo com as
     * pastas selecionadas no arquivo de config.
     *
     * @return void
     */
    protected function scanTheme()
    {
        $theme = $this->getTheme();
        $types = $this->directive()->types();

        foreach ($types as $type) {

            $folders = $this->directive()->folders($theme, $type);

            if (empty($folders)) continue;

            foreach ($folders as $folder) {
                $this->scanDirectiveFolder($folder);
            }
        }
    }

    /**
     * Vasculha a pasta da diretiva para ser identificado para
     * o carregamento
     *
     * @return void
     */
    protected function scanDirectiveFolder($folder)
    {
        $theme = $this->getTheme();

        $scan  = scandir($folder);
        $files = array_splice($scan, 2);

        if (empty($files)) {
            return null;
        }

        $namespace = $this->theme()->namespace($theme);

        foreach($files as $file) {
            $this->directive()->import($namespace, $file);
        }
    }
}
