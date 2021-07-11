<?php

namespace Maestriam\Samurai\Entities;

use Exception;
use Maestriam\Samurai\Contracts\Entities\ComposerContract;
use Maestriam\Samurai\Exceptions\InvalidComposerFileException;

class Composer extends Source implements ComposerContract
{

    
    /**
     * Caminho absoluto do arquivo
     * 
     * @var string
     */
    private string $path;

    /**
     * Descrição do tema
     * 
     * @var string
     */
    private string $desc;

    /**
     * Informações 
     * 
     * @var object
     */
    private object $info;

    /**
     * Nome do template
     * 
     * @var string
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
     * {@inheritDoc}
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
     * Carrega as informações do arquivo composer.json, dentro do tema.  
     *
     * @return Composer
     */
    public function load() : Composer
    {
        $pack = $this->theme()->package();
        
        $content = $this->loadContent();

        $json = json_decode($content);        

        if (! $this->isValid($json)) {           
            throw new InvalidComposerFileException($pack);
        }       
        
        return $this->extract($json);
    }

    /**
     * Retorna as informações do arquivo composer.json
     *
     * @return object
     */
    public function info() : object
    {
        return $this->info;
    }

    /**
     * {@inheritDoc}
     */
    public function preview() : string
    {
        return $this->previewContent();
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
            'authorName'  => $this->theme()->author()->name(),
            'authorEmail' => $this->theme()->author()->email(),
            'package'     => $this->theme()->vendor()->package(),
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
     * @param  string $desc
     * @return Composer
     */
    private function setDescription(string $desc) : Composer
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Define as informações extraídas do 
     *
     * @param  object $info
     * @return Composer
     */
    private function setInfo(object $info) : Composer
    {
        $this->info = $info;

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
     * Verifica se o arquivo composer do tema é válido
     *
     * @param  object $json
     * @return boolean
     */
    private function isValid(object $json) : bool
    {
        $keys = ['name', 'description', 'type', 'require', 'authors'];

        foreach ($keys as $k) {            
            if (! property_exists($json, $k) || $json->$k == null) {
                return false;   
            }            
        }

        if (! is_array($json->authors) || empty($json->authors)) {
            return false;
        }

        return true;
    }
    
    /**
     * Pega as informações do arquivo Json
     *
     * @param  object $json
     * @return Composer
     */
    private function extract(object $json) : Composer
    {
        $this->setInfo($json)->description($json->description);

        return $this;
    }

    /**
     * Define o caminho completo do arquivo composer.json dentro do tema
     *
     * @param  string $path
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
