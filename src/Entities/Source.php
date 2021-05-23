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
    protected Theme $theme;

    /**
     * Nome do template
     */
    protected string $template;
   
    /**
     * Define o tema que será 
     *
     * @param Theme $theme
     * @return Source
     */
    protected function setTheme(Theme $theme) : Source
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * Retorna o drive para a manipulação de arquivos dentro do tema.    
     * Se não houver drive criado para o tema, configura um novo drive.  
     *
     * @return Drive
     */
    private function getDrive() : Drive
    {
        $name = $this->theme->vendor()->package();

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
        $root = $this->theme->paths()->root();
        $stub = $this->config()->template();
        $path = $this->config()->structure();

        $drive->structure()->root($root);
        $drive->structure()->template($stub);
        $drive->structure()->paths($path);

        $drive->save();

        return $drive;
    }

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
     * Executa a criação do arquivo, baseado em um template
     *
     * @return void
     */
    protected function createFile() : FileInfo
    {
        $holders  = $this->placeholders();
        $drive    = $this->getDrive();
        $filename = $this->filename();
        $template = $this->template;

        return $drive->template($template)->create($filename, $holders);
    }
}