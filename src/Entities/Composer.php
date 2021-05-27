<?php

namespace Maestriam\Samurai\Entities;

class Composer extends Source
{
    
    /**
     * Caminho absoluto do arquivo
     */
    private string $path;

    /**
     * Descrição do tema
     */
    private string $desc;

    /**
     * Nome do template
     */
    protected string $template = 'composer';    

    /**
     * Instância com as regras de negócio sobre composer.json
     *
     * @param Vendor $vendor
     * @param string $desc
     */
    public function __construct(Theme $theme, string $desc = null)
    {
        $this->setTheme($theme);

        if ($desc) {
            $this->description($desc);
        }
    }

    /**
     * Retorna/Define a descrição do tema 
     * Se passar uma string como parâmetro, assume a função de definição
     *
     * @param string $desc
     * @return string|Composer
     */
    public function description(string $desc = null) : string|Composer
    {
        if (! $desc) {
            return $this->getDescription();
        }

        return $this->setDescription($desc);
    }

    /**
     * Verifica se o arquivo já existe dentro do tema
     *
     * @return boolean
     */
    public function exists() : bool
    {
        return $this->fileExists();
    }

    /**
     * Executa a criação de um composer.json dentro do tema
     *
     * @return Composer
     */
    public function create() : Composer
    {
        $info = $this->createFile();

        $this->setPath($info->absolute_path);

        return $this;
    }

    /**
     * Retorna o caminho do arquivo composer.json dentro do tema
     *
     * @return string|null
     */
    public function path() : ?string
    {
        return $this->path;
    }

    /**
     * {@inheritDoc}
     */
    protected function placeholders() : array
    {
        return [
            'description' => $this->description(),
            'authorName'  => $this->theme->author()->name(),
            'authorEmail' => $this->theme->author()->email(),
            'package'     => $this->theme->vendor()->package(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function filename() : string
    {
        return 'composer.json';
    }

    /**
     * Define a descrição do tema
     *
     * @param string $desc
     * @return Composer
     */
    private function setDescription(string $desc) : Composer
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Retorna a descrição do tema  
     * Se não houver uma descrição definida, retorna a descrição padrão
     * inserida no arquivo config.php 
     *
     * @return string
     */
    private function getDescription() : string
    {
        return $this->desc ?? $this->config()->description();
    }

    /**
     * Define o caminho completo do arquivo composer.json dentro do tema
     *
     * @param string $path
     * @return Composer
     */
    private function setPath(string $path) : Composer
    {
        if (! is_file($path)) {
            throw new \Exception('');
        }

        $this->path = $path;
        return $this;
    }
}