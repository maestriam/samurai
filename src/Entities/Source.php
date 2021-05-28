<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\FileSystem\Foundation\Drive;
use Maestriam\FileSystem\Foundation\File\FileInfo;
use Maestriam\FileSystem\Support\FileSystem;

abstract class Source extends Foundation
{
    /**
     * Tema qual o arquivo pertence
     */
    protected Theme $themeInstance;

    /**
     * Nome do template
     */
    protected string $template;

    /**
     * Retorna os dados para a geração do arquivo composer.json
     *
     * @return array
     */
    abstract protected function placeholders() : array;
    
    /**
     * Retorna o nome do arquivo 
     *
     * @return string
     */
    abstract protected function filename() : string;
   
    /**
     * Define o tema que será 
     *
     * @param Theme $theme
     * @return self
     */
    protected function setTheme(Theme $theme) : self
    {
        $this->themeInstance = $theme;
        return $this;
    }

    /**
     * Retorna a instância do tema
     *
     * @return Theme
     */
    protected function theme() : Theme
    {
        return $this->themeInstance;
    }

    /**
     * Retorna o drive para a manipulação de arquivos dentro do tema.    
     * Se não houver drive criado para o tema, configura um novo drive.  
     *
     * @return Drive
     */
    private function getDrive() : Drive
    {
        $name = $this->theme()->vendor()->package();

        $drive = FileSystem::drive($name);

        return ($drive->exists()) ? $drive : $this->initDrive($drive);
    }

    /**
     * Configura um novo drive para criação de tema   
     *
     * @param Drive $drive
     * @return Drive
     */
    private function initDrive(Drive $drive) : Drive
    {
        $root = $this->theme()->paths()->root();
        $stub = $this->config()->template();
        $path = $this->config()->structure();

        $drive->structure()->root($root);
        $drive->structure()->template($stub);
        $drive->structure()->paths($path);

        $drive->save();

        return $drive;
    }

    /**
     * Executa a criação do arquivo, baseado em um template
     *
     * @return void
     */
    protected function createFile() : FileInfo
    {
        $drive    = $this->getDrive();
        $filename = $this->filename();
        $holders  = $this->placeholders();

        return $drive->template($this->template)->create($filename, $holders);
    }

    /**
     * Verifica se o arquivo existe, de acordo com o template
     *
     * @return boolean
     */
    protected function fileExists() : bool
    {
        $drive    = $this->getDrive();
        $template = $this->template;
        $filename = $this->filename();

        return $drive->template($template)->exists($filename);
    }
}