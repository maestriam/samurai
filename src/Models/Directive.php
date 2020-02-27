<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Models\Structure;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;
use Maestriam\Samurai\Exceptions\InvalidTypeDirectiveException;

class Directive extends Structure
{
    /**
     * Nome da diretiva
     *
     * @var string
     */
    private $name = '';

    /**
     * Tipo da diretiva
     *
     * @var string
     */
    private $type = '';

    /**
     * Tema de origem
     *
     * @var Theme
     */
    private $theme;

    /**
     * Caminho do arquivo
     *
     * @var string
     */
    private $path = '';

    private function __construct(string $name, string $type, Theme $theme)
    {
        $this->setTheme($theme)
             ->setType($type)
             ->setName($name)
             ->setFilename($name);
    }

    public function create()
    {
    }


    public function load()
    {
    }

    public function findOrCreate()
    {

    }

    public function get()
    {

    }

    private function stub(string $placeholder)
    {

    }

    /**
     * Undocumented function
     *
     * @param Theme $theme
     * @return void
     */
    private function setTheme(Theme $theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     *
     *
     * @param string $folder
     * @return void
     */
    private function setFolder(string $folder)
    {
        $this->folder = $folder;
        return $this;
    }

    /**
     *
     *
     * @param string $name
     * @return void
     */
    private function setName(string $name)
    {
        if (! $this->valid->directive($name)) {
            throw new InvalidDirectiveNameException($name);
        }

        $this->name = $name;
        return $this;
    }

    /**
     * Define o nome do arquivo para ser chamado no projeto
     *
     * @param string $name
     * @return void
     */
    private function setFilename(string $name)
    {
        $file = $this->nominator->directive($name, $this->type);

        $this->filename = $file;
        return $this;
    }

    /**
     * Define o tipo da diretiva
     *
     * @param string $type
     * @return Directive
     */
    private function setType(string $type) : Directive
    {
        if ($this->valid->type($type)) {
            throw new InvalidTypeDirectiveException($type);
        }

        $this->type = $type;
        return $this;
    }
}
